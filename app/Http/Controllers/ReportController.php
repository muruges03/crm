<?php

namespace App\Http\Controllers;

//use App\Exports\JournalExport;
//use App\Exports\PatronReportExport;
use App\Helpers\AppHelpers;
//use App\Helpers\CustomQuery;
use Symfony\Component\Process\Process;
use App\Models\Journal;
use App\Models\Ledger;
use App\Models\OmTicketSystem;
use App\Models\Patron;
use App\Models\Payment;
use App\Models\Personnel;
use App\Models\ServiceType;
use Barryvdh\Snappy\Facades\SnappyPdf;
use \PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\Snappy\Facades\SnappyImage;
use Debugbar;
use Illuminate\Support\Facades\Storage;

class ReportController extends Controller
{
    //
    public function index()
    {

        $employee = Personnel::where([['deleted', 0], ['entity_id', session('entity_id')]])->get(['first_name', 'id']);
        return Inertia::render('Report/Index', [
            'ledger' => Ledger::where('deleted', 0)->where('entity_id', session('entity_id'))->get(),
            'patron' => AppHelpers::instance()->patrons('', ''),
            'Employee' => $employee
        ]);
    }

    public function getLedger(Request $request)
    {
        $input = $request->all();
        //            dd($input);
        //            $this->validateJournal();
        if ($request->date != null) {
            $from_date = $request->date[0];
            $to_date = $request->date[1];
        }
        //
        $trans_id = [];
        $sum_asset = [];
        $sum_total = [];
        $opening_balance = [];

        $entity_id = session('entity_id');
        foreach ($request->ledger_id as $ledger_value) {
            //                dd($ledger_value['id']);
            $trans_id = Journal::join('ledger', 'journals.ledger_id', '=', 'ledger.id')
                ->where('journals.entity_id', session('entity_id'))
                ->where('journals.deleted', 0)->orderBy('entry_date')
                ->select(
                    'journals.transaction_id as transaction_id',
                    'journals.id as j_id',
                    'journals.debit_amount as debit_amount',
                    'journals.credit_amount as credit_amount',
                    'journals.entry_date as entry_date',
                    'journals.notes as notes',
                    'journals.narration as narration',
                    'ledger.title as title',
                    'journals.ledger_id as ledger_id'
                )
                ->when($from_date, function ($query, $from_date) {
                    $query->whereDate('entry_date', '>=', date($from_date));
                })->when($to_date, function ($query, $to_date) {
                    $query->whereDate('entry_date', '<=', date($to_date));
                })->where('journals.ledger_id', $ledger_value['id'])
                ->get();
            //dd($ledger_value['id']);
            $opening_balance[] = Journal::join('ledger', 'journals.ledger_id', '=', 'ledger.id')
                ->where('journals.entity_id', session('entity_id'))
                ->where('journals.deleted', 0)
                ->where('ledger_id', $ledger_value['id'])
                ->when($from_date, function ($query, $from_date) {
                    $query->whereDate('entry_date', '<', date($from_date));
                })
                ->select(DB::raw("SUM(journals.credit_amount-journals.debit_amount) as opening_amount"), 'ledger.title as title', 'journals.entry_date as entry_date', 'journals.ledger_id as ledger_id')
                //                    ->groupBy('ledger.id')
                ->get();
            //                dd($opening_balance);
            foreach ($trans_id as $item2 => $value2) {
                $sum_asset[] = array(
                    'ledger_name' => $value2['title'],
                    'credit_amount' => $value2['credit_amount'],
                    'debit_amount' => $value2['debit_amount'],
                    'entry_date' => $value2['entry_date'],
                    'notes'     => $value2['notes'],
                    'narration' => $value2['narration'],
                );
            }
        }
        //         dd($sum_asset);
        $sum_asset = collect($sum_asset)->groupBy('ledger_name');

        $entity = AppHelpers::instance()->entity(session('entity_id'), '');
        //            return view('Pdf/Report/journal', compact('entity','trans_id','input', 'opening_balance'));
        if ($opening_balance) {
            if ($request->pdfExcel == 0) {
                return view('Report/ledgerReport', compact('entity', 'trans_id', 'input', 'opening_balance', 'sum_asset'));
                $pdf = PDF::setOption('footer-html', "<footer style='text-align:center; color:#969BA7'>
                Powered By : <a style='font-size:24px; font-weight:600; color: #F9B5B5;'>Modoinfra.com</a></footer>")
                    ->setOption('footer-font-size', 10)->setOption('margin-bottom', 10)->loadView('Pdf/Report/journal', compact('entity', 'trans_id', 'input', 'opening_balance'))->setPaper('a4');
                return $pdf->stream('JournalReport.pdf');
            } else {
                $data = ['trans_id' => $trans_id, 'opening_balance' => $opening_balance, 'input' => $input, $sum_asset => 'sum_asset'];
                return Excel::download(new JournalExport($data), 'Ledger.xlsx');
                // return Excel::download('Pdf/Report/pettycash', compact('entity','pettycash','openingbal', 'input'));
            }
        } else {
            return Redirect::back();
        }
    }

    public function getPatron(Request $request)
    {
        $input = $request->all();
        //                    dd($input);
        //        $validate =  $this->validateJournal();
        if ($request->date != null) {
            $request->from_date = $request->date[0];
            $request->to_date = $request->date[1];
        }
        //        dd( $request->from_date);
        //            if(isset($request->patron_id))
        //            {
        //                $patron_id=$request->patron_id['id'];
        //            }else{
        //
        //            }
        $patron = Patron::where('entity_id', session('entity_id'))->where('deleted', 0)->get();
        $getValue = [];
        foreach ($patron as $value) {
            $patron1 = Journal::with('ledger')
                ->leftJoin('patrons', 'journals.patron_id', '=', 'patrons.id')
                ->where('journals.entity_id', session('entity_id'))
                ->where('journals.deleted', '=', 0)
                ->where('journals.patron_id', $value['id'])
                //            ->when($request->patron_id['id'], function ($query, $patron_id) {
                //                $query->where('journals.patron_id', $patron_id);
                //            })
                ->when($request->from_date, function ($query, $from_date) {
                    $query->whereDate('journals.entry_date', '>=', date($from_date));
                })->when($request->to_date, function ($query, $to_date) {
                    $query->whereDate('journals.entry_date', '<=', date($to_date));
                })->select(DB::raw("SUM(journals.credit_amount-journals.debit_amount) as outstanding"), 'journals.patron_id', 'patrons.legal_name', 'journals.credit_amount', 'journals.debit_amount')->get();
            //          dd($patron1);
            $opening = Journal::leftJoin('patrons', 'journals.patron_id', '=', 'patrons.id')
                ->where('journals.entity_id', session('entity_id'))
                ->where('journals.deleted', '=', 0)
                //            ->whereIn('journals.ledger_id', [7,10])
                ->where('journals.patron_id', $value['id'])
                //                ->when($request->patron_id['id'], function ($query, $patron_id) {
                //                    $query->where('journals.patron_id', $patron_id);
                //                })
                ->when($request->from_date, function ($query, $from_date) {
                    $query->whereDate('journals.entry_date', '>=', date($from_date));
                })->select(DB::raw("SUM(journals.credit_amount-journals.debit_amount) as opening"), 'journals.patron_id', 'patrons.legal_name', 'journals.credit_amount', 'journals.debit_amount')
                ->get();
            if (count($patron1) != 0) {
                foreach ($patron1 as $value2) {
                    $legal_name = null;
                    $patron_id = null;
                    $narration = null;
                    $credit_amount = null;
                    $debit_amount = null;
                    $outstanding = null;
                    //                foreach ($value1 as $value2) {

                    //                        $getValue[] = array(
                    $legal_name = $value2['legal_name'];
                    $patron_id = $value2['patron_id'];
                    $narration = $value2['narration'];
                    $credit_amount = $value2['credit_amount'];
                    $debit_amount = $value2['debit_amount'];
                    $entry_date = $value2['entry_date'];
                    $outstanding = $value2['outstanding'];
                    //                            'opening => $opening[0]['opening'] != null ? $opening[0]['opening'] : 0.00,
                    //                        );
                    //                    }

                    $getValue[] = array(
                        'legal_name' => $legal_name != null ? $legal_name : $opening[0]['legal_name'],
                        'patron_id' => $patron_id != null ? $patron_id : $opening[0]['patron_id'],
                        'narration' => $narration != null ? $narration : null,
                        'credit_amount' => $credit_amount != null ? $credit_amount : 0.00,
                        'debit_amount' => $debit_amount != null ? $debit_amount : 0.00,
                        'entry_date' => $entry_date != null ? $entry_date : null,
                        'opening' => $opening[0]['opening'] != null ? $opening[0]['opening'] : 0.00,
                        'outstanding' => $outstanding != null ? $outstanding : 0.00,
                    );
                }
            }
        }
        //    dd($getValue, $opening);
        $entity = AppHelpers::instance()->entity(session('entity_id'), '');
        //        dd($entity);
        if ($patron || $opening) {
            //                 return view('Pdf/Report/patronReport', compact('entity','patron','input', 'opening'));
            if ($request->pdfExcel == 0) {
                return view('Report/patronReport', compact('entity', 'getValue', 'patron', 'input', 'opening'));
                $pdf = PDF::setOption('footer-html', "<footer style='text-align:center; color:#969BA7'>
                Powered By : <a style='font-size:24px; font-weight:600; color: #F9B5B5;'>Modoinfra.com</a></footer>")
                    ->setOption('footer-font-size', 10)->setOption('margin-bottom', 10)->loadView('Pdf/Report/patronReport', compact('entity', 'patron', 'input', 'opening'))->setPaper('a4');
                return $pdf->stream('patronReport.pdf');
            } else {
                $data = ['patron' => $patron, 'opening' => $opening, 'input' => $input];
                return Excel::download(new PatronReportExport($data), 'PatronReport.xlsx');
                // return Excel::download('Pdf/Report/pettycash', compact('entity','pettycash','openingbal', 'input'));
            }
        } else {
            return Redirect::back();
        }
        //      dd($patron);
    }

    public function PaymentReport(Request $request)
    {
        $input = $request->all();
        //            dd($input);
        //        $validate = $this->validatePayment();
        if ($request->date != null) {
            $request->from_date = $request->date[0];
            $request->to_date = $request->date[1];
        }
        if ($request->patron_id != null) {
            $request->patron_id = $request->patron_id['id'];
        }
        //        dd($request->to_date);
        //        if ($request->journal_status == 1) $request->journal_status = '-1';
        //        else $request->journal_status = '0';
        //        if ($request->bank_verified == 1) {
        //            $request->bank_verified = '1';
        //            $request->journal_status = '1';
        //        } else {
        //            $request->bank_verified = '0';
        //            $request->journal_status = '0';
        //        }
        //        dd($request->from_date);
        $payment = Payment::join('payment_transactions', 'payments.payment_transaction_id', '=', 'payment_transactions.id')->join('patrons', 'payments.patron_id', '=', 'patrons.id')
            ->where('payments.entity_id', session('entity_id'))
            ->where('payments.deleted', 0)
            ->select(
                'payments.id as id',
                'payments.patron_id as patron_id',
                'patrons.legal_name as legal_name',
                'payments.verified_bank as verified_bank',
                'payments.journal_status as journal_status',
                'payments.payment_date as payment_date',
                'payment_transactions.payment_date as pt_date',
                'payments.payment_type as payment_type',
                'payments.total_amount as total_amount',
                'payment_transactions.total_amount as total_trans_amount',
                'payments.balance_due as balance_due',
                'payments.paid_amount as paid_amount'
            )
            ->when($request->patron_id, function ($query, $patron_id) {
                $query->where('payments.patron_id', $patron_id);
            })
            //            ->where('pt_date.payment_date', '>=', date($request->from_date))
            //            ->where('pt_date.payment_date', '<=', date($request->to_date))
            ->when($request->from_date, function ($query, $from_date) {
                $query->where('payment_transactions.payment_date', '>=', date($from_date));
            })->when($request->to_date, function ($query, $to_date) {
                $query->where('payment_transactions.payment_date', '<=', date($to_date));
            })
            ->get();
        //        dd($payment);
        $paymentreport = [];

        $entity = AppHelpers::instance()->entity(session('entity_id'), '');
        //                dd($paymentreport);
        if (count($payment) > 0) {
            if ($request->pdfExcel == 0) {
                return view('Report/PaymentReport', compact('entity', 'paymentreport', 'payment', 'input'));
                $pdf = PDF::setOption('footer-html', "<footer style='text-align:center; color:#969BA7'>
                    Powered By : <a style='font-size:24px; font-weight:600; color: #F9B5B5;'>Modoinfra.com</a></footer>")
                    ->setOption('footer-font-size', 10)->setOption('margin-bottom', 10)->loadView('Pdf/Report/PaymentReport', compact('entity', 'paymentreport', 'payment', 'input'))->setPaper('a4');
                return $pdf->stream('Payment.pdf');
            } else {
                //                $data = ['payment' => $payment, 'paymentreport' => $paymentreport, 'input' => $input];
                //                return Excel::download(new PaymentExport($data), 'Payment.xlsx');
                // return Excel::download('Pdf/Report/pettycash', compact('entity','pettycash','openingbal', 'input'));
            }
        } else {
            return Redirect::back();
        }
    }
    //Support Ticket Report
    public function MonthlyReport(Request $request)
    {
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $customerid = $request->query('customer');
        if (!$startDate || !$endDate) {
            return response()->json(['error' => 'Start and end dates are required'], 400);
        }
        $startDate = Carbon::parse($startDate)->toDateString();
        $endDate = Carbon::parse($endDate)->toDateString();
        $entity = AppHelpers::instance()->entity(session('entity_id'), '');
        $formattedDate = Carbon::parse($startDate)->format("F 'y");
        $tickets = OmTicketSystem::whereBetween(DB::raw('DATE(date)'), [$startDate, $endDate])->where([
            ['entity_id', session('entity_id')],
            ['customer_id', $customerid],
            ['deleted', 0],
        ])
            ->with('customer:id,legal_name', 'type:id,type', 'personal:id,first_name', 'contacts:id,person_name')
            ->get();
        $htmlFilePath = storage_path('app/temp_report.html');
        $html = View::make('Report.MonthlyReport', compact('tickets', 'entity', 'formattedDate'))->render();
        file_put_contents($htmlFilePath, $html);
        return $html;
    }
    public function downloadReportPdf()
    {
        $htmlFilePath = storage_path('app/temp_report.html');
        if (!file_exists($htmlFilePath)) {
            return response()->json(['error' => 'Report file not found. Please generate the report first.'], 404);
        }
        $html = file_get_contents($htmlFilePath);
        $pdf = PDF::loadHTML($html)->setPaper('A4', 'portrait') ->setOption('margin-top', 0)
        ->setOption('margin-right', 0)
        ->setOption('margin-bottom', 0)
        ->setOption('margin-left', 0)->setOption('dpi', 150);
        $pdfFilePath = storage_path('app/ticket-report.pdf');
        $pdf->save($pdfFilePath);
        return response()->download($pdfFilePath, 'ticket-report.pdf', [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="ticket-report.pdf"',
        ])->deleteFileAfterSend(true);
    }
    public function downloadReportJpeg()
    {
        $htmlFilePath = storage_path('app/temp_report.html');
        $jpegFilePath = storage_path('app/ticket-report.jpeg');
        if (env('APP_ENV') === 'local') {
            $wkhtmltoimagePath = '"C:\Program Files\wkhtmltopdf\bin\wkhtmltoimage.exe"';
        } else {
            $wkhtmltoimagePath = '/usr/bin/wkhtmltoimage';
        }
        $command = $wkhtmltoimagePath . ' --enable-local-file-access --no-stop-slow-scripts '
            . escapeshellarg($htmlFilePath) . ' '
            . escapeshellarg($jpegFilePath);
        $output = shell_exec($command);
        if (!file_exists($jpegFilePath)) {
            return response()->json([
                'error' => 'Failed to generate image',
                'details' => $output
            ], 500);
        }
        return response()->download($jpegFilePath, 'ticket-report.jpeg', [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename="ticket-report.jpeg"',
        ])->deleteFileAfterSend(true);
    }
    public function customerReport(Request $request)
    {
        $date = $request->query('date');
        $customerid = $request->query('customer');
        $startDate = Carbon::parse($date[0])->toDateString();
        $endDate = Carbon::parse($date[1])->toDateString();
        $entity = AppHelpers::instance()->entity(session('entity_id'), '');
        $tickets = OmTicketSystem::whereBetween(DB::raw('DATE(date)'), [$startDate, $endDate])->where('customer_id', $customerid)
            ->with('type:id,type', 'personal:id,first_name', 'customer:id,legal_name')->where('entity_id', session('entity_id'))
            ->get();
        return view('Report/customerReport', compact('tickets', 'startDate', 'endDate'));
        $pdf = PDF::setOption('margin-bottom', 10)->loadView('Report/customerReport', compact('tickets', 'entity'))->setPaper('a4');
        return $pdf->stream('Payment.pdf');
        // return $pdf->download('customer.pdf');
    }
    public function employeeReport(Request $request)
    {
        $startDate = $request->query('startDate');
        $endDate = $request->query('endDate');
        $employeeid = $request->query('employee');
        $entity = AppHelpers::instance()->entity(session('entity_id'), '');
        $tickets = OmTicketSystem::whereBetween(DB::raw('DATE(date)'), [$startDate, $endDate])->where([['service_by', $employeeid], ['entity_id', session('entity_id')], ['deleted', 0]])
            ->with('type:id,type', 'customer:id,legal_name', 'personal:id,first_name')
            ->get();
        return view('Report/employeeReport', compact('tickets', 'startDate', 'endDate'));
        $pdf = PDF::setOption('margin-bottom', 10)->loadView('Report/employeeReport', compact('tickets', 'entity'))->setPaper('a4');
        return $pdf->stream('Payment.pdf');
        // return $pdf->download('customer.pdf');
    }
    protected function validatePayment()
    {
        return request()->validate([
            'date' => ['required'],
        ]);
    }
}
