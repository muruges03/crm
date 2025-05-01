<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelpers;
use App\Models\Account;
use App\Models\Accounts;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class AccountsController extends Controller
{
    public function index()
    {
        $length = request('length', 10);

        $account = QueryBuilder::for(Accounts::class)
            ->where('deleted','=',0)->where('entity_id',session('entity_id'))
            ->defaultSort('id')
            ->allowedSorts(['id','name'])->when(request('term'), function ($query, $term) {
                $query->where('name', 'like', "%{$term}%");
            })
            ->paginate($length)
            ->withQueryString();
//dd($tax);
        return Inertia::render('Account/Index1', [
            'account' => $account,

        ])->table(function (InertiaTable $table) {
            $table->addColumns([
                'id'    => 'id',
                'name'  => 'name',
            ]);
        });
    }
    public function create()
    {
        return Inertia::render('Account/Create');
    }
    public function store(Request $request)
    {
        $input=$request->all();
//        dd($input);
//        $validate =  $this->validateAccount();
        Accounts::create(array(
            'name'              =>  $input['name'],
            'status'             =>  '1',
            'created_at'         =>  AppHelpers::instance()->DateTimeZone(now()),
            'created_by'         =>  Auth::user()->id,
            'entity_id'          =>  session('entity_id')
        ));

        return Redirect::route('accounts.index');
    }

    public function edit(Accounts $accounts,$id)
    {
//        dd($id);
        $account=Accounts::where('deleted',0)->where('entity_id',session('entity_id'))->where('id',$id)->get();
        return Inertia::render('Account/Edit',[
            'account'=>array(
                'id'                => $account[0]->id,
                'name'             => $account[0]->name,
            ),
        ]);
    }

    public function update(Request $request)
    {
        $input = $request->all();
//        dd($input);
        Accounts::where('id',$input['id'])->update(array(
            'name'             =>  $input['name'],
            'status'            =>  '1',
            'modified'       =>   AppHelpers::instance()->DateTimeZone(now()),
            'modified_by'       =>  Auth::user()->id,
            'entity_id'         =>  session('entity_id')
        ));

        return  Redirect::route('accounts.index');
    }



    public function destroy($id)
    {
//        dd($id);
//        $ac_type=AccountType::where('account_id',$id)->where('deleted','=','0')->where('entity_id',session('entity_id'))->get();
////         dd(count($ac_ty_id), count($ac_type));
//        if(count($ac_type) == 0) {
            Accounts::findOrFail($id)->update(array('deleted' => '1'));
            //log
//            return true;
//        }else{
//            return 'failed';
//        }
//        Account::findOrFail($id)->update(array('deleted'=>'1','deleted_at'=>AppHelpers::instance()->DateTimeZone(now()),'deleted_by'=>Auth::user()->id));
        return Redirect::route('accounts.index');
    }

    protected function validateAccount()
    {
        return request()->validate([
            'name'   => ['required',Rule::unique('accounts')->where(function ($query) {
                return $query->where('entity_id',session('entity_id'));
            })],
        ]);
    }
}
