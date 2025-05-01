<?php

namespace App\Http\Controllers;

use App\Helpers\AppHelpers;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use ProtoneMedia\LaravelQueryBuilderInertiaJs\InertiaTable;
use Spatie\QueryBuilder\QueryBuilder;

class AttendanceController extends Controller
{
    public function index()
    {
        $length = request('length', 50);
        $date = Carbon::now()->format('Y-m-d');
        $existingAttendance = Attendance::where('employee_id', Auth::user()->id)
            ->where('date', $date)->where('deleted',0)->where('entity_id',session('entity_id'))
            ->latest()->first();
        if($existingAttendance==null){
            $status=0;
        }else{
            $status=$existingAttendance['status'];
        }
//        dd($status);
        $attendance = QueryBuilder::for(Attendance::class)
            ->leftJoin('personnels','attendance.employee_id','=','personnels.id')
            ->where('attendance.deleted','=',0)->where('attendance.entity_id',session('entity_id'))
            ->defaultSort('attendance.id')
            ->allowedSorts(['check_in','check_out','Emp_name'])

            ->select('personnels.first_name','personnels.last_name','attendance.check_in','attendance.id','attendance.check_out','attendance.employee_id','attendance.date')
            ->paginate(50)->withQueryString();

        return Inertia::render('Attendance/Index', [
            'attendance' => $attendance,
            'status'    =>$status,
        ])->table(function (InertiaTable $table) {
            $table->addColumns([
                'id'    => 'id',
                'Emp_name'  => 'Employee Name',
                'check_in'  => 'Check In',
                'check_out' => 'Check Out'
            ]);
        });
    }
    public function create()
    {
//
        return Inertia::render('Attendance/Create',[
//            dd('fdsf'),
            'employee'  => AppHelpers::instance()->personnel('')
        ]);
    }
    public function store(Request $request)
    {
        $input=$request->all();

        $request->validate([
            'date' => 'required|date', // Validate the date input
        ]);

        // Get the current date or the date from the request
        $date = $request->input('date', Carbon::now()->format('Y-m-d'));

        // Check if the user has already checked in today

        $existingAttendance = Attendance::where('employee_id', $input['employee_id'])
            ->where('date', $date)->where('deleted',0)->where('entity_id',session('entity_id'))
            ->first();

        if ($existingAttendance) {
            return response()->json(['message' => 'You have already checked in today.'], 400);
        }

        Attendance::create(array(
            'employee_id'        =>  $input['employee_id']['id'],
            'date'               =>  $input['date'],
            'check_in'           =>  $input['check_in'] ? AppHelpers::instance()->DateTimeZone($input['check_in']) : AppHelpers::instance()->DateTimeZone(now()),
            'check_out'          =>  $input['check_out'] ? AppHelpers::instance()->DateTimeZone($input['check_out']) : AppHelpers::instance()->DateTimeZone(now()),
            'status'             =>  '1',
            'created_at'         =>  AppHelpers::instance()->DateTimeZone(now()),
            'created_by'         =>  Auth::user()->id,
            'entity_id'          =>  session('entity_id')
        ));
        return response()->json(['message' => 'Checked in successfully.'], 200);

    }

    public function edit($id)
    {
//        dd($id);
        $attendance=Attendance::where('deleted',0)->where('entity_id',session('entity_id'))->where('id',$id)->get();
        return Inertia::render('Attendance/Edit',[
            'employee'  => AppHelpers::instance()->personnel(''),
            'attendance'=>array(
                'id'                => $attendance[0]->id,
                'employee_id'       => AppHelpers::instance()->personnel($attendance[0]->employee_id),
                'check_in'          => $attendance[0]->check_in,
                'check_out'         => $attendance[0]->check_out,
                'date'              => AppHelpers::instance()->getFormattedDateMonthYear($attendance[0]->date)
            ),
        ]);
    }

    public function update(Request $request)
    {
        $input = $request->all();
        dd($input);
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
        Attendance::where('id',$id)->update(array('deleted_at'=>AppHelpers::instance()->DateTimeZone(now()),'deleted' => '1'));

        return response()->json(['message' => 'Deleted in successfully.'], 200);
    }

    public function employeeLoginToCheckIn(Request $request)
    {
        $input=$request->all();

        // Get the current date or the date from the request
        $date = Carbon::now()->format('Y-m-d');

        // Check if the user has already checked in today

        $existingAttendance = Attendance::where('employee_id', Auth::user()->id)
            ->where('date', $date)->where('deleted',0)->where('entity_id',session('entity_id'))
            ->first();

        if ($existingAttendance) {
            return response()->json(['message' => 'You have already checked in today.'], 400);
        }

        Attendance::create(array(
            'employee_id'        =>  Auth::user()->id,
            'date'               =>  Carbon::now()->format('Y-m-d'),
            'check_in'           =>  AppHelpers::instance()->DateTimeZone(now()),
//            'check_out'          =>  $input['check_out'] ? AppHelpers::instance()->DateTimeZone($input['check_out']) : AppHelpers::instance()->DateTimeZone(now()),
            'status'             =>  '1',
            'created_at'         =>  AppHelpers::instance()->DateTimeZone(now()),
            'created_by'         =>  Auth::user()->id,
            'entity_id'          =>  session('entity_id')
        ));
        return response()->json(['message' => 'Checked in successfully.'], 200);

    }

    public function employeeLoginToCheckOut(Request $request)
    {
        $input=$request->all();

        // Get the current date or the date from the request
        $date = Carbon::now()->format('Y-m-d');

        // Check if the user has already checked in today

        $existingAttendance = Attendance::where('employee_id', Auth::user()->id)->whereNotNull('check_out')
            ->where('date', $date)->where('deleted',0)->where('entity_id',session('entity_id'))
            ->latest()->first();
//dd($existingAttendance);
        if ($existingAttendance) {
            return response()->json(['message' => 'You have already checked Out today.'], 400);
        }

        Attendance::where('employee_id','=',Auth::user()->id)->where('date', $date)->where('check_out', null)->update(array(
            'check_out'           =>  AppHelpers::instance()->DateTimeZone(now()),
//            'check_out'          =>  $input['check_out'] ? AppHelpers::instance()->DateTimeZone($input['check_out']) : AppHelpers::instance()->DateTimeZone(now()),
            'status'             =>  '0',
            'entity_id'          =>  session('entity_id')
        ));
        return response()->json(['message' => 'Checked Out successfully.'], 200);

    }

    protected function validateAttendance()
    {

        return request()->validate([
            'employee_id'   => ['required',Rule::unique('attendance')->where(function ($query) {
                return $query->where('entity_id',session('entity_id'));})],
            'check_in' => ['required'],
            'check_out' => ['required']
        ]);
    }
}
