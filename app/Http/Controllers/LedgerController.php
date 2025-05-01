<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelpers;
use App\Models\Ledger;
use App\Models\AccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class LedgerController extends Controller
{
    public function index()
    {
        $length = request('length', 10);

        $ledger = QueryBuilder::for(Ledger::class)
            ->join('accounttype','ledger.account_type_id','=','accounttype.id')
            ->where('ledger.deleted','=',0)->where('ledger.entity_id',session('entity_id'))
            ->select('ledger.id','ledger.title','accounttype.type_name')
            ->defaultSort('ledger.id')
            ->allowedSorts(['ledger.id','ledger.title'])->when(request('term'), function ($query, $term) {
                $query->where('ledger.title', 'like', "%{$term}%")
                    ->orWhere('accounttype.type_name', 'like', "%{$term}%");
            })
            ->paginate($length)
            ->withQueryString();
//dd($ledger);
        return Inertia::render('Ledger/Index', [
            'ledger' => $ledger,
        ])->table(function (InertiaTable $table) {
            $table->addColumns([
                'id'        => 'id',
                'title'     => 'title',
                'type_name' => 'type_name'
            ]);
        });
    }
    public function create()
    {
        return Inertia::render('Ledger/Create',[
            'accountType'=>AccountType::where('deleted',0)->where('entity_id',session('entity_id'))->get(),
        ]);
    }
    public function store(Request $request)
    {
        $input=$request->all();
//        dd($input);
//        $validate =  $this->validateAccount();
        Ledger::create(array(
            'title'              =>  $input['title'],
            'account_type_id'    =>  $input['account_type_id']['id'],
            'notes'              =>  $input['notes'],
            'type'               =>  $input['type'] ? $input['type'] : null,
            'opening_balance'    =>  $input['opening_balance'] ? $input['opening_balance'] : 0.00,
            'status'             =>   '1',
            'created'            =>   AppHelpers::instance()->DateTimeZone(now()),
            'created_by'         =>  Auth::user()->id,
            'entity_id'          =>  session('entity_id')
        ));

        return Redirect::route('ledger.index');
    }

    public function edit($id)
    {
//        dd($id);
        $ledger=ledger::where('deleted',0)->where('entity_id',session('entity_id'))->where('id',$id)->get();
        $accountType   = AccountType::where('deleted',0)->where('entity_id',session('entity_id'))->where('id',$ledger[0]['account_type_id'])->get();
        return Inertia::render('Ledger/Edit',[
            'accountType'=>AccountType::where('deleted',0)->where('entity_id',session('entity_id'))->get(),
            'ledger'=>array(
                'id'                => $ledger[0]->id,
                'title'             => $ledger[0]->title,
                'notes'             => $ledger[0]->notes,
                'type'              => $ledger[0]->type,
                'opening_balance'   => $ledger[0]->opening_balance,
                'account_type_id'   => $accountType[0],
            ),
        ]);
    }

    public function update(Request $request)
    {
        $input = $request->all();
//        dd($input);
//        $validate =  $this->validateAccount();
        Ledger::where('id',$input['id'])->update(array(
            'title'              =>  $input['title'],
            'account_type_id'    =>  $input['account_type_id']['id'],
            'notes'              =>  $input['notes'],
            'type'               =>  $input['type'] ? $input['type'] : null,
            'opening_balance'    =>  $input['opening_balance'] ? $input['opening_balance'] : 0.00,
            'status'             =>  '1',
            'modified'           =>   AppHelpers::instance()->DateTimeZone(now()),
            'modified_by'        =>   Auth::user()->id,
            'entity_id'          =>   session('entity_id')
        ));

        return  Redirect::route('ledger.index');
    }



    public function destroy($id)
    {
//        dd($id);
//        $ac_type=AccountType::where('account_id',$id)->where('deleted','=','0')->where('entity_id',session('entity_id'))->get();
////         dd(count($ac_ty_id), count($ac_type));
//        if(count($ac_type) == 0) {
        Ledger::findOrFail($id)->update(array('deleted' => '1'));
        //log
//            return true;
//        }else{
//            return 'failed';
//        }
//        Account::findOrFail($id)->update(array('deleted'=>'1','deleted_at'=>AppHelpers::instance()->DateTimeZone(now()),'deleted_by'=>Auth::user()->id));
        return Redirect::route('ledger.index');
    }

    protected function validateAccount()
    {
        return request()->validate([
            'name'   => ['required',Rule::unique('accounttype')->where(function ($query) {
                return $query->where('entity_id',session('entity_id'));
            })],
        ]);
    }
}
