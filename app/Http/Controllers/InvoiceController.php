<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use ZipArchive;
use App\Helpers\AppHelpers;
use App\Models\Journal;
use App\Models\Ledger;
use App\Models\Payment;
use App\Models\PaymentTransaction;
use App\Models\Transaction;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\LeadType;
use App\Models\Lead;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use App\Models\Tax;
use App\Models\Product;
use App\Models\Patron;
use App\Models\Contact;
use App\Models\Account;
use App\Models\LeadContact;
use App\Models\PatronContact;
use App\Models\EntityContact;
use App\Models\Email;
use App\Models\InvoiceTax;
use Carbon\Carbon;
use App\Models\LeadPipelineStage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
//use Barryvdh\DomPDF\Facade\Pdf;
//use Mccarlosen\LaravelMpdf\LaravelMpdf;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;
use App\Exports\ExportInvoice;
use \PDF;
use Maatwebsite\Excel\Facades\Excel;
use DB;

class InvoiceController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:edit_invoices|create_invoices|delete_invoices', ['only' => ['index','store']]);
         $this->middleware('permission:create_invoices', ['only' => ['create','store']]);
         $this->middleware('permission:edit_invoices', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_invoices', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
//         dd(\Illuminate\Support\Facades\Request::only('invoice_number'));
        if($request->customer_name!=null) $request->customer_name=$request->customer_name['legal_name'];
        $paid_status='';
        if($request->paid_status=='true')  $paid_status='1';
        if($request->paid_status=='false')  $paid_status='0';
//             dd( Auth::user()->roles->pluck('name')[0] == 'super-admin');
        $length = request('length', 50);
        if(Auth::user()->roles->pluck('name')[0] == 'super-admin' || Auth::user()->roles->pluck('name')[0] == 'admin') {
            $invoice = QueryBuilder::for(Invoice::class)
                ->join('patrons', 'invoices.patron_id', '=', 'patrons.id')
                ->select('invoices.*', 'patrons.legal_name')
                ->where('invoices.entity_id', session('entity_id'))->where('invoices.deleted', 0)
                ->when($request->from_date, function ($query, $from_date) {
                    $query->whereDate('invoices.invoiced_at', '>=', date($from_date));
                })->when($request->to_date, function ($query, $to_date) {
                    $query->whereDate('invoices.invoiced_at', '<=', date($to_date));
                });
            if ($paid_status != '') {
                $invoice->where('paid_status', $paid_status);
            }
            $invoice = $invoice->defaultSort('-id')
                ->allowedSorts(['id', 'order_number', 'prefix'])->filter(\Illuminate\Support\Facades\Request::only('invoice_number'))
                ->paginate($length)
                ->withQueryString();
        }else{
            $invoice = QueryBuilder::for(Invoice::class)
                ->join('patrons', 'invoices.patron_id', '=', 'patrons.id')
                ->select('invoices.*', 'patrons.legal_name')->whereYear('start_date', Carbon::now()->year)
                ->whereMonth('start_date', Carbon::now()->month)
                ->where('invoices.entity_id', session('entity_id'))->where('invoices.deleted', 0)
                ->when($request->from_date, function ($query, $from_date) {
                    $query->whereDate('invoices.invoiced_at', '>=', date($from_date));
                })->when($request->to_date, function ($query, $to_date) {
                    $query->whereDate('invoices.invoiced_at', '<=', date($to_date));
                });
            if ($paid_status != '') {
                $invoice->where('paid_status', $paid_status);
            }
            $invoice = $invoice->defaultSort('-id')
                ->allowedSorts(['id', 'order_number', 'prefix'])->filter(\Illuminate\Support\Facades\Request::only('invoice_number'))
                ->paginate($length)
                ->withQueryString();
        }

//             dd($invoice);
        return Inertia::render('Invoice/Index', [
            'invoice' => $invoice->through(function ($invoice) {
                return [
                    'id'             => $invoice->id,
                    'prefix'         => $invoice->prefix,
                    'invoice_number' => $invoice->invoice_number,
                    'legal_name'     => $invoice->legal_name,
                    'invoiced_at'    => $invoice->invoiced_at ? changeDateFormate($invoice->invoiced_at) : null ,
                    'due_at'         => $invoice->due_at ? changeDateFormate($invoice->due_at) : null ,
                    'start_date'     => $invoice->start_date ? getMonthYear($invoice->start_date) : null ,
                    'end_date'       => $invoice->end_date ? getMonthYear($invoice->end_date) : null ,
                    'untaxed_amount' => $invoice->untaxed_amount,
                    'total_amount'   => $invoice->total_amount,
                    'paid_status'    => $invoice->paid_status,
                    'cancel_status'  => $invoice->cancel_status,
                    'is_sent'        => $invoice->is_sent,
                ];

            }),
            'patron' => patron(),
        ])->table(function (InertiaTable $table) {
            $table->addColumns([
                'order_number'  => 'order_number',
                'prefix'        => 'prefix',
            ]);
        });
        // dd($dd);
    }
    public function Create(){

        $fincl_yr       = getFinancialYear(now());//dd($invoiceid);
        $invoiceid      = $fincl_yr[1].$fincl_yr[0];//

        $tax            = tax('', 'Sales', '', '["CGST","SGST"]');
        $patron         = patron();
        $product        = product();
        $email          = $this->email();
        $ledger         = AppHelpers::instance()->account_type_ledger('','Income');
        // dd($invoice);
        return Inertia::render('Invoice/Create',compact('tax','product','patron','invoiceid','email','ledger'));
    }
    public function store(Request $request)
    {
        $input          = $request->all();
//dd($input);
        $invoiceiteam   = $input['add'];
        $invoice_number = getFinancialYear($input['form']['invoiced_at']);
//        dd($invoice_number);
        Invoice::create(array(
            'entity_id'      =>  session('entity_id'),
            'patron_id'      =>  $input['form']['customer_name']['id'],
            'prefix'         =>  $input['form']['prefix'].'-'.$invoice_number[1],
            'invoice_number' =>  $invoice_number[0],
            'order_number'   =>  $input['form']['order_number'],
            'status'         =>  $input['form']['status'],
            'start_date'     =>  $input['form']['type']=='Yearly' ? $input['form']['start_date'] : $input['form']['start_date'],
            'end_date'       =>  $input['form']['type']=='Yearly' ? $input['form']['end_date'] : null,
            'invoiced_at'    =>  $input['form']['invoiced_at'],
            'due_at'         =>  $input['form']['due_at'],
            'ledger_id'      =>  $input['form']['ledger_id'] ? $input['form']['ledger_id']['id'] : null,
            'untaxed_amount' =>  $input['form']['untaxed_amount'],
            'tax_amount'     =>  $input['form']['tax_amount'],
            'total_amount'   =>  $input['form']['total_amount'],
            'discount_amount'=>  $input['form']['discount_amount'],
            'notes'          =>  $input['form']['notes'],
            'type'           =>  $input['form']['type'],
            'created'        =>  AppHelpers::instance()->DateTimeZone(now()),
            'created_by'     =>  Auth::user()->id
        ));

        $invoiceid  = Invoice::where('entity_id',session('entity_id'))->where('deleted','0')->latest()->first();

        foreach ($invoiceiteam as $value) {
            $invoiceitm = new InvoiceItem;
            if($value['price']!=null && $value['quantity']!=null){
                $invoiceitm->entity_id          .= session('entity_id');
                $invoiceitm->invoice_id         .= $invoiceid['id'];
                $invoiceitm->product_id         .= $value['product_id']['id'];
                $invoiceitm->description        .= $value['description'];
                $invoiceitm->quantity           .= $value['quantity'];
                $invoiceitm->price              .= $value['price'];
                $invoiceitm->discount_type      .= $value['discount_type'];
                $invoiceitm->discount_amount    .= $value['discount_amount'];
                if($value['tax_id']!=null)$invoiceitm->tax_id .= $value['tax_id']['id'];
                    else $invoiceitm->tax_id = null;
                $invoiceitm->tax_amount         .= $value['tax_amount'];
                $invoiceitm->total_amount       .= $value['total_amount'];
                $invoiceitm->created            .=AppHelpers::instance()->DateTimeZone(now());
                $invoiceitm->created_by         .= Auth::user()->id;
                $invoiceitm->save();
            }
//            dd($value['tax_id']);
            if($value['tax_id']!=null) {
                $tax     = taxes('','',$value['tax_id']['id'],'');
//                dd($tax);
                foreach($tax as $val){
                        $amount  = (($value['total_amount'] * ($val['tax_amount']/100)));
                        $taxname = $val['tax_group'].' '.$val['tax_amount'].'%';
//                         dd($taxname);
                    $invoicetax  = new InvoiceTax;
                    $invoicetax->entity_id      .= session('entity_id');
                        $invoicetax->invoice_id .= $invoiceid['id'];
                        $invoicetax->tax_id     .= $val['id'];
                        $invoicetax->name       .= $taxname;
                        $invoicetax->amount     .= $amount;
                        $invoicetax->created    .=AppHelpers::instance()->DateTimeZone(now());
                        $invoicetax->created_by .= Auth::user()->id;
                        $invoicetax->save();
                }
            }
        }
        // dd($value);
        return Redirect::route('invoice');
    }


    public function edit($id)
    {
        $invoice=InvoiceItem::join('invoices','invoice_items.invoice_id','=','invoices.id')
                            ->join('products','invoice_items.product_id','=','products.id')
                            ->join('patrons','invoices.patron_id','=','patrons.id')
                            ->leftJoin('ledger','invoices.ledger_id','=','ledger.id')
                            ->where('invoices.id',$id)
                            ->where('invoice_items.deleted','0')
                            ->select('invoices.patron_id','invoices.prefix','invoices.invoice_number','invoices.id as i_id','invoices.is_sent',
                            'invoices.order_number','invoices.status','invoices.start_date','invoices.end_date','invoices.invoiced_at',
                            'invoices.due_at','invoices.untaxed_amount','invoices.tax_amount as i_taxamt','invoices.total_amount as i_totamt',
                            'invoices.discount_amount as i_disamt','invoices.paid_status',
                            'invoices.notes','invoices.type','invoice_items.id as it_id',
                            'invoice_items.product_id','invoice_items.total_amount as it_totamt',
                            'invoice_items.tax_amount as it_taxamt',
                            'invoice_items.description','invoice_items.quantity',
                            'invoice_items.price','invoice_items.discount_type',
                            'invoice_items.discount_amount as it_disamt','ledger.title as l_title','ledger.id as ledger_id',
                            'invoice_items.tax_id','patrons.*','products.name')->get();
//dd($invoice);
        //for select json data send to fetch
        $email      = $this->email();
        foreach ($invoice as $key => $val) {
            // dd($val);
            if($val['discount_type']=="%") $total_discount  = ($val['it_totamt'] * ($val['it_disamt']/100));
                else $total_discount  = $val['it_disamt'];
            $product=Product::where('id',$val['product_id'])->where('deleted','0')->select('id','name','sale_price','tax_id')->get()->toArray();
            if($val['tax_id']!=null){
                $tax=Tax::where('id',$val['tax_id'])->where('deleted','0')->select('id','tax_name','tax_type','tax_amount')->get()->toArray();
                $taxes=$tax[0];
            }else{
                $taxes='';
            }
            $invoiceiteam[]=['id'           => $val['it_id'],
                            'product_id'    => $product[0],
                            'it_totamt'     => $val['it_totamt'],
                            'it_taxamt'     => $val['it_taxamt'],
                            'description'   => $val['description'],
                            'quantity'      => $val['quantity'],
                            'price'         => $val['price'],
                            'discount_type' => $val['discount_type'],
                            'it_disamt'     => $val['it_disamt'],
                            'tax_id'        => $taxes,
                            'total_discount'=> $total_discount,
                            'readonly'      => true,
                            'disabled'      => true,
                        ];
        }
        //select value get and patron id select get
        $tax        = tax('', 'Sales', '', '');
        $patron     = patron();
        $product    = product();
        $patronid   = patronid($invoice[0]['patron_id']);
        $invoicedata= Invoice::where('entity_id',session('entity_id'))->where('deleted', 0)->get('id');
        $account    = Account::where('invoice_id',$id)->where('entity_id',session('entity_id'))->where('deleted', 0)->get();
        $ledgerid=AppHelpers::instance()->account_type_ledger($invoice[0]['ledger_id'],'Income');
        $ledger         = AppHelpers::instance()->account_type_ledger('','Income');
//        dd($ledgerid);
        if(count($account) > 0) $paiddate  = $account[0]['paid_date'];
            else $paiddate  = null;
        // dd( $paiddate);
        return Inertia::render('Invoice/Edit',compact('invoice','invoiceiteam','tax','product','patron','patronid','invoicedata','email','paiddate','ledger','ledgerid'));
    }
    public function update(Request $request)
    {
        $input        = $request->all();
        $invoiceiteam = $input['add'];
//         dd($input);
        // $validate =  $this->validateinvoice();
        Invoice::findOrFail($input['form']['id'])->update(array(
                    'entity_id'     => session('entity_id'),
                    'patron_id'     => $input['form']['customer_name']['id'],
                    'prefix'        => $input['form']['prefix'],
                    'invoice_number'=> $input['form']['invoice_number'],
                    'order_number'  => $input['form']['order_number'],
                    'status'        => $input['form']['status'],
                    'start_date'    => $input['form']['type']=='Yearly' ? $input['form']['start_date'] : $input['form']['start_date'],
                    'end_date'      => $input['form']['type']=='Yearly' ? $input['form']['end_date'] : null,
                    'invoiced_at'   => $input['form']['invoiced_at'],
                    'due_at'        => $input['form']['due_at'],
                    'ledger_id'     => $input['form']['ledger_id'] ? $input['form']['ledger_id']['id'] : null,
                    'untaxed_amount'=> $input['form']['untaxed_amount'],
                    'tax_amount'    => $input['form']['i_taxamt'],
                    'total_amount'  => $input['form']['i_totamt'],
                    'discount_amount'=>$input['form']['i_disamt'],
                    'notes'         => $input['form']['notes'],
                    'type'          => $input['form']['type'],
                    'modified'      => AppHelpers::instance()->DateTimeZone(now()),
                    'modified_by'   => Auth::user()->id
                ));

        // delete
        if($input['itemdelete']!=[]){
            foreach($input['itemdelete'] as $value){
                $tax     = tax('','',$value['tax_id'],'');
                InvoiceItem::where('id', $value['id'])->update(array('deleted'=>'1'));
                foreach($tax as $val){
                    // dd($val['id'],$input['form']['id'],session('entity_id'));
                    DB::table('invoice_tax')
                    ->where('tax_id',$val['id'])->where('invoice_id',$input['form']['id'])->where('entity_id',session('entity_id'))
                    ->update(array('deleted'=>'1'));
                }
            }
        }
        //invoiceiteam create and update
        foreach ($invoiceiteam as $value) {
            $record = InvoiceItem::where('id',$value['id'])->first();
            // dd($value);
            if ($record==null) {
                    if($value['price']!=null && $value['quantity']!=null){
                        $invoiceitm = new InvoiceItem;
                        $invoiceitm->entity_id      .= session('entity_id');
                        $invoiceitm->invoice_id     .= $input['form']['id'];
                        $invoiceitm->product_id     .= $value['product_id']['id'];
                        $invoiceitm->description    .= $value['description'];
                        $invoiceitm->quantity       .= $value['quantity'];
                        $invoiceitm->price          .= $value['price'];
                        $invoiceitm->discount_type  .= $value['discount_type'];
                        $invoiceitm->discount_amount.= $value['it_disamt'];
                        if($value['tax_id']!=null)$invoiceitm->tax_id .= $value['tax_id']['id'];
                            else $invoiceitm->tax_id = null;
                        $invoiceitm->tax_amount     .= $value['it_taxamt'];
                        $invoiceitm->total_amount   .= $value['it_totamt'];
                        $invoiceitm->created        .= AppHelpers::instance()->DateTimeZone(now());
                        $invoiceitm->created_by     .= Auth::user()->id;
                        $invoiceitm->save();

                        if($value['tax_id']!=null) {
                            $tax     = taxes('','',$value['tax_id'],'');
                            foreach($tax as $val){
                                    $amount  = (($value['it_totamt'] * ($val['tax_amount']/100)));
                                    $taxname = $val['tax_group'].' '.$val['tax_amount'].'%';
                            $invoicetax = new InvoiceTax;
                            $invoicetax->entity_id  .= session('entity_id');
                            $invoicetax->invoice_id .= $input['form']['id'];
                            $invoicetax->tax_id     .= $val['id'];
                            $invoicetax->name       .= $taxname;
                            $invoicetax->amount     .= $amount;
                            $invoicetax->created    .= AppHelpers::instance()->DateTimeZone(now());
                            $invoicetax->created_by .= Auth::user()->id;
                            $invoicetax->save();
                            }
                        }
                    }
            }else{
                if($value['tax_id']==null)$value['tax_id'] = null;//dd($invoiceitm->tax_id);
                        else $value['tax_id'] = $value['tax_id']['id'];
                InvoiceItem::where('id', $value['id'])->update(array(
                    'entity_id'     => session('entity_id'),
                    'invoice_id'    => $input['form']['id'],
                    'product_id'    => $value['product_id']['id'],
                    'description'   => $value['description'],
                    'quantity'      => $value['quantity'],
                    'price'         => $value['price'],
                    'discount_type' => $value['discount_type'],
                    'discount_amount'=> $value['it_disamt'],
                    'tax_id'        => $value['tax_id'],
                    'tax_amount'    => $value['it_taxamt'],
                    'total_amount'  => $value['it_totamt'],
                    'modified'      => AppHelpers::instance()->DateTimeZone(now()),
                    'modified_by'   => Auth::user()->id,
                ));

                if($value['tax_id']!=null) {
                    $tax     = taxes('','',$value['tax_id'],'');
                    foreach($tax as $val){
                        $amount  = (($value['it_totamt'] * ($val['tax_amount']/100)));
                        $taxname = $val['tax_group'].' '.$val['tax_amount'].'%';
                        // dd($val['id']);
                        InvoiceTax::where('tax_id',$val['id'])->where('invoice_id',$input['form']['id'])->where('entity_id',session('entity_id'))
                            ->update(array(
                            'name'          => $taxname,
                            'amount'        => $amount,
                            'modified'      => AppHelpers::instance()->DateTimeZone(now()),
                            'modified_by'   => Auth::user()->id,
                        ));
                    }
                }
            }
        }
        return Redirect::route('invoice');
    }
    public function invoicePdf($id)
    {
        $invoice        = $this->invoice($id);
        $invoiceitem    = $this->invoiceiteam($id);
        $toAddress      = $this->toAddress($id);
        $fromAddress    = $this->fromAddress($id);
        $email          = $this->email();
        $fileName       = $toAddress[0]['legal_name'];
        $invoicetax     = InvoiceTax::where('invoice_id',$id)->where('deleted',0)
                            ->selectRaw("name")->selectRaw("SUM(amount) as amount")
                            ->groupBy('name')->get();
//         dd($toAddress);
//         return view('invoice',compact('invoice', 'toAddress', 'fromAddress', 'invoiceitem','email','invoicetax'));
        // <img src='https://fermi.modocrm.com/public/assets/modo_v3.jpg' width=100 height=20 style='margin-top:10px; margin-left:5px'>
//        $data=[
//            'invoice'=>$invoice, 'toAddress'=>$toAddress, 'fromAddress'=>$fromAddress, 'invoiceitem'=>$fromAddress,'email'=>$email,'invoicetax'=>$invoicetax
//        ];


//        $pdf = Pdf::setOption('footer-html' ,"<footer style='text-align:center; color:#969BA7; border-top:1px solid #D8DADF'>  	&#169; Powered By <img src='https://fermi.modocrm.com/public/assets/modo_v3.jpg' width=100 height=20 style='margin-top:10px; margin-left:5px'></footer>")
//            ->setOption('footer-font-size', 10)->loadView('invoice',compact('invoice', 'toAddress', 'fromAddress', 'invoiceitem','email','invoicetax'));
//        dd($pdf);
        $pdf1=view('invoice',[
            'invoice'=>$invoice, 'toAddress'=>$toAddress, 'fromAddress'=>$fromAddress, 'invoiceitem'=>$invoiceitem,'email'=>$email,'invoicetax'=>$invoicetax
        ]);
//         dd($pdf1);
        return $pdf1;
    }
    public function destroy($id)
    {
        Invoice::findOrFail($id)->update(array('deleted'=>'1'));
        InvoiceItem::where('invoice_id', $id)
        ->update([
            'deleted' => 1
        ]);
        return Redirect::route('invoice')->with('success', 'Invoice Deleted.');
    }

    public function paidstatus(Request $request)
    {
        $input=$request->all();
        Invoice::where('id',$input['form']['id'])->where('entity_id',session('entity_id'))->where('deleted',0)->update(array('journal_status'=>'-1'));
        $invoice=Invoice::where('id',$input['form']['id'])->where('entity_id',session('entity_id'))->where('deleted',0)->latest()->first();
        if($invoice['journal_status']==-1){
            $this->generate($input['form']['id']);
        }
        Account::create(array(
            'invoice_id'     =>  $invoice['id'],
            'patron_id'      =>  $invoice['patron_id'],
            'paid_date'      =>  AppHelpers::instance()->getFormattedDate(now()),
            'untaxed_amount' =>  $invoice['untaxed_amount'],
            'total_amount'   =>  $invoice['total_amount'],
            'entity_id'      =>  session('entity_id'),
            'created'        =>  AppHelpers::instance()->DateTimeZone(now()),
            'created_by'     =>  Auth::user()->id,
        ));

        return Redirect::route('invoice')->with('success', 'Successfully Paid.');
    }

    public function cancelStatus($id)
    {
//        $input=$request->all();
//dd($id);
        $invoice=Invoice::where('id',$id)->where('journal_status',0)->where('cancel_status',0)->where('entity_id',session('entity_id'))->where('deleted',0)->get();
//        dd($invoice);
        if(count($invoice)!=0){
            Invoice::where('id',$id)->where('entity_id',session('entity_id'))->update(array('cancel_status'=>'1'));
        }


        return Redirect::route('invoice')->with('success', 'Successfully Paid.');
    }
    public function rowdelete($row)
    {
        $rowdelete =InvoiceItem::findOrFail($row)->update(array('deleted'=>'1'));
        return $rowdelete;
    }
    public function invoicemail($id){

        $invoice        = $this->invoice($id);
        $invoiceitem    = $this->invoiceiteam($id);
        $toAddress      = $this->toAddress($id);
        $fromAddress    = $this->fromAddress($id);
        $email          = $this->email();
        $invoicetax     = InvoiceTax::where('invoice_id',$id)->where('deleted',0)
                            ->selectRaw("name")->selectRaw("SUM(amount) as amount")
                            ->groupBy('name')->get();
        Invoice::findOrFail($id)->update(array('is_sent'=>'1'));
        return View::make('invoice',compact('invoice','invoiceitem','toAddress','fromAddress','email','invoicetax'));
        return Pdf::loadView('invoice',compact('invoice','invoiceitem','toAddress','fromAddress','email','invoicetax'));

//       \Mail::to($toAddress[0]->email)->send(new \App\Mail\InvoiceMail($invoice,$invoiceitem,$toAddress,$fromAddress,$pdf,$email));
//        if (\Mail::failures()) {
//              return response()->Fail('Sorry! Please try again latter');
//        }else{
//              return Redirect::route('invoice')->with('success', 'Successfully .');
//        }
    }
    protected function invoiceiteam($id)
    {
        $invoiceitems   = InvoiceItem::join('invoices', 'invoice_items.invoice_id', 'invoices.id')
                        ->join('products', 'invoice_items.product_id', 'products.id')
                        ->where('invoice_items.invoice_id', '=', $id)->where('invoice_items.deleted',0)
                        ->get(['products.name','products.code', 'invoice_items.quantity','invoice_items.tax_amount','invoice_items.tax_id',
                        'invoice_items.price', 'invoice_items.total_amount', 'invoice_items.description']);

        foreach ($invoiceitems as $key => $val) {
            if($val['tax_id']!=null){
                $tax        = Tax::where('id',$val['tax_id'])->where('deleted','0')->where('entity_id',session('entity_id'))->select('id','tax_name','tax_type','tax_amount')->get()->toArray();
                $taxes      = $tax[0]['tax_amount'];
                $taxeid     = $tax[0]['id'];
                $tax_name=$tax[0]['tax_name'];
            }else{
                $taxes      = null;
                $taxeid     = '';
                $tax_name   =null;
            }
            $invoiceitem[]=['name'      => $val['name'],
                            'code'      => $val['code'] ? $val['code'] : '-',
                            'quantity'  => $val['quantity'],
                            'tax_amount'=> $val['tax_amount'],
                            'tax_id'    => $taxes,
                            'tax_name'  => $tax_name,
                            'price'     => $val['price'],
                            'total_amount'=> $val['total_amount'],
                            'description' => $val['description'],
                            'taxeid'    => $taxeid,
                        ];
        }
        return $invoiceitem;
    }
    protected function invoice($id)
    {
        $invoice=Invoice::join('patrons','invoices.patron_id','patrons.id')
                    ->where('invoices.id', '=', $id)->get([ 'invoices.invoice_number', 'invoices.prefix', 'invoices.untaxed_amount',
                    'invoices.discount_amount','invoices.tax_amount as invoiceTaxAmount','invoices.total_amount as invoice_totalamount',
                    'invoices.start_date','invoices.end_date', 'invoices.notes', 'invoices.notes','invoices.type', 'invoices.untaxed_amount',
                    'invoices.invoiced_at','invoices.due_at','patrons.legal_name']);

        return $invoice;
    }
    protected function toAddress($id)
    {
        $toAddress=PatronContact::join('invoices', 'invoices.patron_id', '=', 'patron_contacts.patron_id')
                    ->join('patrons', 'patrons.id', '=', 'patron_contacts.patron_id')
                    ->join('contacts', 'contacts.id', '=', 'patron_contacts.contact_id')
                    ->where('invoices.id', '=', $id)
                    ->get(['patrons.legal_name', 'contacts.line_1','contacts.line_2','patrons.gstin',  'contacts.zipcode', 'contacts.state_name', 'contacts.city', 'contacts.email', 'contacts.mobile'])
                    ->take(1);

        return $toAddress;
    }
    protected function fromAddress($id)
    {
        $fromAddress=EntityContact::join('invoices', 'invoices.entity_id', '=', 'entity_contacts.entity_id')
                    ->join('entities', 'invoices.entity_id', '=', 'entities.id')
                    ->join('contacts', 'contacts.id', '=', 'entity_contacts.contact_id')
                    ->where('invoices.id', '=', $id)
                    ->get(['entities.legal_name', 'entities.logo_file', 'contacts.line_1', 'contacts.line_2','entities.gstin', 'contacts.zipcode', 'contacts.state_name', 'contacts.city', 'contacts.email', 'contacts.mobile'])
                    ->take(1);
        return $fromAddress;
    }
    protected function email()
    {
        $email=Email::where('entity_id',session('entity_id'))->get();
        return $email;
    }
    public function invoiceexport(Request $request)
    {
        if($request->customer_name!=null) $request->customer_name=$request->customer_name['legal_name'];
        $paid_status='';
        if($request->paid_status=='1')   $paid_status='1';
        if($request->paid_status=='0')  $paid_status='0';

        $invoiceitems   = InvoiceItem::join('invoices', 'invoice_items.invoice_id', 'invoices.id')
                        ->join('patrons', 'invoices.patron_id', 'patrons.id')
                        ->join('products', 'invoice_items.product_id', 'products.id')
                        ->where('invoice_items.deleted',0)
                        ->orderBy('invoiced_at','asc')
                        ->where('invoice_items.entity_id',session('entity_id'))
                        ->when($request->invoice_number, function($query, $invoice_number) {
                            $query->where('invoices.invoice_number', 'like', '%'.$invoice_number.'%');
                        })->when($paid_status, function($query, $paid_status) {
                            $query->where('invoices.paid_status', $paid_status);
                        })->when($request->from_date, function($query, $from_date) {
                            $query->whereDate('invoices.invoiced_at', '>=', date($from_date));
                        })->when($request->to_date, function($query, $to_date) {
                            $query->whereDate('invoices.invoiced_at','<=', date($to_date));
                        });

        $data =$invoiceitems->get(['products.name as product','products.code', 'invoice_items.quantity','invoice_items.tax_amount','invoice_items.tax_id',
                        'invoice_items.price', 'invoice_items.total_amount as linetotalamount', 'invoice_items.description', 'invoices.invoice_number','invoices.prefix','invoices.invoiced_at',
                        'invoices.due_at','invoices.cancel_status','invoices.total_amount as grand_total', 'invoices.start_date','invoices.end_date', 'patrons.legal_name', 'patrons.gstin']);

        return Excel::download(new ExportInvoice($data), 'Invoice.xlsx');
    }
    public function invoicenumber($date){
        $mydate     = new Carbon($date);
        $date_year  = $mydate->format('Y');
        $invoicevalue   = Invoice::where('entity_id',session('entity_id'))
                            ->whereYear('invoiced_at',$date_year)->where('deleted', 0)->latest()->first();
        $inv_id         = $invoicevalue ? $invoicevalue['invoice_number']+1 : 1;
        return  $inv_id;
    }

    public function BulkInvoiceMail()
    {

        $patron=Patron::join('patron_contacts', 'patrons.id', '=', 'patron_contacts.patron_id')
            ->join('contacts', 'patron_contacts.contact_id', '=', 'contacts.id')
            ->where('patrons.entity_id',session('entity_id'))->where('patrons.deleted', 0)->get();

        foreach($patron as $item=>$value) {
            if($value['email']!=null) {

                $date=new \DateTime(now());
                $currentMonth =  $date->format('m');
                $currentYear  =  $date->format('Y');
            $getinvoice=Invoice::whereMonth('start_date', $currentMonth)->whereYear('start_date', $currentYear)
                ->where('entity_id',session('entity_id'))->where('deleted', 0)->get();
                foreach($getinvoice as $key1=>$value1) {
                    if($value1['is_sent']==0) {
                        $id             = $value1['id'];
                        $invoice        = $this->invoice($id);
                        $invoiceitem    = $this->invoiceiteam($id);
                        $toAddress      = $this->toAddress($id);
                        $fromAddress    = $this->fromAddress($id);
                        $email          = $this->email();
                        $invoicetax = InvoiceTax::where('invoice_id', $id)->where('deleted', 0)
                            ->selectRaw("name")->selectRaw("SUM(amount) as amount")
                            ->groupBy('name')->get();

                        $pdf = Pdf::loadView('invoice', compact('invoice', 'invoiceitem', 'toAddress', 'fromAddress', 'email', 'invoicetax'));

                        \Mail::to($toAddress[0]->email)->send(new \App\Mail\InvoiceMail($invoice, $invoiceitem, $toAddress, $fromAddress, $pdf, $email));

                        Invoice::findOrFail($id)->update(array('is_sent' => '1'));
                        if (\Mail::failures()) {
                            return response()->Fail('Sorry! Please try again latter');
                        } else {
                            return Redirect::route('invoice')->with('success', 'Successfully .');
                        }
                    }else{
                        return Redirect::route('invoice')->with('success', 'Successfully .');
                    }
                }
            }
        }
    }

    public function generate($id)
    {
        $invoice=Invoice::with('invoice_items','patrons')->where('entity_id', session('entity_id'))->where('id','=',$id)
            ->where('deleted', '=','0')->latest('id')->first();
        $journal_ref_no = Transaction::where('entity_id', session('entity_id'))->where('deleted', '0')->latest('id','ref_no')->first();

        if ($journal_ref_no == null) $ref_no = 1;
        else $ref_no = (int)$journal_ref_no['ref_no'] + 1;

        $reference = 'TR-'.Str::padLeft($ref_no, 4, 0);
        Transaction::create(array(
            'entity_id'         => session('entity_id'),
            'patron_id'         => $invoice['patron_id'],
            'tx_date'           => AppHelpers::instance()->DateTimeZone(now()),
            'reference'         => $reference,
            'origin_id'         => $invoice['id'],
            'ref_no'            => $ref_no,
            'tx_type'           => 'Invoice',
            'tx_amount'         => $invoice['total_amount'],
            'description'       => null,
            'status'            => '1',
            'created_at'        => AppHelpers::instance()->DateTimeZone(now()),
            'created_by'        => Auth::user()->id
        ));

        $transactionid = Transaction::where('entity_id', session('entity_id'))->where('deleted', '0')->latest('id')->first();

        $taxitem=[];
        foreach ($invoice['invoice_items'] as $value) {
            if ($value['tax_id'] != null) {
                $tax = AppHelpers::instance()->tax('', '', $value['tax_id'], '');
                if (count($tax) != 0) {
                    foreach ($tax as $val) {
                        $amount = (($value['total_amount'] * ($val['tax_amount'] / 100)));
                        $taxname = $val['tax_group'] . ' ' . $val['tax_amount'] . '%';
                        $taxitem[]= array(
                            'id'            => $val['id'],
                            'tax_amount'    => $val['tax_amount'],
                            'tax_name'      => $val['tax_name'],
                            'tax_value'     => $amount,
                            'taxname'       => $taxname,
                            'account_id'    => $val['account_id']
                        );
                    }
                }
            }
        }
        $hire=array(
            'total_amount'         =>  $invoice['total_amount'],
            'subtotal'          =>  $invoice['untaxed_amount'],
            'discount'          =>  $invoice['discount_amount'],
            'tax_amount'        =>  $invoice['tax_amount'],
        );
        if (count($taxitem) != 0) {
            foreach($taxitem as $items) {
                if (count($items) != 0) {
                    $defaultLedger=AppHelpers::instance()->defaultledger('Tax',$items['tax_name']);
                    $journal = new Journal;
                    $journal->entity_id         .= session('entity_id');
                    $journal->ledger_id         .= $defaultLedger!=null ? $defaultLedger[0]['ledger_id'] : null;
                    $journal->transaction_id    .= $transactionid['id'];
                    $journal->entry_date        .= AppHelpers::instance()->DateTimeZone(now());
                    $journal->debit_amount      .= $items['tax_value'] ? $items['tax_value'] : '0';
                    $journal->tax_id            .= $items['id'] ? $items['id'] : 0;
                    $journal->narration         .= $items['taxname'] ? $items['taxname'] : null;
                    $journal->credit_amount     .=  '0';
                    $journal->notes             .= ' ('.$invoice['prefix'].$invoice['invoice_number'].')';
                    $journal->created_at        .= AppHelpers::instance()->DateTimeZone(now());
                    $journal->status            .= '1';
                    $journal->created_by        .= Auth::user()->id;
                    $journal->save();
                }
            }
        }
        if(count($hire) != 0){
            if ($hire['total_amount'] != 0) {
                    $patron=AppHelpers::instance()->reportpatrons($invoice['patron_id'],'');
                $journal = new Journal;
                $journal->entity_id             .= session('entity_id');
                $journal->ledger_id             .= $patron ? $patron[0]['credit_ledger_id'] : null;
                $journal->transaction_id        .= $transactionid['id'];
                $journal->entry_date            .= AppHelpers::instance()->DateTimeZone(now());
                if ($invoice['patron_id'] != null) $journal->patron_id .= $invoice['patron_id'];
                else $journal->patron_id = null;
                $journal->debit_amount          .=  '0';
                $journal->narration             .=  'Bill Generated For : '.$invoice['prefix'].$invoice['invoice_number'];
                $journal->credit_amount         .=  $hire['total_amount'] ? $hire['total_amount'] : '0';
                $journal->notes                 .=  null;
                $journal->created_at            .=  AppHelpers::instance()->DateTimeZone(now());
                $journal->status                .=  '1';
                $journal->created_by            .=  Auth::user()->id;
                $journal->save();
            }
            if ($hire['subtotal'] != 0) {
                $journal = new Journal;
                $ledger=Ledger::where('id',$invoice['ledger_id'])->where('deleted',0)->where('entity_id',session('entity_id'))->latest()->first();

                $journal->entity_id             .= session('entity_id');
                $journal->ledger_id             .= $ledger['id'];
                $journal->transaction_id        .= $transactionid['id'];
                $journal->entry_date            .= AppHelpers::instance()->DateTimeZone(now());

                $journal->debit_amount          .=  $hire['subtotal'] ? $hire['subtotal'] : '0';
                $journal->narration             .=  $ledger['title'].' ('.$invoice['prefix'].$invoice['invoice_number'].')';
                $journal->credit_amount         .=  '0';
                $journal->notes                 .=  'Sub Total';
                $journal->created_at            .=  AppHelpers::instance()->DateTimeZone(now());
                $journal->status                .=  '1';
                $journal->created_by            .=  Auth::user()->id;
                $journal->save();
            }
            if ($hire['discount'] != 0) {
                if ($invoice['discount'] >0)
                {
                    $patron=AppHelpers::instance()->defaultledger('Discount', 'Debit Ledger');
                }else{
                    $patron=AppHelpers::instance()->defaultledger('Discount', 'Credit Ledger');
                }
                $journal = new Journal;
                $journal->entity_id             .= session('entity_id');
                $journal->ledger_id             .=  $patron ? $patron[0]['ledger_id'] : null;
                $journal->transaction_id        .= $transactionid['id'];
                $journal->entry_date            .= AppHelpers::instance()->DateTimeZone(now());
                $journal->debit_amount          .=  $hire['discount']>0 ? $hire['discount'] : '0';
                $journal->narration             .=  'Discount'.' ('.$invoice['prefix'].$invoice['invoice_number'].')';
                $journal->credit_amount         .=  $hire['discount']<0 ? $hire['discount'] : '0';
                $journal->notes                 .=  null;
                $journal->created_at            .=  AppHelpers::instance()->DateTimeZone(now());
                $journal->status                .=  '1';
                $journal->created_by            .=  Auth::user()->id;
                $journal->save();
            }

        }

        //journal status update in invoice
        if($invoice['journal_status'] == '-1') {
            Invoice::where('id', $invoice['id'])->update(array(
                'paid_status'       => '1',
                'journal_status'    => '1',
                'modified'          => AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'       => Auth::user()->id,
                'entity_id'         => session('entity_id'),
            ));
        }

        $payTrans = PaymentTransaction::where('entity_id', session('entity_id'))->where('deleted', '0')->latest('id','ref_no')->first();

        if ($payTrans == null) $ref_no1 = 1;
        else $ref_no1 = (int)$payTrans['ref_no'] + 1;
        $reference1 = Str::padLeft($ref_no1, 4, 0);

        PaymentTransaction::create(array(
            'entity_id'        =>  session('entity_id'),
            'payment_date'     =>  AppHelpers::instance()->DateTimeZone(now()),
            'ledger_id'        =>  $invoice['ledger_id'],
            'total_amount'     =>  $invoice['total_amount'],
            'prefix'           =>  'P - ',
            'patron_id'        =>  $invoice['patron_id'],
            'ref_no'           =>  $reference1,
            'bill_ref_id'      =>  $invoice['id'],
            'payment_type'     =>  'Payment',
            'description'      =>  'Invoice',
            'status'           =>  '0',
            'created_at'       =>  AppHelpers::instance()->DateTimeZone(now()),
            'created_by'       =>  Auth::user()->id
        ));

        $ptid = PaymentTransaction::where('entity_id',session('entity_id'))->where('deleted','0')->latest('id')->first();

        $paymentiteam = new Payment;

        $paymentiteam->entity_id              .= session('entity_id');
        $paymentiteam->payment_transaction_id .= $ptid['id'];
        $paymentiteam->payment_type           .= 'Payment';
        $paymentiteam->patron_id              .= $invoice['patron_id'];
        $paymentiteam->payment_date           .= AppHelpers::instance()->DateTimeZone(now());
        $paymentiteam->total_amount           .= $invoice['total_amount'] ? $invoice['total_amount'] : 0.00;
        $paymentiteam->description            .= ' ('.$invoice['prefix'].$invoice['invoice_number'].')';
        $paymentiteam->paid_amount            .= $invoice['total_amount'] ? $invoice['total_amount'] : 0.00;
        $paymentiteam->ledger_id              .= $invoice['ledger_id'] ? $invoice['ledger_id'] : 0.00;
        // $paymentiteam->journal_type_id     .= $value['journal_type_id'] ? $value['journal_type_id']['id'] : null;
        $paymentiteam->bill_ref_id            .= $invoice['id'];
        $paymentiteam->balance_due            .= 0.00;
        $paymentiteam->status                 .= '1';
        $paymentiteam->journal_status         .= '0';
        $paymentiteam->created_at             .= AppHelpers::instance()->DateTimeZone(now());
        $paymentiteam->created_by             .= Auth::user()->id;
        $paymentiteam->save();

        return Redirect::route('invoice');
    }



    public function downloadInvoices()
    {
        $invoices = Invoice::where('entity_id', session('entity_id'))->where('deleted', 0)->where('status', 1)->whereYear('start_date', Carbon::now()->year)
        ->whereMonth('start_date', Carbon::now()->month)->get(); // Adjust limit if needed
        $zipFileName = 'invoices.zip';
        $zipPath = storage_path('app/' . $zipFileName);

        // Create ZipArchive instance
        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {

            foreach ($invoices as $invoice) {
                $customers = \App\Models\Patron::where('entity_id', session('entity_id'))->where('id','=',$invoice->patron_id)->where('deleted', 0)->where('status', 1)->get();
                $invoice_temp=$this->invoicemail($invoice->id);
//
//                $htmlFilePath = storage_path('app/temp_report.html');
//
//                file_put_contents($htmlFilePath, $invoice_temp);
//                $imagePath = storage_path('app/ticket-report.jpeg');
//                $nodePath = 'C:\\Program Files\\nodejs\\node.exe';
//                $scriptPath = base_path('resources\js\generateImage.js');
//                $process = new Process([
//                    $nodePath, $scriptPath, str_replace('/', '\\', $htmlFilePath), str_replace('/', '\\', $imagePath)
//                ]);
//
//                $process->setTimeout(60);
//
//                try {
//                    $process->mustRun();
//                } catch (ProcessFailedException $exception) {
//                    return response()->json([
//                        'error' => 'Failed to generate image',
//                        'details' => $exception->getMessage()
//                    ], 500);
//                }
//                return response()->download($imagePath, 'ticket-report.jpeg', [
//                    'Content-Type' => 'image/jpeg',
//                    'Content-Disposition' => 'attachment; filename="ticket-report.jpeg"',
//                ])->deleteFileAfterSend(true);



//                dd($customers);
                $pdfFileName = "{$invoice->prefix}{$invoice->invoice_number} {$customers[0]->legal_name}.pdf";
                $pdfPath = storage_path("app/invoices/{$pdfFileName}");

                // Generate PDF if it doesn't exist
                if (!file_exists($pdfPath)) {
//                    $pdf = \PDF::loadView('invoice', compact('invoice'));
                    Storage::put("invoices/{$pdfFileName}", $invoice_temp->output(),[
                        'Content-Type' => 'application/pdf',
                        'Content-Disposition' => 'attachment; filename="invoice.pdf"',
                    ]);
                }

                // Add to ZIP
                $zip->addFile($pdfPath, $pdfFileName);
            }

            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create ZIP file'], 500);
        }

        // Return ZIP file as download
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
