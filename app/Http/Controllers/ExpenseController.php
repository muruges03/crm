<?php


namespace App\Http\Controllers;


use App\Helpers\AppHelpers;
use App\Models\AccountType;
use App\Models\Expense;
use App\Models\Journal;
use App\Models\Personnel;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Inertia\Inertia;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Redirect;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Auth;
use App\Models\Entity;
use App\Models\Ledger;

class ExpenseController extends Controller
{
//    function __construct()
//    {
//        $this->middleware('permission:edit_expense|create_expense|delete_expense', ['only' => ['index', 'store']]);
//        $this->middleware('permission:create_expense', ['only' => ['create', 'store']]);
//        $this->middleware('permission:edit_expense', ['only' => ['edit', 'update']]);
//        $this->middleware('permission:delete_expense', ['only' => ['destroy']]);
//    }

    public function index()
    {

        if (Auth::user()->roles->pluck('name')[0] == 'super-admin') {
            $journal_id = [0, 1];
        } elseif (Auth::user()->roles->pluck('name')[0] == 'admin') {
            $journal_id = [0, 1];
        } else {
            $journal_id = [0];
        }
        return Inertia::render('Expense/Index', [
            'expense' => Expense::leftJoin('ledger as e_ledger','expenses.ledger_id','=','e_ledger.id')
                ->leftJoin('ledger as pt_ledger','expenses.paid_through','=','pt_ledger.id')
                ->leftJoin('personnels','expenses.made_by','=','personnels.id')
                ->where('expenses.deleted', 0)->where('expenses.entity_id', session('entity_id'))
                ->select(['expenses.date','expenses.id','expenses.amount','expenses.ref_no','expenses.prefix','e_ledger.title as ex_title','pt_ledger.title as pt_title','personnels.first_name','personnels.last_name'])
                ->orderBy('expenses.id', 'DESC')
               ->when(request('term'), function ($query, $term) {
                    $query->where(function ($query) use ($term) {
                        $query->where('expenses.ref_no', 'like', "%{$term}%")
                            ->orWhere('e_ledger.title', 'like', "%{$term}%")
                            ->orWhere('pt_ledger.title', 'like', "%{$term}%")
                            ->orWhere('expenses.note', 'like', "%{$term}%");
                    });
                })
                ->paginate(request('length', 10))
                ->through(fn($expense) => [
                    'id' => $expense->id,
                    'date' => $expense->date ? AppHelpers::instance()->getFormattedDateMonthWord($expense->date) : '',
                    'amount' => $expense->amount,
                    'paid_through'  => $expense->pt_title,
                    'expense_type' => $expense->ex_title ,
                    'ref_no' => $expense->ref_no,
                    'made_by'=>$expense->first_name,
                    'prefix' => $expense->prefix,
                ]),
        ]);
//        dd($dd);

    }

    public function create()
    {
        return Inertia::render('Expense/Create', [
            'asset' => AppHelpers::instance()->account_type_ledger('','Asset'),
            'expense' => AppHelpers::instance()->account_type_ledger('','Expense'),
            'patron' => AppHelpers::instance()->patrons('', 'Customer'),
            'personnel' => Personnel::where('deleted', '=', '0')->where('entity_id', session('entity_id'))->get(['id', 'first_name', 'last_name']),
        ]);
    }

