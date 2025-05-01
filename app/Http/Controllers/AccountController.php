<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\LeadType;
use App\Models\Account;
use Carbon\Carbon;
use App\Models\LeadPipelineStage;
use App\Imports\LeadImport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:edit_accounts|create_accounts|delete_accounts', ['only' => ['index','store']]);
         $this->middleware('permission:create_accounts', ['only' => ['create','store']]);
         $this->middleware('permission:edit_accounts', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_accounts', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        return Inertia::render('Account/Index', [
            $account    = Account::where('deleted',0)->where('entity_id',session('entity_id'))->paginate(15),
           'accounts'   =>  Account::with('invoice','patron')->where('deleted',0)->where('entity_id',session('entity_id'))
                       ->orderBy('id', 'DESC')
                       ->paginate( 15)
                       ->through( fn ($accounts) => [
                           'id'                => $accounts->id,
                           'invoice_id'        => $accounts->invoice ?
                                                  $accounts->invoice->only(['id','type','prefix','invoice_number','order_number','paid_status',
                                                  'start_date','end_date','invoiced_at','due_at','untaxed_amount',
                                                  'tax_amount','total_amount','discount_amount',]) : null,
                           'patron_id'         => $accounts->patron ?
                                                  $accounts->patron->only(['id','patron_type','legal_name','poc_name','gstin']) : null,
                           'untaxed_amount'    => $accounts->untaxed_amount,
                           'total_amount'      => $accounts->total_amount,
                           'paid_date'         => $accounts->paid_date ? changeDateFormate($accounts->paid_date) : null ,
                       ]),
           'total'     => $account->total(),
           'firstItem' => $account->firstItem(),
           'lastItem'  => $account->lastItem(),
        ]);
    }

}
