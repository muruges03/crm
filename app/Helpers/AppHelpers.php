<?php

namespace App\Helpers;

use App\Models\AccountType;
use App\Models\DefaultSetting;
use App\Models\Entity;
use App\Models\LeaveType;
use App\Models\Ledger;
use App\Models\Patron;
use App\Models\Personnel;
use App\Models\Tax;
use Carbon\Carbon;

use Illuminate\Support\Str;

class AppHelpers {

    public function getAge($date) {

        return  ( Carbon::parse($date)->diff(\Carbon\Carbon::now())->format('%y') < 1 ) ?
            Carbon::parse($date)->diff(\Carbon\Carbon::now())->format('%m+ months') :
            Carbon::parse($date)->diff(\Carbon\Carbon::now())->format('%y+ years');
    }

    public function DateTimeZone($date)
    {

        $str_date=Carbon::parse($date)->format('Y-m-d H:i:s');
//        dd($str_date);
        $_date=Carbon::createFromFormat('Y-m-d H:i:s',$str_date)->setTimezone('Asia/Kolkata');
//dd($_date);
        return $_date;
    }

    public function getFormattedDate($date)
    {
        return Carbon::parse($date)->format("Y-m-d H:i:s");
    }
    public function getFormattedDateMonthYear($date)
    {
        return Carbon::parse($date)->format("d/m/Y");
    }
    public function getFormattedDateList($date)
    {
        return Carbon::parse($date)->format("Y-m-d");
    }

    public function getMonthYeardata($date)
    {
        return Carbon::parse($date)->format("M Y");
    }

    public static function instance()
    {
        return new AppHelpers();
    }

    function formatCurrency($amount)
    {
        return number_format($amount, 2);
        // dd($amount);
    }

    function entity($id,$type){

        $entity =  Entity::where('id','=',$id);
//                     if($id!='')   $entity = $entity->where('id',$id);
        if($type!='') $entity = $entity->where('entity_type',$type);
        $entity = $entity->get();
//dd($entity);
        return $entity;
    }

    function tax($id,$type,$pid,$tygrp){

        $tax  =  Tax::where('entity_id',session('entity_id'))->where('deleted',0);
//       ->where('tax_group','<>','CGST')->where('tax_group','<>','SGST')
        if($id!='')   $tax = $tax->where('id',$id);
        if($type!='') $tax = $tax->where('tax_type',$type);
        if($pid!='')  $tax = $tax->where('parent_id',$pid);
        if($tygrp!='')$tax = $tax->where('tax_group',$tygrp);

        $tax  =  $tax->get(['id','tax_name', 'tax_amount','tax_group', 'tax_type','parent_id','account_id','deleted']);
//       dd($tax,$pid);
        if(!empty($tax))  $taxs = $tax;
        else  $taxs = '';

        return $taxs;
    }

    function ledgers($id,$type)
    {
//       dd($id);
        $ledgers=Ledger::with('account_type')->where('deleted','=',0)->where('entity_id',session('entity_id'));
        if($id!='')    $ledgers = $ledgers->where('ledger.id','=',$id);
        if($type!='')    $ledgers = $ledgers->where('ledger.type','=',$type);
        $ledgers=$ledgers->get(['id', 'title', 'account_type_id']);
//      dd($ledgers);
        return $ledgers;
    }

    function defaultledger($type,$value)
    {
//        dd($type,$value);
        $defaultledger=DefaultSetting::where('deleted',0)->where('entity_id',session('entity_id'));
        if($type!='')   $defaultledger = $defaultledger->where('type','like', '%' .$type. '%');
        if($value!='')  $defaultledger = $defaultledger->where('name','like', '%' .$value. '%');
        $defaultledger=$defaultledger->get(['id','ledger_id','name','type']);
//            dd($defaultledger);
        return $defaultledger;
    }

    function personnel($id)
    {
//        dd($id,$type);
        $patrons  = Personnel::where('entity_id',session('entity_id'));
        if($id!='')   $patrons = $patrons->where('id',$id);
        $patrons  = $patrons->where('deleted','=',0)->get();

        return $patrons;
    }

    function leaveType($id)
    {
//        dd($id,$type);
        $leave  = LeaveType::where('entity_id',session('entity_id'));
        if($id!='')   $leave = $leave->where('id',$id);
        $leave  = $leave->get();
//dd($leave);
        return $leave;
    }


    function patrons($id,$type)
    {
//        dd($id,$type);
        $patrons  = Patron::with('contacts')->where('entity_id',session('entity_id'))->where('status','=','1');
        if($id!='')   $patrons = $patrons->where('id',$id);
        if($type!='') $patrons = $patrons->where('patron_type','=', $type);
        $patrons  = $patrons->where('deleted','=',0)->get(['id','patron_type','legal_name','gstin','deleted']);

        return $patrons;
    }

    function reportpatrons($id,$type)
    {
        $patrons  = Patron::where('entity_id',session('entity_id'))->where('status','=','1')->where('credit_ledger_id', '<>', null)->where('debit_ledger_id', '<>', null);
        if($id!='')   $patrons = $patrons->where('id',$id);
        if($type!='') $patrons = $patrons->where('patron_type','like', '%'.$type.'%');
        $patrons  = $patrons->where('deleted',0)->get(['id','patron_type','legal_name','gstin','deleted','credit_ledger_id', 'debit_ledger_id']);
        return $patrons;
    }

    function account_type_ledger($id,$value)
    {
        $account_type_ledger=AccountType::join('accounts', 'accounttype.account_id','=','accounts.id')
                        ->join('ledger','accounttype.id','=','ledger.account_type_id')->where('accounttype.entity_id',session('entity_id'))
                        ->where('accounttype.deleted',0) ->where('ledger.deleted',0);
            if($id!='')   $account_type_ledger = $account_type_ledger->where('ledger.id',$id);
            if($value!='') $account_type_ledger = $account_type_ledger->where('accounts.name','like', '%'.$value.'%');
            $account_type_ledger=$account_type_ledger->get(['ledger.id as id','ledger.*','accounts.name as a_title', 'accounttype.type_name as ac_title', 'ledger.title as l_title']);
        return $account_type_ledger;
    }

    public function getFormattedDateMonthWord($date)
    {
        return Carbon::parse($date)->format("d-M-Y");
    }
}
