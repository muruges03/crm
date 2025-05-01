<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelpers;
use App\Models\Accounts;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class AccountTypeController extends Controller
{
    public function index()
    {
        $length = request('length', 10);

        $accountType = QueryBuilder::for(AccountType::class)
            ->join('accounts','accounttype.account_id','=','accounts.id')
            ->where('accounttype.deleted','=',0)->where('accounttype.entity_id',session('entity_id'))
            ->select('accounttype.id','accounttype.type_name','accounts.name')
            ->defaultSort('accounttype.id')
            ->allowedSorts(['accounttype.id','accounttype.type_name'])->when(request('term'), function ($query, $term) {
                    $query->where('accounttype.type_name', 'like', "%{$term}%")
                        ->orWhere('accounts.name', 'like', "%{$term}%");
                })
            ->paginate($length)
            ->withQueryString();
        return Inertia::render('AccountType/Index', [
            'accountType' => $accountType,

        ])->table(function (InertiaTable $table) {
            $table->addColumns([
                'id'=>'id',
                'name'      => 'name',
                'type_name'  => 'type_name',
            ]);
        });
    }
    public function create()
    {
        return Inertia::render('AccountType/Create',[
            'account'=>Accounts::where('deleted',0)->where('entity_id',session('entity_id'))->get(),
        ]);
    }
    public function store(Request $request)
    {
        $input=$request->all();
//        dd($input);
        $validate =  $this->validateAccount();
        AccountType::create(array(
            'type_name'          =>  $input['type_name'],
            'account_id'         =>  $input['account_id']['id'],
            'status'             =>  '1',
            'created'            =>  AppHelpers::instance()->DateTimeZone(now()),
            'created_by'         =>  Auth::user()->id,
            'entity_id'          =>  session('entity_id')
        ));

        return Redirect::route('accountType.index');
    }

    public function edit($id)
    {
//        dd($id);
        $accountType=AccountType::where('deleted',0)->where('entity_id',session('entity_id'))->where('id',$id)->get();
        $account   = Accounts::where('deleted',0)->where('entity_id',session('entity_id'))->where('id',$accountType[0]['account_id'])->get();
        return Inertia::render('AccountType/Edit',[
            'account'=>Accounts::where('deleted',0)->where('entity_id',session('entity_id'))->get(),
            'accountType'=>array(
                'id'                => $accountType[0]->id,
                'type_name'              => $accountType[0]->type_name,
                'account_id'        =>$account[0],
            ),
        ]);
    }

    public function update(Request $request)
    {
        $input = $request->all();
//        dd($input);
        $validate =  $this->validateAccount();
        AccountType::where('id',$input['id'])->update(array(
            'type_name'          =>  $input['type_name'],
            'account_id'         =>  $input['account_id']['id'],
            'status'            =>  '1',
            'modified'       =>   AppHelpers::instance()->DateTimeZone(now()),
            'modified_by'       =>  Auth::user()->id,
            'entity_id'         =>  session('entity_id')
        ));

        return  Redirect::route('accountType.index');
    }



    public function destroy($id)
    {
//        dd($id);
//        $ac_type=AccountType::where('account_id',$id)->where('deleted','=','0')->where('entity_id',session('entity_id'))->get();
////         dd(count($ac_ty_id), count($ac_type));
//        if(count($ac_type) == 0) {
        AccountType::findOrFail($id)->update(array('deleted' => '1'));
        //log
//            return true;
//        }else{
//            return 'failed';
//        }
//        Account::findOrFail($id)->update(array('deleted'=>'1','deleted_at'=>AppHelpers::instance()->DateTimeZone(now()),'deleted_by'=>Auth::user()->id));
        return Redirect::route('accountType.index');
    }

    protected function validateAccount()
    {
        return request()->validate([
            'type_name'   => ['required',Rule::unique('accounttype')->where(function ($query) {
                return $query->where('entity_id',session('entity_id'));
            })],
        ]);
    }
}
