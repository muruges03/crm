<?php

namespace App\Http\Controllers;


use App\Models\Email;
use App\Models\Entity;
use App\Models\Invoice;
use App\Models\Journal;
use App\Models\PaymentTransaction;
use App\Models\Ledger;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
//use Spatie\QueryBuilder\QueryBuilder;
use App\Helpers\AppHelpers;
use App\Models\Patron;
use App\Models\Payment;
use Inertia\Inertia;
use Inertia\Response;
use Carbon\Carbon;
use function PHPUnit\Framework\isEmpty;

class PaymentController extends Controller
{

//    function __construct()
//    {
//        $this->middleware('permission:edit_payment|create_payment|delete_payment', ['only' => ['index','store']]);
//        $this->middleware('permission:create_payment', ['only' => ['create','store']]);
//        $this->middleware('permission:edit_payment', ['only' => ['edit','update']]);
//        $this->middleware('permission:delete_payment', ['only' => ['destroy']]);
//    }

    public function index(Request $request)
    {

         if(Auth::user()->roles->pluck('name')[0] == 'super-admin')
        {
            $journal_id=[0,1];
        }elseif (Auth::user()->roles->pluck('name')[0] == 'admin'){
            $journal_id=[0,1];
        } else{
            $journal_id=[0];
        }
        $completed= PaymentTransaction::with('ledger','patron')
//            ->whereIn('journal_status',$journal_id)
                ->where('deleted','=',0)->where('entity_id',session('entity_id'))
                ->orderBy('created_at', 'DESC')
                ->when(request('term'), function ($query, $term) {
                    $query->where(function ($q) use ($term) {
                        $q->where('total_amount', 'like', '%' . $term . '%')->orWhere('payment_type', 'like', '%' . $term . '%')
                          ->orWhereHas('ledger', fn($q) => $q->where('title', 'like', '%' . $term . '%'))
                          ->orWhereHas('patron', fn($q) => $q->where('legal_name', 'like', '%' . $term . '%'));
                    });
                })
                ->paginate(request('length', 10))
                ->through(fn ($completed) => [
                    'id'                => $completed->id,
                    'payment_date'      => $completed->payment_date ? AppHelpers::instance()->getFormattedDateList($completed->payment_date) : '' ,
                    'type'              => $completed->payment_type,
                    'total_amount'      => $completed->total_amount,
                    'balance_due'       => $completed->balance_due,
                    'paid_amount'       => $completed->paid_amount,
                    'journal_status'    => $completed->journal_status ? 'Processed' : 'Pending',
                    'journal_status_color' => $completed->journal_status ? 'bg-green-100 text-green-600':'bg-red-100 text-saffron-800',
                    'ledger_id'         => $completed->ledger->title,
                    'patron_id'         => $completed->patron->legal_name,
                    'verified_bank'     => $completed->verified_bank,
                    'status'            => $completed->status ? 'Active': 'Inactive',
                    'status_color'      => $completed->status ? 'bg-green-100 text-green-600':'bg-saffron-100 text-saffron-800',


        ]);

         return Inertia::render('Payment/Index',compact(['completed']));
    }

//    protected function completed()
//    {
//        if(Auth::user()->roles->pluck('name')[0] == 'super-admin')
//        {
//            $journal_id=[0,1];
//        }elseif (Auth::user()->roles->pluck('name')[0] == 'admin'){
//            $journal_id=[0,1];
//        } else{
//            $journal_id=[0];
//        }
//        $completed= PaymentTransaction::with('ledger')->where('verified_bank','=',$journal_id)->whereIn('journal_status','=',$journal_id)->where('deleted','=',0)->where('entity_id',session('entity_id'))
//                ->orderBy('created_at', 'DESC')
//                ->filter(Request::only('search'))
//                ->paginate(request('length', 10))
//                ->through(fn ($completed) => [
//                    'id'                => $completed->id,
//                    'payment_date'      => $completed->payment_date ? AppHelpers::instance()->getFormattedDateList($completed->payment_date) : '' ,
//                    'total_amount'      => $completed->total_amount,
//                    'balance_due'       => $completed->balance_due,
//                    'paid_amount'       => $completed->paid_amount,
//                    'journal_status'    => $completed->journal_status ? 'Processed' : 'Pending',
//                    'journal_status_color' => $completed->journal_status ? 'bg-green-100 text-green-600':'bg-red-100 text-saffron-800',
//                    'ledger_id'         => $completed->ledger->title,
//                    'verified_bank'     => $completed->verified_bank,
//                    'status'            => $completed->status ? 'Active': 'Inactive',
//                    'status_color'      => $completed->status ? 'bg-green-100 text-green-600':'bg-saffron-100 text-saffron-800',
//
//
//        ]);
////        dd($completed);
//        return $completed;
//    }

