<?php

use App\Helpers\AppHelpers;
use Carbon\carbon;
use App\Models\User;
use App\Models\Entity;
use App\Http\Requests;
use App\Models\Tax;
use App\Models\InvoiceTax;
use App\Models\Patron;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use App\Models\Invoice;
use App\Models\LeadPipelineStage;


function changeDateFormate($date){
    // dd($date);
    if(!empty($date)){
       return  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $date)->format('d-M-Y');
    }
}
function entity($id){
       session()->put('entity_id',$id);
       $entity=Entity::where('id','=',session('entity_id'))->get('entities.*');
       session()->put('entity_name',$entity[0]['legal_name']);
       session()->put('Organization',$entity[0]->parent_id);
}
function session_end(){
    session()->forget(['entity_id','entity_name','entity_type','Organization','password_hash_web']);
}
function productImagePath($image_name)
{
    return public_path('images/products/'.$image_name);
}

function tax($id,$type,$pid,$tygrp){

    $tax  =  Tax::where('entity_id',session('entity_id'))->where('deleted',0)->whereNotIn('tax_group',['CGST','SGST']);
                     if($id!='')   $tax = $tax->where('id',$id);
                     if($type!='') $tax = $tax->where('tax_type',$type);
                     if($pid!='')  $tax = $tax->where('parent_id',$pid);
//                     if($tygrp!='')$tax = $tax;
    $tax  =  $tax->get(['id','tax_name', 'tax_amount','tax_group', 'tax_type','parent_id','deleted']);
             if(!empty($tax))  $taxs = $tax;
                else  $taxs = '';
       // dd($taxs,$tygrp);
    return $taxs;
 }

function taxes($id,$type,$pid,$tygrp){

    $tax  =  Tax::where('entity_id',session('entity_id'))->where('deleted',0);
    if($id!='')   $tax = $tax->where('id',$id);
    if($type!='') $tax = $tax->where('tax_type',$type);
    if($pid!='')  $tax = $tax->where('parent_id',$pid);
    if($tygrp!='')$tax = $tax->where('tax_group',$tygrp);
    $tax  =  $tax->get(['id','tax_name', 'tax_amount','tax_group', 'tax_type','parent_id','deleted']);
    if(!empty($tax))  $taxs = $tax;
    else  $taxs = '';
    // dd($taxs,$tygrp);
    return $taxs;
}

function auto_taxes($id,$type,$pid,$tygrp,$entity_id){

    $tax  =  Tax::where('entity_id',$entity_id)->where('deleted',0);
    if($id!='')   $tax = $tax->where('id',$id);
    if($type!='') $tax = $tax->where('tax_type',$type);
    if($pid!='')  $tax = $tax->where('parent_id',$pid);
    if($tygrp!='')$tax = $tax->where('tax_group',$tygrp);
    $tax  =  $tax->get(['id','tax_name', 'tax_amount','tax_group', 'tax_type','parent_id','deleted']);
    if(!empty($tax))  $taxs = $tax;
    else  $taxs = '';
    // dd($taxs,$tygrp);
    return $taxs;
}

function patron()
{
    $patron=Patron::where('patron_type','like', '%'.'Customer'.'%')->where('entity_id',session('entity_id'))->where('deleted', 0)->get();
    return $patron;
}
function product()
{
    $product=Product::where('entity_id',session('entity_id'))->where('deleted', 0)->get(['id','name','sale_price','tax_id','description']);
    return $product;
}
function patronid($id)
{
    $patron=Patron::where('patron_type','like', '%'.'Customer'.'%')->where('entity_id',session('entity_id'))->where('id',$id)->get();
    // dd($patron);
    return $patron;
}
function invoicetax($id,$invoiceid,$taxid)
{
    $invoicetax = InvoiceTax::where('entity_id',session('entity_id'))->where('deleted',0);
            if($id!='')         $invoicetax = $invoicetax->where('id',$id);
            if($invoiceid!='')  $invoicetax = $invoicetax->where('invoice_id',$invoiceid);
            if($taxid!='')      $invoicetax = $invoicetax->where('tax_id',$taxid);
    $invoicetax = $invoicetax->get();
    // dd($patron);
    return $invoicetax;
}

function formatCurrency($amount)
{
    //  $fmt = new NumberFormatter(app()->getLocale('en_INR'), NumberFormatter::CURRENCY);
    //  $fmt->formatCurrency($amount, $currency);
    //  return Currency::currency("USD")->format($amount);
    return number_format($amount, 2);
}