    public function store(Request $request)
    {
        $getdata = Request::all();
//        dd($getdata);
        foreach ($getdata['add'] as $value) {
//            dd($value['ref_no']);
            if ($value['ref_no'] == null) {
                $expense = Expense::where('deleted', 0)->where('entity_id', session('entity_id'))
                    ->orderBy('ref_no','desc')->latest()->first();
//        dd($expense);
                if ($expense == null) $ref_no = 1;
                else $ref_no = $expense['ref_no'] + 1;
            } else {
                $ref_no = $value['ref_no'];
            }
//            dd($ref_no);
            $expenseiteam = new Expense;
            if ($value['expense_id'] != null && $value['amount'] != null) {
                $expenseiteam->entity_id        .= session('entity_id');
                $expenseiteam->prefix           .= 'EXP/';
                $expenseiteam->ref_no           .= Str::padLeft($ref_no, 4, 0);
                $expenseiteam->ledger_id        .= $value['expense_id']['id'];
                $expenseiteam->date             .= AppHelpers::instance()->DateTimeZone($value['date']);
                $expenseiteam->made_by          .= $value['made_by']['id'];
                $expenseiteam->paid_through     .= $value['journal_id']['id'];
                $expenseiteam->note             .= $value['note'];
                $expenseiteam->vendor_id        .= $value['vendor_id'] ? $value['vendor_id']['id'] : '';
                $expenseiteam->amount           .= $value['amount'];
                $expenseiteam->created_at       .= AppHelpers::instance()->DateTimeZone(now());
                $expenseiteam->created_by       .= Auth::user()->id;
                $expenseiteam->save();
            }

            $input=Expense::where('deleted', 0)->where('entity_id', session('entity_id'))->latest('id','ref_no')->first();
//dd($input);
            $journal_ref_no = Transaction::where('entity_id', session('entity_id'))->where('deleted', 0)->latest('id')->first();

            if ($journal_ref_no == null) $ref_no = 1;
            else $ref_no = (int)$journal_ref_no['id'] + 1;

            $reference = 'TR-' . Str::padLeft($ref_no, 4, 0);
            if ($input != null) {
                Transaction::create(array(
                    'entity_id'     => session('entity_id'),
                    'patron_id'     => $input['vendor_id'] ? $input['vendor_id'] : null,
                    'tx_date'       => $input['date'] ? AppHelpers::instance()->DateTimeZone($input['date']) : AppHelpers::instance()->DateTimeZone(now()),
                    'reference'     => $reference,
                    'origin_id'     => $input['id'],
                    'tx_type'       => 'Expense',
                    'tx_amount'     => $input['amount'],
                    'description'   => '',
                    'status'        => '1',
                    'created_at'    => AppHelpers::instance()->DateTimeZone(now()),
                    'created_by'    => Auth::user()->id
                ));
            }

            $journal_ref_no = Transaction::where('entity_id', session('entity_id'))->where('deleted', 0)->latest('id')->first();
//            dd($input);
            if ($input != null) {
                if ($input['ledger_id']!=null) {

                    $ledger = Ledger::where('deleted', 0)->where('entity_id', session('entity_id'))->where('id', $input['paid_through'])->get();
                    $expense_ledger = Ledger::where('deleted', 0)->where('entity_id', session('entity_id'))->where('id', $input['ledger_id'])->get();
//                    $defaultledger=$defaultledger[0]['ledger_id'];
                    //expense entry
                    Journal::create(array(
                        'ledger_id'         => $input['ledger_id'] ? $input['ledger_id'] : null,
                        'transaction_id'    => $journal_ref_no['id'],
                        'entry_date'        => $input['date'] ? AppHelpers::instance()->DateTimeZone($input['date']) : AppHelpers::instance()->DateTimeZone(now()),
                        'patron_id'         => $input['vendor_id'] ? $input['vendor_id'] : null,
                        'narration'         => 'Paid Through : ' . $ledger[0]['title'] .' for '.$expense_ledger[0]['title'].' ('.$input['note'].') '.' ('.$input['prefix'].$input['ref_no'].') ',
                        'debit_amount'      => $input['amount'] ? $input['amount'] : '0',
                        'credit_amount'     => '0',
                        'status'            => '1',
                        'notes'             => 'Expense',
                        'entity_id'         => session('entity_id'),
                        'created_at'        => AppHelpers::instance()->DateTimeZone(now()),
                        'created_by'        => Auth::user()->id,
                    ));
                }
                //debit amount double entry concept
                //patron entry
                if (isset($input['paid_through'])) {
                    $expense_ledger = Ledger::where('deleted', 0)->where('entity_id', session('entity_id'))->where('id', $input['ledger_id'])->get();
                    Journal::create(array(
                        'ledger_id'         => $input['paid_through'] ? $input['paid_through'] : null,
                        'transaction_id'    => $journal_ref_no['id'],
                        'entry_date'        => $input['date'] ? AppHelpers::instance()->DateTimeZone($input['date']) : AppHelpers::instance()->DateTimeZone(now()),
                        'patron_id'         => null,
                        'narration'         => 'Paid For : ' . $expense_ledger[0]['title'] .'('.$input['note'].')'.'('.$input['prefix'].$input['ref_no'].')',
                        'debit_amount'      => '0',
                        'credit_amount'     => $input['amount'] ? $input['amount'] : '0',
                        'status'            => '1',
                        'notes'             => 'Expense',
                        'entity_id'         => session('entity_id'),
                        'created_at'        => AppHelpers::instance()->DateTimeZone(now()),
                        'created_by'        => Auth::user()->id,
                    ));
                }
            }


            //journal status update in pettycash
            if ($input['journal_status'] == '0') {
                Expense::where('id', $input['id'])->update(array(
                    'journal_status' => '1',
                    'modified_at' => AppHelpers::instance()->DateTimeZone(now()),
                    'modified_by' => Auth::user()->id,
                    'entity_id' => session('entity_id'),
                ));
            }
        }

        return Redirect::route('expense.index');
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        if($id !=null){

//       dd($id);
            $transaction = Transaction::where('origin_id', $id)->where('tx_type', '=', 'Expense')->where('entity_id', session('entity_id'))->where('deleted', '0')->get();
//       dd($transaction);
            Expense::where('id', $id)->where('entity_id' ,session('entity_id'))->update(array(
                'deleted' => '1',
                'deleted_at' => AppHelpers::instance()->DateTimeZone(now()),
                'deleted_by' => Auth::user()->id,

            ));
            Transaction::where('origin_id', $id)->where('entity_id' ,session('entity_id'))->where('tx_type', '=', 'Expense')->update(array(
                'deleted' => '1',
                'deleted_at' => AppHelpers::instance()->DateTimeZone(now()),
                'deleted_by' => Auth::user()->id,
            ));
            Journal::where('transaction_id', $transaction[0]['id'])->where('entity_id' ,session('entity_id'))->update(array(
                'deleted' => '1',
                'deleted_at' => AppHelpers::instance()->DateTimeZone(now()),
                'deleted_by' => Auth::user()->id,

            ));
            return true;
        }else{
            return 'failed';
        }
    }