    protected function inCompleted()
    {

        $inCompleted= PaymentTransaction::with('ledger')->where('deleted','=',0)->where('verified_bank','=','0')->where('entity_id',session('entity_id'))
                ->orderBy('created_at', 'DESC')
                ->filter(Request::only('search'))
                ->paginate(request('length', 10))
                ->through(fn ($inCompleted) => [
                    'id'                => $inCompleted->id,
                    'payment_date'      => $inCompleted->payment_date ? AppHelpers::instance()->getFormattedDateList($inCompleted->payment_date) : '' ,
                    'total_amount'      => $inCompleted->total_amount,
                    'balance_due'       => $inCompleted->balance_due,
                    'paid_amount'       => $inCompleted->paid_amount,
                    'journal_status'    => $inCompleted->journal_status ? 'Processed' : 'Pending',
                    'journal_status_color' => $inCompleted->journal_status ? 'bg-green-100 text-green-600':'bg-red-100 text-saffron-800',
                    'ledger_id'         => $inCompleted->ledger->title,
                    'verified_bank'     => $inCompleted->verified_bank,
                    'status'            => $inCompleted->status ? 'Active': 'Inactive',
                    'status_color'      => $inCompleted->status ? 'bg-green-100 text-green-600':'bg-saffron-100 text-saffron-800',


        ]);
        return $inCompleted;
    }

    public function create()
    {
        $patron         = patron();
        return Inertia::render('Payment/Create', [
            'patrons'        => $patron,
            'ledger'        => AppHelpers::instance()->account_type_ledger('','Asset')
        ]);
    }
    function patron()
    {
        $patron=Patron::where('patron_type','like', '%'.'Customer'.'%')->where('entity_id',session('entity_id'))->where('deleted', 0)->get();
        return $patron;
    }
    public function store(Request $request)
    {
        $input = Request::all();
//dd($input);
        $this->validatePayments();
        if($input['payment_type']=='Payment')
        {
//            dd($input['payment_type']);
            $ref_no=PaymentTransaction::where('payment_type','=',$input['payment_type'])->where('entity_id',session('entity_id'))->where('deleted','0')->orderBy('id', 'desc')->first();
            $prefix='PA - ';
        }elseif($input['payment_type']=='Advance Payment')
        {
            $ref_no=PaymentTransaction::where('payment_type','=',$input['payment_type'])->where('entity_id',session('entity_id'))->where('deleted','0')->orderBy('id', 'desc')->first();
            $prefix='AD - ';
        }elseif($input['payment_type']=='Receipt')
        {
            $ref_no=PaymentTransaction::where('payment_type','=',$input['payment_type'])->where('entity_id',session('entity_id'))->where('deleted','0')->orderBy('id', 'desc')->first();
            $prefix='RC - ';
        }
        PaymentTransaction::create(array(
            'entity_id'        =>  session('entity_id'),
            'payment_date'     =>  $input['payment_date'] ? AppHelpers::instance()->DateTimeZone($input['payment_date']) : null,
            'ledger_id'        =>  $input['ledger_id']['id'],
            'total_amount'     =>  $input['paid_amount'],
            'prefix'           =>  $prefix,
            'patron_id'        =>  isset($input['vendor_id'][0]) ? null : $input['vendor_id']['id'],
            'ref_no'           =>  isset($ref_no) ? Str::padLeft($ref_no['ref_no']+1,4,0) : Str::padLeft(1,4,0),

            'payment_type'     =>  $input['payment_type'],
            'description'      =>  $input['description'] ? $input['description'] : null,
            'status'           =>  '0',
            'created_at'       =>  AppHelpers::instance()->DateTimeZone(now()),
            'created_by'       =>  Auth::user()->id
        ));

        $ptid = PaymentTransaction::where('entity_id',session('entity_id'))->where('deleted','0')->latest('id')->first();

        $paymentiteam = new Payment;

        $paymentiteam->entity_id .= session('entity_id');
        $paymentiteam->payment_transaction_id .= $ptid['id'];
        $paymentiteam->payment_type .= $input['payment_type'] ? $input['payment_type'] : null;
        $paymentiteam->patron_id .= $input['vendor_id'] !=null ?  $input['vendor_id']['id'] : null;
        $paymentiteam->payment_date .= $input['payment_date'] ? AppHelpers::instance()->DateTimeZone($input['payment_date']) : AppHelpers::instance()->DateTimeZone(now());
        $paymentiteam->total_amount .= $input['paid_amount'] ? $input['paid_amount'] : null;
        $paymentiteam->description .= $input['description'] ? $input['description'] : null;
        $paymentiteam->paid_amount .= $input['paid_amount'] ? $input['paid_amount'] : null;
        $paymentiteam->ledger_id .= $input['ledger_id'] ? $input['ledger_id']['id'] : null;
        // $paymentiteam->journal_type_id     .= $value['journal_type_id'] ? $value['journal_type_id']['id'] : null;
        $paymentiteam->bill_ref_id .= null;
        $paymentiteam->balance_due .= null;
        $paymentiteam->status .= '1';
        $paymentiteam->journal_status .= '0';
        $paymentiteam->created_at .= AppHelpers::instance()->DateTimeZone(now());
        $paymentiteam->created_by .= Auth::user()->id;
        $paymentiteam->save();


        return Redirect::route('payment.index');
    }

