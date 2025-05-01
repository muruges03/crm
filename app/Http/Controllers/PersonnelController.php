<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\Personnel;
use App\Models\Contact;
use App\Models\PersonnelContact;
use App\Models\UserPersonnel;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\LeadPipelineStage;

class PersonnelController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:edit_personnels|create_personnels|delete_personnels', ['only' => ['index','store']]);
         $this->middleware('permission:create_personnels', ['only' => ['create','store']]);
         $this->middleware('permission:edit_personnels', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_personnels', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $length = request('length', 10);
        $sort = request('sort', 'personnels.id');
        $order= request('order', 'desc');
        // dd($request->all());
        $personnel=Personnel::join('personnel_contacts', 'personnels.id', '=', 'personnel_contacts.personnel_id')
                    ->join('contacts','contacts.id','=','personnel_contacts.contact_id')
                    ->where('personnels.entity_id',session('entity_id'))
                    ->where('personnels.deleted',0)
                    ->select('personnels.id as pid','personnels.*','contacts.id as cid','contacts.*')
                    ->when($request->term, function($query, $term) {
                        $query->Where('personnels.first_name', 'like', '%'.$term.'%');
                        })
                    ->orderBy($sort, $order)->paginate($length);
        // dd($personnel);
        $total=$personnel->total();
        $firstItem=$personnel->firstItem();
        $lastItem=$personnel->lastItem();

        return Inertia::render('Personnel/Index',compact('personnel','total','firstItem','lastItem'));
    }

    public function Create()
    {
        // $personnel= Personnel::where('entity_id',session('entity_id'))->where('deleted', 0)->latest()->first();

        // if($personnel!=null ){
        //     $empcode = json_decode($personnel['params']);
        //     $empid   = $empcode->employee_code;
        // }else{
        //     $empid   = 0;
        // }

        // if($personnel==null ) {
        //     $employeeCode = 1;
        // }elseif($empid==0){
        //     $employeeCode = 1;
        // }else{
        //     $employeeCode=$empid+1;
        // }

        return Inertia::render('Personnel/Create');
    }
    public function store(Request $request)
    {
        $date = Carbon::now();
        $input = $request->all();
        // dd($input);
        $aadhar_path   = $this->aadhardocumentupload($input['aadharProof']['aadharcard'],$input['form']);

        $document_path   = $this->documentupload($input['proofdocument']['proof_document'],$input['form']);
        $input['params']=json_encode(array('department'=>$input['form']['department'],"role"=>$input['form']['role'], "employee_code"=> $input['form']['employee_code'],"aadharcard"=>$aadhar_path, "proof_document"=>$document_path));
        // dd($input['params']);

//  dd($aadhar_path, $document_path);
        Personnel::create(array('entity_id'=>session('entity_id'),
                'first_name'    =>  $input['form']['first_name'],
                'last_name'     =>  $input['form']['last_name'],
                'date_of_birth' =>  $input['form']['date_of_birth'],
                'notes'         =>  $input['form']['notes'],
                'params'        =>  $input['params'],
                'gender'        =>  $input['form']['gender'],
                'joining_date'  =>  $input['form']['joining_date'],
                'created'       =>  $date->toDateTimeString(),
                'created_by'   =>  Auth::user()->id));

        Contact::create(array('entity_id'=>session('entity_id'),
                            'person_name'           => $input['form']['first_name'],
                            'line_1'                => $input['form']['line_1'],
                            'city'                  => $input['form']['city'],
                            'state_name'            => $input['form']['state_name'],
                            'zipcode'               => $input['form']['zipcode'],
                            'landmark'              => $input['form']['landmark'],
                            'mobile'                => $input['form']['mobile'],
                            'email'                 => $input['form']['email'],
                            'alt_mobile'            => $input['form']['alt_mobile'],
                            'relation_type'         => $input['form']['relation_type'],
                            'secondary_contact_name'=> $input['form']['secondary_contact_name'],
                            'secondary_address'     => $input['form']['secondary_address'],
                            'secondary_email'       => $input['form']['secondary_email'],
                            'secondary_phone'       => $input['form']['secondary_phone'],
                            'created'               => $date->toDateTimeString(),
                            'created_by'            => Auth::user()->id));

        $personnelid = Personnel::where('entity_id',session('entity_id'))->latest()->first();
            // dd($personnelid);
        $contactid = Contact::where('entity_id',session('entity_id'))->latest()->first();

        PersonnelContact::create(array('personnel_id'=>$personnelid['id'],'contact_id'=>$contactid['id']));

        return Redirect::route('personnel');
    }

    public function edit($id)
    {
        // $personnel = PersonnelContact::with('personnel', 'contact')
        //     ->where('personnel_contacts.personnel_id','=',$id)->where('personnel.entity_id',session('entity_id'))
        //     ->where('personnel.deleted',0)
        //     ->get();
        //     dd($personnel);
        $personnel=PersonnelContact::join('personnels','personnels.id','=','personnel_contacts.personnel_id')
                ->join('contacts','contacts.id','=','personnel_contacts.contact_id')
               ->where('personnels.entity_id',session('entity_id'))->where('personnels.deleted', 0)
                    ->where('personnels.id','=',$id)->get();
        // dd($personnel);
        $data=$personnel[0]->personnel['params'];
        $depertment = json_decode($data);
        // dd($dep->department);
        return Inertia::render('Personnel/Edit',compact('personnel', 'depertment'));
    }

    public function update(Request $request)
    {
        $date = Carbon::now();
        $input = $request->all();
            // dd($input);
        $aadhar_path   = $this->aadhardocumentupload($input['aadharProof']['aadharcard'], $input['form']['pid']);
        // dd($aadhar_path);
        $document_path   = $this->documentupload($input['proofdocument']['proof_document'], $input['form']['pid']);

        $input['params']=json_encode(array(
            'department'    => $input['form']['department'],
            "role"          => $input['form']['role'],
            "employee_code" => $input['form']['employee_code'],
            "aadharcard"    => $aadhar_path ? $aadhar_path : $input['form']['aadharcard'],
            "proof_document"=> $document_path ? $document_path : $input['form']['proof_document'],
        ));
            // dd($data);

        Personnel::findOrFail($input['form']['pid'])->update(array('entity_id'=>session('entity_id'),
                'first_name'    =>  $input['form']['first_name'],
                'last_name'     =>  $input['form']['last_name'],
                'date_of_birth' =>  $input['form']['date_of_birth'],
                'notes'         =>  $input['form']['notes'],
                'params'        =>  $input['params'],
                'gender'        =>  $input['form']['gender'],
                'joining_date'  =>  $input['form']['joining_date'],
                // 'employee_code' =>  $input['form']['employee_code'],
                // 'aadharcard'    =>  $aadhar_path,
                // 'proof_document'=>  $document_path,
                'modified'      =>  $date->toDateTimeString(),
                'modified_by'   =>  Auth::user()->id
            ));

        Contact::findOrFail($input['form']['cid'])->update(array('entity_id'=>session('entity_id'),
                'person_name'   =>  $input['form']['first_name'],
                'line_1'        =>  $input['form']['line_1'],
                'city'          =>  $input['form']['city'],
                'state_name'    =>  $input['form']['state_name'],
                'zipcode'       =>  $input['form']['zipcode'],
                'landmark'      =>  $input['form']['landmark'],
                'mobile'        =>  $input['form']['mobile'],
                'email'         =>  $input['form']['email'],
                'alt_mobile'    =>  $input['form']['alt_mobile'],
                'relation_type'         => $input['form']['relation_type'],
                'secondary_contact_name'=> $input['form']['secondary_contact_name'],
                'secondary_address'     => $input['form']['secondary_address'],
                'secondary_email'       => $input['form']['secondary_email'],
                'secondary_phone'       => $input['form']['secondary_phone'],
                'modified'      =>  $date->toDateTimeString(),
                'modified_by'   =>  Auth::user()->id
            ));

        return Redirect::route('personnel');
    }
    protected function delete($pid,$cid)
    {
        // dd($pid,$cid);
        Personnel::findOrFail($pid)->update(array('deleted'=>'1'));
        Contact::findOrFail($cid)->update(array('deleted'=>'1'));
        // Personnel::where('id', $pid)->delete();
        return Redirect::route('personnel');
    }

    protected function aadhardocumentupload($image,$personnelid){
        $legal_name = session('entity_name');
        // dd($image);
        $aadhar_path = '';
        if ($image!=null) {
            $aadhar_path = $image->store("image/$legal_name/proof", 'public');
        }
        // dd($invoice_path);
        return $aadhar_path;

    }
    protected function documentupload($image,$personnelid){
        $legal_name = session('entity_name');
        // dd($image['invoice_path']);
        $document_path = '';
        if ($image!=null) {
            $document_path = $image->store("image/$legal_name/proof", 'public');
        }
        // dd($invoice_path);
        return $document_path;

    }
}
