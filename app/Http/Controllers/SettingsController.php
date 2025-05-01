<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\LeadType;
use Carbon\Carbon;
use App\Models\LeadPipelineStage;
use App\Imports\LeadImport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:edit_settings|create_settings|delete_settings', ['only' => ['index','store']]);
         $this->middleware('permission:create_settings', ['only' => ['create','store']]);
         $this->middleware('permission:edit_settings', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_settings', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $leadtype=LeadType::where('deleted',0)->where('entity_id',session('entity_id'))->get();
        $leadstage=LeadPipelineStage::where('deleted',0)->where('entity_id',session('entity_id'))->get();
        return Inertia::render('Settings/Index', compact('leadtype', 'leadstage'));
    }
    public function import()
    {
        return view('import');
    }
    public function importdata(Request $request)
    {
        $file = $request->file('file')->store('import');
        $this->validate($request, [
            'file' => 'required|mimes:xls,xlsx'
        ]);
        $import = new LeadImport;
        $import->import($file);

        if ($import->failures()->isNotEmpty()) {
            return back()->withFailures($import->failures());
        }
        return back()->withStatus('Import in queue, we will send notification after import finished.');
    }
    public function create()
    {
        return Inertia::render('Settings/Create');
    }

    public function leadtypestore(Request $request)
    {

        $input=$request->all();
        $date = Carbon::now();
        // dd($input);
        $validate =  $this->validateleadtype();
            LeadType::create(array('lead_type'=>$input['lead_type'],'created'=>$date->toDateTimeString(),'created_by'=>Auth::user()->id,'status'=>$input['status']
                        ,'entity_id'=>session('entity_id')));

        return redirect()->to('/settings');
    }

    public function leadstagestore(Request $request)
    {
        $input=$request->all();
        $date = Carbon::now();
        $validate =  $this->validateleadstage();

            LeadPipelineStage::create(array('lead_stage'=>$input['lead_stage'],'code'=>$input['code'],'created'=>$date->toDateTimeString(),'created_by'=>Auth::user()->id,'status'=>$input['status']
                                ,'entity_id'=>session('entity_id')));
        return redirect()->to('/settings');
    }
    public function leadtypeupdate(Request $request)
    {
        $input = $request->all();
        $date = Carbon::now();
        // dd($request->has('id'));
        if ($request->has('id')) {
            LeadType::findOrFail($input['id'])->update(array('entity_id'=>session('entity_id')
                    ,'lead_type'=>$input['lead_type'],'modified'=>$date->toDateTimeString(),'modified_by'=>Auth::user()->id));
            return redirect()->back();
        }
    }
    public function leadstageupdate(Request $request)
    {
        $input = $request->all();
        $date = Carbon::now();
        // dd($input);

        $request->validate(
            [
                'lead_stage' => ['required',Rule::unique('lead_pipeline_stages')->ignore($input['id'])->where(function ($query) {
                return $query->where('entity_id',session('entity_id'))->where('deleted', 0);
                })],
            ]
        );
        if ($request->has('id')) {
            LeadPipelineStage::findOrFail($input['id'])->update(array('entity_id'=>session('entity_id'),'lead_stage'=>$input['lead_stage']
                    ,'code'=>$input['code'],'modified'=>$date->toDateTimeString(),'modified_by'=>Auth::user()->id));
            return redirect()->back();
        }
    }
    public function leadstagedestroy($id)
    {
        LeadPipelineStage::findOrFail($id)->update(array('deleted'=>'1'));
        return Redirect::route('settings');
    }
    public function leadtypedestroy($id)
    {
        LeadType::findOrFail($id)->update(array('deleted'=>'1'));
        return Redirect::route('settings');
    }
    protected function validateleadtype()
    {
     return request()->validate([
              'lead_type'=> ['required'],
             ]);
    }
    protected function validateleadstage()
    {
     return request()->validate([
              'lead_stage'=> ['required', 'max:255','unique:lead_pipeline_stages'],
              'code'=> ['required'],
             ]);
    }
}
