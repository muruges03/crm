<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelpers;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class LeaveController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:create_leave|delete_leave|', ['only' => ['index','store']]);
        $this->middleware('permission:create_leave', ['only' => ['create','store']]);
        $this->middleware('permission:create_leave', ['only' => ['edit','update']]);
        $this->middleware('permission:delete_accounts', ['only' => ['destroy']]);
    }
    public function index()
    {
        $length = request('length', 50);

        $leave = QueryBuilder::for(Leave::class)
            ->leftJoin('personnels','leaves.employee_id','=','personnels.id')
            ->leftJoin('leave_types','leaves.leave_type_id','=','leave_types.id')
            ->where('leaves.deleted','=',0)->where('leaves.entity_id',session('entity_id'))
            ->defaultSort('leaves.id')
            ->allowedSorts(['Emp_name'])

            ->select('personnels.first_name','personnels.last_name','leaves.start_date','leaves.id','leaves.end_date','leaves.employee_id','leave_types.name','leaves.leave_status')
            ->paginate($length)->withQueryString();
//dd($leave);
        return Inertia::render('Leave/Index', [
            'employee'  => AppHelpers::instance()->personnel(''),
            'leaveType'  => AppHelpers::instance()->leaveType(''),
            'leave' => $leave->through(function ($leave) {
                return [
                    'id'             => $leave->id,
                    'first_name'     => $leave->first_name,
                    'last_name'      => $leave->last_name,
                    'start_date'     => $leave->start_date ? AppHelpers::instance()->getFormattedDateMonthYear($leave->start_date) : null ,
                    'end_date'       => $leave->end_date ? AppHelpers::instance()->getFormattedDateMonthYear($leave->end_date) : null ,
                    'leave_type'     => $leave->name,
                    'leave_status'   => $leave->leave_status,
                ];

            }),

        ])->table(function (InertiaTable $table) {
            $table->addColumns([
                'id'            => 'id',
                'Emp_name'      => 'Employee Name',
                'Leave_Date'    => 'Start Date',
                'End_date'      => 'End Date'
            ]);
        });
    }

    public function store(Request $request)
    {
        $input=$request->all();
//dd($input);
        $this->validateLeave();

        $existingLeave=Leave::where('deleted',0)->where('entity_id',session('entity_id'))->where('employee_id',$input['employee_id']['id'])
            ->whereIn('leave_status',['Pending','Approved','Rejected'])->where('start_date',$input['start_date'])->get();
//        dd($existingLeave);
        if (count($existingLeave)>0) {
            return response()->json(['message' => 'You have already apply leave today.'], 400);
        }

        Leave::create(array(
            'employee_id'        =>  $input['employee_id']['id'],
            'leave_type_id'      =>  $input['leave_type_id']['id'],
            'reason'             =>  $input['reason'],
            'end_date'           =>  $input['end_date'] ? AppHelpers::instance()->DateTimeZone($input['end_date']) : AppHelpers::instance()->DateTimeZone(now()),
            'start_date'         =>  $input['start_date'] ? AppHelpers::instance()->DateTimeZone($input['start_date']) : AppHelpers::instance()->DateTimeZone(now()),
            'leave_status'       =>  'Pending',
            'status'             =>  '1',
            'created_at'         =>  AppHelpers::instance()->DateTimeZone(now()),
            'created_by'         =>  Auth::user()->id,
            'entity_id'          =>  session('entity_id')
        ));
        return response()->json(['message' => 'Leave Apply successfully.'], 200);

    }


    public function updateStatus(Request $request)
    {
        $input = $request->all();
//        dd($input);
        $leave=Leave::where('id',$input['id'])->where('leave_status','=','Pending')->update(array('leave_status'=>$input['type'],'updated_at'=>AppHelpers::instance()->DateTimeZone(now())));
//        dd($leave);

        if($leave)
            return true;
        else
            return 'failed';
    }


    protected function validateLeave()
    {

        return request()->validate([
            'employee_id'   => ['required'],
            'start_date' => ['required'],
            'end_date' => ['required'],
            'leave_type_id' =>['required']
        ]);
    }
}