    public function edit(\Illuminate\Http\Request $request,$id)
    {
        $currentPage=session('currentPage', $request->server('HTTP_REFERER'));
//        dd($payment);
        $payment=PaymentTransaction::where('id',$id)->where('entity_id', session('entity_id'))->where('deleted', 0)->latest()->first();
//        dd($payment);
        $ledger_id = AppHelpers::instance()->account_type_ledger($payment->ledger_id,'');

        $vendor        = AppHelpers::instance()->reportpatrons($payment->patron_id, '');
//        dd($payment->patron_id);
        return Inertia::render('Payment/Edit',[
            'patrons'        => AppHelpers::instance()->reportpatrons('', ''),
            'ledger'        => AppHelpers::instance()->account_type_ledger('','Asset'),
            'paymenttransaction'      =>array(
                'id'                => $payment->id,
                'payment_date'      => $payment->payment_date ? AppHelpers::instance()->DateTimeZone($payment->payment_date) : '',
                'ledger_id'         => $ledger_id[0],
                'payment_type'      => $payment->payment_type,
                'filename'          => $payment->filename,
                'total_amount'      => $payment->total_amount,
                'bill_ref_id'       => $payment->bill_ref_id,
                'paid_amount'       => $payment->total_amount,
                'description'       => $payment->description,
                'verified_bank'     => $payment->verified_bank  ? true : false,
                'journal_status'    => $payment->journal_status,
                'vendor_id'         =>$vendor ? $vendor[0] : null,
                'currentPage'           => $currentPage,
            ),
        ]);
        // dd($payment);
    }

    protected function validatePayments()
    {
     return request()->validate([
                'paid_amount'       => ['required'],
                 'vendor_id'         => ['required'],
                 'ledger_id'        => ['required'],
                 'payment_type'     => ['required'],
             ]);
    }
    public function update(Request $request)
        {
            $input=Request::all();
//             dd($input);

        if($input['payment_type']=='Payment')
        {
            $ref_no=PaymentTransaction::where('payment_type','=','Payment')->where('id','=',$input['id'])->where('entity_id',session('entity_id'))->where('deleted','0')->orderBy('id', 'desc')->first();
            $prefix='PA - ';
        }elseif($input['payment_type']=='Advance Payment')
        {
            $ref_no=PaymentTransaction::where('payment_type','=','Advance Payment')->where('id','=',$input['id'])->where('entity_id',session('entity_id'))->where('deleted','0')->orderBy('id', 'desc')->first();
            $prefix='AD - ';
        }else
        {
            $ref_no=PaymentTransaction::where('payment_type','=','Receipt')->where('id','=',$input['id'])->where('entity_id',session('entity_id'))->where('deleted','0')->orderBy('id', 'desc')->first();
            $prefix='RC - ';
        }


//            $validate =  $this->validatePayments();
            PaymentTransaction::where('id',$input['id'])->update(array(
                'ledger_id'                 =>  $input['ledger_id']['id'],
                'patron_id'                 =>  $input['vendor_id']==null ? null : $input['vendor_id']['id'],
                'description'               =>  $input['description'],
                'total_amount'              =>  $input['total_amount'],
                'payment_date'              =>  $input['payment_date'] ?  AppHelpers::instance()->DateTimeZone($input['payment_date']) : '',
                'verified_bank'             =>  $input['verified_bank'] ? 1 : 0,
                'journal_status'            =>  $input['verified_bank'] ? 1 : 0,
                'prefix'                    =>  $prefix,
                'ref_no'                    =>  $ref_no['ref_no'],
                'modified_at'               =>  AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'               =>  Auth::user()->id,
                'entity_id'                 =>  session('entity_id')
            ));


                if ($input['paid_amount'] != null && $input['paid_amount'] != 0) {
        //                dd($value);
                    Payment::where('payment_transaction_id', $input['id'])->update(array(
                        'entity_id'                 => session('entity_id'),
                        'payment_transaction_id'    => $input['id'],
                        'payment_type'              => $input['payment_type'],
                        'patron_id'                 => $input['vendor_id']['id'],
                        'payment_date'              => $input['payment_date'] ? AppHelpers::instance()->DateTimeZone($input['payment_date']) : AppHelpers::instance()->DateTimeZone(now()),
                        'total_amount'              => $input['total_amount'],
                        'description'               => $input['description'] ? $input['description'] : null,
                        'paid_amount'               => $input['paid_amount'],
                        'ledger_id'                 => $input['ledger_id']['id'],
                        'verified_bank'             => $input['verified_bank'] ? 1 : 0,
                        'modified_at'               => AppHelpers::instance()->DateTimeZone(now()),
                        'modified_by'               => Auth::user()->id,
                    ));
                }
//dd($input);
        if($input['verified_bank']==true) {

            $this->generatejournal($input);
        }

        return $input['currentPage']!=null ? redirect($input['currentPage']) : Redirect::route('payment.index');
        }


//    public function destroy($id)
//    {
//        PaymentTransaction::findOrFail($id)->update(array('deleted' => '1', 'deleted_at' => AppHelpers::instance()->DateTimeZone(now()), 'deleted_by' => Auth::user()->id));
//        Payment::where('payment_transaction_id',$id)->update(array('deleted' => '1', 'deleted_at' => AppHelpers::instance()->DateTimeZone(now()), 'deleted_by' => Auth::user()->id));
//        return Redirect::route('payments.index');
//    }

