<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelpers;
use App\Models\Ledger;
use App\Models\DefaultSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class DefaultSettingController extends Controller
{
    public function index()
    {
        $length = request('length', 10);

        $defaultsetting = QueryBuilder::for(DefaultSetting::class)
            ->join('ledger','default_settings.ledger_id','=','ledger.id')
            ->where('default_settings.deleted','=',0)->where('default_settings.entity_id',session('entity_id'))
            ->select('default_settings.id','default_settings.type','default_settings.name','ledger.title as l_title')
            ->defaultSort('default_settings.id')
            ->allowedSorts(['default_settings.id'])
            ->when(request('term'), function ($query, $term) {
                $query->where(function ($query) use ($term) {
                    $query->where('default_settings.name', 'like', '%' .$term . '%')
                    ->orWhere('default_settings.type', 'like', '%' .$term . '%');
                });
            })
            ->paginate($length)
            ->withQueryString();
        return Inertia::render('DefaultSetting/Index', [
            'defaultsetting' => $defaultsetting,

        ])->table(function (InertiaTable $table) {
            $table->addColumns([
                'id'=>'id',
                'name'      => 'name',
                'type'  => 'type',
                'l_title'=>'l_title'
            ]);
        });
    }
    public function create()
    {
        return Inertia::render('DefaultSetting/Create',[
            'ledger'=>Ledger::where('deleted',0)->where('entity_id',session('entity_id'))->get(),
        ]);
    }
    public function store(Request $request)
    {
        $input=$request->all();
//        dd($input);
        $validate =  $this->validateAccount();
        DefaultSetting::create(array(
            'type'               =>  $input['type'],
            'name'               =>  $input['name'],
            'ledger_id'          =>  $input['ledger_id']['id'],
            'created'            =>  AppHelpers::instance()->DateTimeZone(now()),
            'created_by'         =>  Auth::user()->id,
            'entity_id'          =>  session('entity_id')
        ));

        return Redirect::route('defaultSetting.index');
    }

    public function edit($id)
    {
//        dd($id);
        $defaultSetting=DefaultSetting::where('deleted',0)->where('entity_id',session('entity_id'))->where('id',$id)->get();
        $ledger   = Ledger::where('deleted',0)->where('entity_id',session('entity_id'))->where('id',$defaultSetting[0]['ledger_id'])->get();
        return Inertia::render('DefaultSetting/Edit',[
            'ledger'=>Ledger::where('deleted',0)->where('entity_id',session('entity_id'))->get(),
            'defaultSetting'=>array(
                'id'                => $defaultSetting[0]->id,
                'name'              => $defaultSetting[0]->name,
                'type'              => $defaultSetting[0]->type,
                'ledger_id'        => $ledger[0],
            ),
        ]);
    }

    public function update(Request $request)
    {
        $input = $request->all();
//        dd($input);
//        $validate =  $this->validateAccount();
        DefaultSetting::where('id',$input['id'])->update(array(
            'type'               =>   $input['type'],
            'name'               =>   $input['name'],
            'ledger_id'          =>   $input['ledger_id']['id'],
            'modified'           =>   AppHelpers::instance()->DateTimeZone(now()),
            'modified_by'        =>   Auth::user()->id,
            'entity_id'          =>   session('entity_id')
        ));

        return  Redirect::route('defaultSetting.index');
    }



    public function destroy($id)
    {
//        dd($id);
//        $ac_type=AccountType::where('account_id',$id)->where('deleted','=','0')->where('entity_id',session('entity_id'))->get();
////         dd(count($ac_ty_id), count($ac_type));
//        if(count($ac_type) == 0) {
        DefaultSetting::findOrFail($id)->update(array('deleted' => '1'));
        //log
//            return true;
//        }else{
//            return 'failed';
//        }
//        Account::findOrFail($id)->update(array('deleted'=>'1','deleted_at'=>AppHelpers::instance()->DateTimeZone(now()),'deleted_by'=>Auth::user()->id));
        return Redirect::route('defaultSetting.index');
    }

    protected function validateAccount()
    {
        return request()->validate([
            'name'   => ['required',Rule::unique('default_settings')->where(function ($query) {
                return $query->where('entity_id',session('entity_id'));
            })],
        ]);
    }
}