    public function journaldelete($id)
    {

//       dd($id);
        $transaction = Transaction::where('origin_id', $id)->where('tx_type', '=', 'Expense')->where('entity_id', session('entity_id'))->where('deleted', '0')->get();
//       dd($transaction);
        Expense::where('id', $id)->update(array(
            'journal_status' => '0',
            'modified_at' => AppHelpers::instance()->DateTimeZone(now()),
            'modified_by' => Auth::user()->id,
            'entity_id' => session('entity_id')
        ));
        Transaction::where('origin_id', $id)->where('tx_type', '=', 'Expense')->update(array(
            'deleted' => '1',
            'deleted_at' => AppHelpers::instance()->DateTimeZone(now()),
            'deleted_by' => Auth::user()->id,
            'entity_id' => session('entity_id')
        ));
        Journal::where('transaction_id', $transaction[0]['id'])->update(array(
            'deleted' => '1',
            'deleted_at' => AppHelpers::instance()->DateTimeZone(now()),
            'deleted_by' => Auth::user()->id,
            'entity_id' => session('entity_id')

        ));
        return Redirect::route('expense.index');
    }

    public function getrefNo(Request $request)
    {
        $input=Request::all();
//        dd($input);
        $ref_no=Str::padLeft($input['id']['ref_no'],4,0);
        $reference=Expense::where('ref_no','=',$ref_no)
            ->where('deleted',0)->where('entity_id',session('entity_id'))
            ->select('id','ref_no')->orderBy('ref_no', 'desc')->latest('id')->first();
//        dd($reference);
        if(isset($reference['ref_no']))
        {
            $reference=true;
        }elseif($reference==null) {
            $reference='failed';
        }else{
            $reference='failed';
        }
        return $reference;

    }
}