    public function validatepatron(){
        return request()->validate([
//            'patron_type'=> ['required'],
//             'vendor_id'         => ['required'],
//             'ledger_id'   => ['required'],
        ]);
    }

    public function verifiedstatus(Request $request)
    {
        $input=Request::all();
        // dd($input);
        Payment::where('id',$input)->update(array('verified_bank'=>'1'));
        return Redirect::route('payments.index')->with('success', 'Successfully Verified.');

    }

    protected function generatejournal($input)
    {
//        dd($input);
        $journal_ref_no = Transaction::where('entity_id', session('entity_id'))->where('deleted', 0)->latest('id')->first();
        if ($journal_ref_no == null) $ref_no = 1;
        else $ref_no = (int)$journal_ref_no['id'] + 1;

        $reference = 'TR-' . Str::padLeft($ref_no, 4, 0);
        Transaction::create(array(
            'entity_id'         => session('entity_id'),
            'patron_id'         => $input['vendor_id'] ? $input['vendor_id']['id'] : null,
            'tx_date'           => $input['payment_date'] ? AppHelpers::instance()->DateTimeZone($input['payment_date']) : AppHelpers::instance()->DateTimeZone(now()),
            'reference'         => $reference,
            'origin_id'         => $input['id'],
            'tx_type'           => $input['payment_type'],
            'tx_amount'         => $input['total_amount'],
            'description'       => $input['payment_type'],
            'status'            => '1',
            'created_at'        => AppHelpers::instance()->DateTimeZone(now()),
            'created_by'        => Auth::user()->id
        ));

        $transactionid = Transaction::where('entity_id', session('entity_id'))->where('deleted', '0')->latest('id')->first();

        //journal status update in Hire order


        if ($input['ledger_id'] != null) {
            $ledger = Ledger::where('deleted', 0)->where('entity_id', session('entity_id'))->where('id', $input['ledger_id']['id'])->get();
//            dd($ledger);
            $journal = new Journal;
            $journal->entity_id         .= session('entity_id');
            $journal->ledger_id         .= $input['ledger_id']['id'] ? $input['ledger_id']['id'] : null;
            $journal->transaction_id    .= $transactionid['id'];
            $journal->entry_date        .= $input['payment_date'] ? AppHelpers::instance()->DateTimeZone($input['payment_date']) : AppHelpers::instance()->DateTimeZone(now());
            $journal->patron_id         .=  null;
            $journal->debit_amount      .= $input['payment_type']=='Receipt' ? $input['total_amount'] : '0';
            $journal->narration         .= $input['payment_type']!='Receipt' ? 'Paid By : '. $ledger[0]['title'] : 'Received To : '. $ledger[0]['title'] ;
            $journal->credit_amount     .= $input['payment_type']!='Receipt' ? $input['total_amount'] : '0';
            $journal->notes             .= $input['payment_type'];
            $journal->status            .= '1';
            $journal->created_at        .= AppHelpers::instance()->DateTimeZone(now());
            $journal->created_by        .= Auth::user()->id;
            $journal->save();
        }


            if ($input['vendor_id'] != null) {
                $patron = AppHelpers::instance()->reportpatrons($input['vendor_id']['id'], '');

                $journal = new Journal;
                $journal->entity_id             .= session('entity_id');
                $journal->ledger_id             .= $input['payment_type']=='Receipt' ? $patron[0]['credit_ledger_id'] : $patron[0]['debit_ledger_id'];
                $journal->transaction_id        .= $transactionid['id'];
                $journal->entry_date            .= $input['payment_date'] ? AppHelpers::instance()->DateTimeZone($input['payment_date']) : AppHelpers::instance()->DateTimeZone(now());
                $journal->patron_id             .= $input['vendor_id']['id'];

                $journal->debit_amount          .= $input['payment_type']!='Receipt' ? $input['total_amount'] : '0';
                $journal->narration             .= $input['payment_type']=='Receipt' ? 'Received By : '. $patron[0]['legal_name'] : 'Paid To : '. $patron[0]['legal_name'];
                $journal->credit_amount         .= $input['payment_type']=='Receipt' ? $input['total_amount'] : '0';
                $journal->status                .= '1';
                $journal->notes                 .= $input['payment_type'];
                $journal->created_at            .= AppHelpers::instance()->DateTimeZone(now());
                $journal->created_by            .= Auth::user()->id;
                $journal->save();
            }

        if ($input['journal_status'] == '0') {
            PaymentTransaction::where('id', $input['id'])->update(array(
                'journal_status'    => '1',
                'verified_bank'     => '1',
                'modified_at'       => AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'       => Auth::user()->id,
                'entity_id'         => session('entity_id'),
            ));
            $payment=Payment::where('payment_transaction_id',$input['id'])->where('deleted',0)->where('entity_id',session('entity_id'))->latest()->first();
//            dd($payment);
            Invoice::where('id', $payment['bill_ref_id'])->update(array(
                'paid_status'    => '1',
                'journal_status'     => '1',
                'modified'       => AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'       => Auth::user()->id,
                'entity_id'         => session('entity_id'),
            ));
        }
        return Redirect::route('payment.index');
    }