function getMonthYear($date)
{
    return Carbon::parse($date)->format("M Y");
}

function getleadpipstag($id){

    $leadpipestage = LeadPipelineStage::where('entity_id',session('entity_id'));
                        if($id!='') $leadpipestage = $leadpipestage->where('id',$id);
    $leadpipestage = $leadpipestage->where('deleted',0)->get();

    return  $leadpipestage;
}


function getFinancialYear($date)
{
    $mydate     = AppHelpers::instance()->DateTimeZone($date);
    $date_month = $mydate->format('m');
    $date_year  = $mydate->format('y');
    $date_years = $mydate->format('Y');
//     dd($date_month,$date_year,$mydate);
    if($date_month < 4){
        $star_year  = $date_year - 1;
        $end_year   = $star_year + 1;
        //invoice select query
        $star_years = $date_years - 1;
        $end_years  = $star_years + 1;

        $fincl_yr   = $star_year.$end_year;
        $invoicevalue   = Invoice::where('entity_id',1)
                            ->whereYear('invoiced_at','>=',$star_years)
                            ->whereYear('invoiced_at','<=',$end_years)
                             ->whereMonth('invoiced_at','<',4)
                            ->where('deleted', 0)->orderBy('invoice_number', 'desc')->latest()->first();
        $ref_no     = $invoicevalue ? $invoicevalue['invoice_number']+1 : 1;
//         dd($invoicevalue,'fr',$ref_no);
        // dd($invoicevalue);
    }else{
        $star_year  = $date_year;
        $end_year   = $date_year + 1;
        //invoice select query
        $star_years = $date_years;
        $end_years  = $star_years + 1;
        $fincl_yr   = $star_year.$end_year;
        $invoicevalue   = Invoice::where('entity_id',1)
                            ->whereYear('invoiced_at','>=',$star_years)
                            ->whereYear('invoiced_at','<=',$end_years)
                             ->whereMonth('invoiced_at','>=',4)
                            ->where('deleted', 0)->orderBy('invoice_number', 'desc')->latest()->first();
        $ref_no     = $invoicevalue ? $invoicevalue['invoice_number']+1 : 1;
        // dd($fincl_yr,'sec',$ref_no,$invoicevalue);
//         dd($invoicevalue,$star_years,$end_years);
    }
//    dd($ref_no,$fincl_yr);
    return [$ref_no,$fincl_yr];
}


function auto_getFinancialYear($date,$patron_id)
{
    $mydate     = AppHelpers::instance()->DateTimeZone($date);
    $date_month = $mydate->format('m');
    $date_year  = $mydate->format('y');
    $date_years = $mydate->format('Y');
//     dd($date_month,$date_year,$mydate);
    if($date_month < 4){
        $star_year  = $date_year - 1;
        $end_year   = $star_year + 1;
        //invoice select query
        $star_years = $date_years - 1;
        $end_years  = $star_years + 1;

        $fincl_yr   = $star_year.$end_year;
        $invoicevalue   = Invoice::where('entity_id',1)
            ->whereYear('invoiced_at','>=',$star_years)
            ->whereYear('invoiced_at','<=',$end_years)
            ->whereMonth('invoiced_at','<',4)
            ->where('deleted', 0)->orderBy('id', 'desc')->get() // Retrieves all matching records
            ->first();
        $ref_no     = $invoicevalue ? $invoicevalue['invoice_number']+1 : 1;
//         dd($invoicevalue['id'],'fr',$ref_no);
        // dd($invoicevalue);
    }else{
        $star_year  = $date_year;
        $end_year   = $date_year + 1;
        //invoice select query
        $star_years = $date_years;
        $end_years  = $star_years + 1;
        $fincl_yr   = $star_year.$end_year;
        $invoicevalue   = Invoice::where('entity_id',1)
            ->whereYear('invoiced_at','>=',$star_years)
            ->whereYear('invoiced_at','<=',$end_years)
            ->whereMonth('invoiced_at','>=',4)
            ->where('deleted', 0)->orderBy('id', 'desc')->get() // Retrieves all matching records
            ->first();
        $ref_no     = $invoicevalue ? $invoicevalue['invoice_number']+1 : 1;
        // dd($fincl_yr,'sec',$ref_no,$invoicevalue);
//         dd($invoicevalue,$star_years,$end_years);
    }
//    dd($ref_no,$fincl_yr);
    return [$ref_no,$fincl_yr];
}


