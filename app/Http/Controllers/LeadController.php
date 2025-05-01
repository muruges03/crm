<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelpers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Models\LeadType;
use App\Models\Lead;
use App\Models\User;
use App\Models\Contact;
use App\Models\LeadContact;
use Carbon\Carbon;
use App\Models\LeadPipelineStage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class LeadController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:edit_leads|create_leads|delete_leads', ['only' => ['index','store']]);
         $this->middleware('permission:create_leads', ['only' => ['create','store']]);
         $this->middleware('permission:edit_leads', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_leads', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if(auth()->user()->getRoleNames()[0]=='user'){
            $roles=auth()->user()->getRoleNames();
            $request->role=$roles[0];
        }
        if($request->date != null){
            $request->from_date = $request->date[0];
            $request->to_date   = $request->date[1];
        }
        // dd($request->from_date,$request->to_date);
        $sort   = request('sort', 'leads.id');
        $order  = request('order', 'desc');
        $lead   = Lead::join('lead_contacts', 'leads.id', '=', 'lead_contacts.lead_id')
                    ->join('contacts','contacts.id','=','lead_contacts.contact_id')
                    ->leftJoin('lead_pipeline_stages', 'leads.lead_pipeline_stage_id', '=', 'lead_pipeline_stages.id')
                    ->join('users','users.id','=','leads.assigned_to')
                    ->select('leads.*','users.first_name','contacts.person_name','contacts.mobile','contacts.city','contacts.state_name')
                    ->where('leads.entity_id',session('entity_id'))->where('leads.deleted',0)
                    ->when($request->role, function($query) {
                        $query->Where('leads.assigned_to',session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'));
                        })
                    ->when($request->term, function($query, $term) {
                        $query->Where('lead_name', 'like', '%'.$term.'%');
                        })
                    ->when($request->ass, function($query, $ass) {
                        $query->Where('first_name', 'like', '%'.$ass.'%');
                        })
                    ->when($request->person, function($query, $person) {
                        $query->Where('person_name', 'like', '%'.$person.'%');
                        })
                    ->when($request->state_name, function($query, $state_name) {
                        $query->Where('state_name', 'like', '%'.$state_name.'%');
                        })
                    ->when($request->city, function($query, $city) {
                        $query->Where('city', 'like', '%'.$city.'%');
                        })
                    ->when($request->lcn, function($query, $lcn) {
                        $query->Where('lead_mobile', 'like', '%'.$lcn.'%');
                        })
                    ->when($request->ccn, function($query, $ccn) {
                        $query->Where('mobile', 'like', '%'.$ccn.'%');
                    })
                    ->when($request->from_date, function($query, $from_date) {
                        $query->whereDate('leads.created', '>=', date($from_date));
                        })
                    ->when($request->to_date, function($query, $to_date) {
                        $query->whereDate('leads.created','<=', date($to_date));
                        })->orderBy($sort, $order)->paginate('20');
        // dd($lead);
        $contact    = Contact::where('entity_id',session('entity_id'))->where('deleted',0);
        $city       = $contact->whereNotNull('city')->distinct('city')->get('city');
        $state      = $contact->whereNotNull('state_name')->distinct('state_name')->get('state_name');
        // dd($city,$state);
        return Inertia::render('Lead/kanban', [
            'lead' => $lead->through(function ($lead) {
                return [
                'id'            => $lead->id,
                'first_name'    => $lead->first_name,
                'description'   => $lead->description,
                'created'       => changeDateFormate($lead->created),
                'lead_name'     => $lead->lead_name,
                'modified'      => changeDateFormate($lead->modified),
                'modified_by'   => $lead->modified_by,
                'lead_pipeline_stage_id'=> $lead->lead_pipeline_stage_id,
                'created_by'    => $lead->created_by,
                'person_name'   => $lead->person_name,
                'city'          => $lead->city,
                ];
            }),
            'leadPipelineStage' => getleadpipstag(''),
            'user'              => User::join('entity_users','users.id','entity_users.user_id')
                                    ->where('entity_id',session('entity_id'))
                                    ->get(['users.id','users.first_name']),
            'city'              => $city,
            'state'             => $state,
        ]);
        return Inertia::render('Lead/kanban', compact('lead', 'leadPipelineStage'));
    }

    public function create(Request $request)
    {
        $leadtype   = LeadType::where('entity_id',session('entity_id'))
                            ->where('deleted','0')
                            ->get(['id','lead_type']);
        $leadpipestage = getleadpipstag('');
        $user       = User::with('entities')->whereHas('entities', function ($query) {
                                $query->where('entity_id',session('entity_id'));
                            })->get(['id','first_name']);
        // dd($leadpipestage);
        return Inertia::render('Lead/Create', compact('leadtype','user','leadpipestage'));
    }

    public function store(Request $request)
    {
        $input      = $request->all();
        request()->validate([
            'lead_name' => ['required',Rule::unique('leads')->where(function ($query) {
                return $query->where('entity_id',session('entity_id'));
                })],
        ]);
        $validate   = $this->validatelead();
        // dd($input);
        $lead = Lead::create(array(
                'entity_id'     => session('entity_id'),
                'lead_name'     => $input['lead_name'],
                'lead_mobile'   => $input['lead_mobile'],
                'lead_email'    => $input['lead_email'],
                'description'   => $input['description'],
                'lead_value'    => $input['lead_value'],
                'source'        => $input['source'],
                'assigned_to'   => $input['assigned_to']['id'],
                'lead_type_id'  => $input['lead_type_id']['id'],
                'lead_pipeline_stage_id' => $input['lead_pipeline_stage_id']['id'],
                'closed_at'     => $input['closed_at'],
                'expected_close_date' => $input['expected_close_date'],
                'created'       => AppHelpers::instance()->DateTimeZone(now()),
                'created_by'    => Auth::user()->id
            ));
        // dd($input['assigned_to']);
        $contact = Contact::create(array(
                'entity_id'     => session('entity_id'),
                'person_name'   => $input['person_name'],
                'line_1'        => $input['line_1'],
                'city'          => $input['city'],
                'state_name'    => $input['state_name'],
                'zipcode'       => $input['zipcode'],
                'landmark'      => $input['landmark'],
                'created'       => AppHelpers::instance()->DateTimeZone(now()),
                'mobile'        => $input['mobile'],
                'email'         => $input['email'],
                'created_by'    => Auth::user()->id
            ));

        $leadid     = Lead::where('entity_id',session('entity_id'))->latest()->first();
        $contactid  = Contact::where('entity_id',session('entity_id'))->latest()->first();
        LeadContact::create(array('lead_id'=>$leadid['id'],'contact_id'=>$contactid['id']));

        return Redirect::route('lead');
    }
    public function show($id)
    {
        $lead = LeadContact::join('contacts','contacts.id','=','lead_contacts.contact_id')
                                ->join('leads','leads.id','=','lead_contacts.lead_id')
                                ->where('lead_contacts.lead_id','=',$id)->get();
        // $entityorg=Entity::where('entity_type','Organization')->where('deleted','0')->get();
        // dd($id,$lead);
        $leadtype = LeadType::where('entity_id',session('entity_id'))
                            ->where('deleted','0')
                            ->get(['lead_types.*']);

        return Inertia::render('Lead/Show', compact('lead', 'leadtype'));
    }
    public function edit($id)
    {
        $lead = LeadContact::join('contacts','contacts.id','=','lead_contacts.contact_id')
                                ->join('leads','leads.id','=','lead_contacts.lead_id')
                                ->where('lead_contacts.lead_id','=',$id)
                                ->get(['leads.*','contacts.*','leads.id as lid','contacts.id as cid']);
        // dd($lead);

        //for select data fetch
        $leadtypeid = LeadType::where('entity_id',session('entity_id'))->where('deleted','0')->where('id',$lead[0]['lead_type_id'])->get(['id','lead_type']);
        $leadtype   = LeadType::where('entity_id',session('entity_id'))->where('deleted','0')->get(['id','lead_type']);
        $userleadid = User::join('leads','leads.assigned_to','users.id')->where('leads.id',$id)->get(['users.id','users.first_name']);
        $userlead   = User::get(['users.id','users.first_name']);
        //end select data fetch

        // dd($lead,$leadtype,$userlead,$userleadid);
        return Inertia::render('Lead/Edit', compact('lead', 'leadtype','leadtypeid','userlead','userleadid'));
    }


    public function update(Request $request,$id)
    {
        $input = $request->all();
        // dd($input);
        if($input['closed_at']=='Invalid date')$input['closed_at']=null;
        if($input['expected_close_date']=='Invalid date')$input['expected_close_date']=null;
        $validate =  $this->validatelead();

        $lead = Lead::findOrFail($input['lid'])->update(array(
                'entity_id'     => session('entity_id'),
                'lead_name'     => $input['lead_name'],
                'lead_mobile'   => $input['lead_mobile'],
                'lead_email'    => $input['lead_email'],
                'description'   => $input['description'],
                'lead_value'    => $input['lead_value'],
                'source'        => $input['source'],
                'assigned_to'   => $input['assigned_to']['id'],
                'closed_at'     => $input['closed_at'],
                'expected_close_date'=> $input['expected_close_date'],
                'lead_type_id'  => $input['lead_type_id']['id'],
                'modified'      => AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'   => Auth::user()->id
                ));
        // dd($lead);
        $contact = Contact::findOrFail($input['cid'])->update(array(
                'entity_id'     => session('entity_id'),
                'person_name'   => $input['person_name'],
                'line_1'        => $input['line_1'],
                'city'          => $input['city'],
                'state_name'    => $input['state_name'],
                'zipcode'       => $input['zipcode'],
                'landmark'      => $input['landmark'],
                'mobile'        => $input['mobile'],
                'email'         => $input['email'],
                'modified'      => AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'   => Auth::user()->id
            ));

        return Redirect::route('lead');
    }
    public function destroy($id)
    {
        // dd($id);
        Lead::findOrFail($id)->update(array('deleted'=>'1'));
        return Redirect::route('lead')->with('success', 'lead Deleted.');
    }
    public function updatestatus(Request $request,$id)
    {
        $input  = $request->all();
        // dd($input,$id);
        $lead = Lead::findOrFail($input['id'])->update(array(
                'entity_id'             => session('entity_id'),
                'lead_pipeline_stage_id'=> $id,
                'modified'              => AppHelpers::instance()->DateTimeZone(now()),
                'modified_by'           => Auth::user()->id
            ));
        return Redirect::route('lead');
    }

    protected function validatelead()
    {
     return request()->validate([
                'lead_name'     => ['required'],
                'lead_mobile'   => ['required'],
                'description'   => ['required'],
                'lead_type_id'  => ['required'],
                'person_name'   => ['required'],
                'city'          => ['required'],
                'state_name'    => ['required'],
                'assigned_to'   => ['required'],
                'lead_pipeline_stage_id' => ['required'],
                // 'zipcode' => ['required'],
                'mobile'        => ['required'],
            ]);
    }


}


