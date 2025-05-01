<?php

namespace App\Http\Controllers;


use App\Helpers\AppHelpers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use App\Models\Entity;
use App\Models\EntityUser;
use App\Models\Contact;
use App\Models\EntityContact;
use Carbon\Carbon;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class EntitiesController extends Controller
{
    public $timestamps = false;

    function __construct()
    {
         $this->middleware('permission:edit_entity|create_entity|delete_entity', ['only' => ['index','store']]);
         $this->middleware('permission:create_entity', ['only' => ['create','store']]);
         $this->middleware('permission:edit_entity', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_entity', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $length = request('length', 10);
        $sort   = request('sort', 'id');
        $order  = request('order', 'desc');
        $entitys = Entity::when($request->term, function($query, $term) {
                        $query->Where('legal_name', 'like', '%'.$term.'%');
        })->orderBy( $sort, $order)->where('deleted', 0)->paginate($length);
        $total      = $entitys->total();
        $firstItem  = $entitys->firstItem();
        $lastItem   = $entitys->lastItem();
        // dd($entitys);
        return Inertia::render('Entities/Index', compact('entitys', 'total', 'firstItem', 'lastItem'));
    }


    public function create()
    {
        $entityorg = Entity::where('entity_type','Organization')->where('deleted','0')->get();
        return Inertia::render('Entities/Create',compact('entityorg'));
    }

    public function store(Request $request)
    {
        $input      = $request->all();
        $validate   = $this->validateEntity();
        if($input['entity_type']=='Organization')$input['parent_id']='Null';
            else $input['parent_id']=$input['parent_id'];
        //dd($input);
        // $parent_id = implode(',', $input['parent_id']);

        $image_path = '';
        $legal_name=$input['legal_name'];
        if ($request->hasFile('logo_file')) {
            $image_path = $request->file('logo_file')->store("image/$legal_name", 'public');
        }
        // dd($image_path);
        Entity::create(array(
                'parent_id'     => $input['parent_id'],
                'legal_name'    => $input['legal_name'],
                'alias'         => $input['alias'],
                'description'   => $input['description'],
                'url'           => $input['url'],
                'logo_file'     => $image_path,
                'api_key'       => $input['api_key'],
                'created'       => AppHelpers::instance()->DateTimeZone(now()),
                'created_by'    => Auth::user()->id,
                'status'        => $input['status'],
                'entity_type'   => $input['entity_type'],
                'time_zone'     => 'Asia/Kolkata',
                'gstin'         => $input['gstin']
        ));

        $entiteid = Entity::latest()->first();

        Contact::create(array(
                'entity_id'     => $entiteid['id'],
                'line_1'        => $input['line_1'],
                'line_2'        => $input['line_2'],
                'city'          => $input['city'],
                'state_name'    => $input['state_name'],
                'zipcode'       => $input['zipcode'],
                'landmark'      => $input['landmark'],
                'contact_type'  => $input['contact_type'],
                'tag'           => $input['tag'],
                'email'         => $input['email'],
                'mobile'        => $input['mobile'],
                'alt_mobile'    => $input['alt_mobile'],
                'land_line'     => $input['land_line'],
                'emergency_address'=> $input['emergency_address'],
                'emergency_contact_name'=> $input['emergency_contact_name'],
                'created'       => AppHelpers::instance()->DateTimeZone(now()),
                'created_by'    => Auth::user()->id,
                'emergency_email'=> $input['emergency_email'],
                'emergency_phone'=> $input['emergency_phone']
        ));

        $contactid = Contact::where('entity_id',session('entity_id'))->latest()->first();

        EntityContact::create(array('entity_id'=>$entiteid['id'],'contact_id'=>$contactid['id']));

        return Redirect::route('entities');
    }

    public function addresscreate(Request $request,$id)
    {
        $input    = $request->all();
        $validate = $this->validateaddress();
        //dd($input,$id);
        Contact::create(array(
                'entity_id' => $id,
                'line_1'    => $input['line_1'],
                'line_2'    => $input['line_2'],
                'city'      => $input['city'],
                'state_name'=> $input['state_name'],
                'zipcode'   => $input['zipcode'],
                'landmark'  => $input['landmark'],
                'contact_type'=> $input['contact_type'],
                'tag'       => $input['tag'],
                'email'     => $input['email'],
                'mobile'    => $input['mobile'],
                'alt_mobile'=> $input['alt_mobile'],
                'land_line' => $input['land_line'],
                'created'   => AppHelpers::instance()->DateTimeZone(now()),
                'created_by'=> Auth::user()->id
        ));

        $contactid = Contact::where('entity_id',session('entity_id'))->latest()->first();
        EntityContact::create(array('entity_id'=>$id,'contact_id'=>$contactid['id']));

        return Redirect::route('entities');
    }

    public function show($id){
    }

    public function edit($id)
    {
        //dd();
        $entities = EntityContact::join('contacts','contacts.id','=','entity_contacts.contact_id')
                                ->join('entities','entities.id','=','entity_contacts.entity_id')
                                ->where('entity_contacts.entity_id','=',$id)->get();
        $entityorg= Entity::where('entity_type','Organization')->where('deleted','0')->get();
        // dd($entityorg,$entities);
        return Inertia::render('Entities/Edit', compact('entities','entityorg'));
    }

    public function update(Request $request, $id)
    {
        $input  = $request->all();
        $request->validate(
            [
                'legal_name' => ['required',Rule::unique('entities')->ignore($input['id'])->where(function ($query) {
                    return $query->where('deleted', 0);
                    })],
            ]
        );
        $validate =  $this->validateEntitys();
        // dd($input);
        Entity::findOrFail($input['id'])->update(array(
                'parent_id'     => $input['parent_id'],
                'legal_name'    => $input['legal_name'],
                'alias'         => $input['alias'],
                'description'   => $input['description'],
                'url'           => $input['url'],
                'modified'      => AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'   => Auth::user()->id,
                'status'        => $input['status'],
                'entity_type'   => $input['entity_type'],
                'time_zone'     => 'Asia/Kolkata',
                'api_key'       => $input['api_key'],
                'gstin'         => $input['gstin']
        ));

        Contact::findOrFail($id)->update(array(
                'entity_id'     => $input['id'],
                'line_1'        => $input['line_1'],
                'line_2'        => $input['line_2'],
                'city'          => $input['city'],
                'state_name'    => $input['state_name'],
                'zipcode'       => $input['zipcode'],
                'landmark'      => $input['landmark'],
                'contact_type'  => $input['contact_type'],
                'tag'           => $input['tag'],
                'email'         => $input['email'],
                'mobile'        => $input['mobile'],
                'alt_mobile'    => $input['alt_mobile'],
                'land_line'     => $input['land_line'],
                'modified'      => AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'   => Auth::user()->id
        ));

        return Redirect::route('entities');
    }
    public function updateimage(Request $request, $id)
    {
        $legal_name = session('entity_name');
        $image_path = '';
        if ($request->hasFile('logo_file')) {
            $image_path = $request->file('logo_file')->store("image/$legal_name", 'public');
        }
        // dd($image_path,$id);
        Entity::findOrFail($id)->update(array('logo_file'=>$image_path));
        return Redirect::route('entities');
    }

    public function addressupdate(Request $request,$id)
    {
        $input = $request->all();
        // dd($id, $input);
        Contact::findOrFail($id)->update(array(
                'entity_id'     => $input['entity_id'],
                'line_1'        => $input['line_1'],
                'line_2'        => $input['line_2'],
                'city'          => $input['city'],
                'state_name'    => $input['state_name'],
                'zipcode'       => $input['zipcode'],
                'landmark'      => $input['landmark'],
                'contact_type'  => $input['contact_type'],
                'tag'           => $input['tag'],
                'email'         => $input['email'],
                'mobile'        => $input['mobile'],
                'alt_mobile'    => $input['alt_mobile'],
                'land_line'     => $input['land_line'],
                'emergency_address'=> $input['emergency_address'],
                'emergency_contact_name'=> $input['emergency_contact_name'],
                'modified'      => AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'   => Auth::user()->id,
                'emergency_email'=> $input['emergency_email'],
                'emergency_phone'=> $input['emergency_phone']
        ));

        return Redirect::route('entities');
    }

    public function destroy($id)
    {
        // dd($id);
        Entity::findOrFail($id)->update(array('deleted'=>'1'));

        return Redirect::route('entities')->with('success', 'Entity Deleted.');
    }
    public function entitydata()
    {
        $data=Entity::where('id',session('entity_id'))->get();
        return $data;
    }


    protected function validateEntity()
    {
     return request()->validate([
                'legal_name'    => ['required', 'max:255','unique:entities'],
                'alias'         => ['required', 'max:100'],
                'status'        => ['required'],
                'logo_file'     => ['required'],
                'api_key'       => ['required'],
                'description'   => ['required'],
                'entity_type'   => ['required'],
                'line_1'        => ['required', 'max:200'],
                'city'          => ['required', 'max:150'],
                'state_name'    => ['required', 'max:150'],
                'zipcode'       => ['required', 'min:6', 'max:6'],
                'mobile'        => ['required', 'min:10', 'max:10'],
             ]);
    }
    protected function validateEntitys()
    {
     return request()->validate([
                'alias'         => ['required', 'max:100'],
                'status'        => ['required'],
                'api_key'       => ['required'],
                'description'   => ['required'],
                'entity_type'   => ['required'],
                'line_1'        => ['required', 'max:200'],
                'city'          => ['required', 'max:150'],
                'state_name'    => ['required', 'max:150'],
                'zipcode'       => ['required', 'min:6', 'max:6'],
                'mobile'        => ['required', 'min:10', 'max:10'],
             ]);
    }

    protected function validateaddress()
    {
     return request()->validate([
                'line_1'        => ['required', 'max:200'],
                'city'          => ['required', 'max:150'],
                'state_name'    => ['required', 'max:150'],
                'zipcode'       => ['required', 'max:150'],
                'mobile'        => ['required'],
             ]);
    }



//     public function upload(Request $request){

//         $request->validate([
//            'file' => 'required|mimes:jpg,jpeg,png,csv,txt,xlx,xls,pdf|max:2048'
//         ]);

//         $fileUpload = new Entity;

//         if($request->file()) {
//             $file_name = time().'_'.$request->file->getClientOriginalName();
//             $file_path = $request->file('file')->storeAs('uploads', $file_name, 'public');

//             $fileUpload->name = time().'_'.$request->file->getClientOriginalName();
//             $fileUpload->path = '/storage/' . $file_path;
//             $fileUpload->save();

//             return response()->json(['success'=>'File uploaded successfully.']);
//         }
//    }

}