    public function destroy($id)
    {
//        $input=Request::all();
//       dd($id);
//        $transaction=PaymentTransaction::where('id',$id)->where('entity_id', session('entity_id'))->where('deleted', '0')->get();
////       dd($transaction);
        PaymentTransaction::where('id',$id)->update(array(
            'verified_bank'             => '0',
            'journal_status'            => '0',
            'modified_at'               =>  AppHelpers::instance()->DateTimeZone(now()),
            'modified_by'               =>  Auth::user()->id,
            'entity_id'                 =>  session('entity_id')
        ));
        $payment=Payment::where('payment_transaction_id',$id)->where('deleted',0)->where('entity_id',session('entity_id'))->latest()->first();
        Invoice::where('id', $payment['bill_ref_id'])->update(array(
            'paid_status'    => '0',
            'journal_status'     => '-1',
            'modified'       => AppHelpers::instance()->DateTimeZone(now()),
            'modified_by'       => Auth::user()->id,
            'entity_id'         => session('entity_id'),
        ));
        Payment::where('payment_transaction_id',$id)->update(array(
            'verified_bank'             => '0',
            'journal_status'            => '0',
            'modified_at'               =>  AppHelpers::instance()->DateTimeZone(now()),
            'modified_by'               =>  Auth::user()->id,
            'entity_id'                 =>  session('entity_id')
        ));

        Transaction::where('origin_id',$id)->where('Payment','=', 'Payment')->update(array(
            'deleted'                  => '1',
            'deleted_at'               =>  AppHelpers::instance()->DateTimeZone(now()),
            'deleted_by'               =>  Auth::user()->id,
            'entity_id'                =>  session('entity_id')
        ));
        $transaction=Transaction::where('origin_id',$id)->where('Payment','=', 'Payment')->where('entity_id', session('entity_id'))->withTrashed()->orderBy('id', 'desc')->first();
//        dd($transaction);
        Journal::where('transaction_id', $transaction['id'])->update(array(
            'deleted'                  => '1',
            'deleted_at'               =>  AppHelpers::instance()->DateTimeZone(now()),
            'deleted_by'               =>  Auth::user()->id,
            'entity_id'                =>  session('entity_id')

        ));
        return Redirect::route('payment.index');
    }
}
