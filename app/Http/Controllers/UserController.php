<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Entity;
use App\Models\Trip;
use App\Models\EntityUser;
use App\Models\UserPersonnel;
use App\Models\Personnel;
use Carbon\carbon;
use App\Models\RoleHasPermission;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use DB;
use App\helpers;

class UserController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:edit_users|create_users|delete_users', ['only' => ['index','store']]);
         $this->middleware('permission:create_users', ['only' => ['create','store']]);
         $this->middleware('permission:edit_users', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_users', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // dd($request);
        $length = request('length', 10);
        $sort = request('sort', 'users.id');
        $order= request('order', 'desc');
        $query = User::join('entity_users','entity_users.user_id', '=','users.id')
                    ->join('entities','entities.id','entity_users.entity_id')
                    ->when($request->term, function($query, $term) {
                    $query->Where('email', 'like',"%{$term}%");
                    })->Where('entities.id',session('entity_id'))
                    ->select('entities.legal_name','users.*','entity_users.*')
                    ->orderBy($sort, $order)->paginate($length);

        // dd($query);
        $total=$query->total();
        $firstItem=$query->firstItem();
        $lastItem=$query->lastItem();
        return Inertia::render('User/Index', ['user' => $query, 'total'=>$total, 'firstItem'=> $firstItem, 'lastItem'=> $lastItem]);
    }
    public function create()
    {
      $entity = Entity::where('entity_type', 'Organization')
                        ->where('deleted','0')
                        ->where('id',session('entity_id'))
                        ->get();
        $entity_access=Entity::where('entity_type', 'Company')
                            ->where('deleted','0')
                            ->where('parent_id',session('entity_id'))
                            ->get()->map->only('id','legal_name');

        $personnel=Personnel::where('entity_id',session('entity_id'))
                        ->where('deleted','0')
                        ->get()->map->only('id','first_name');

        $role= Role::get();
        //dd($role,$entity,$entity_access);
        return Inertia::render('User/Create',compact('entity','role', 'entity_access','personnel'));
    }

    public function store(Request $request)
    {
        $input=$request->all();
        $validate =  $this->validateUser();
        // dd($input);
        if(!empty($input['entity_access'])){
            foreach($input['entity_access'] as $x) {
                $arr[] = $x['id'];
            }
            $arr[] .=session('entity_id');
            $entity_acce=json_encode(array('id'=>$arr));
            // dd($entity_acce);
        }else{
            $entity_acce='{"id":['.$input['entity'].']}';
        }
        $date = Carbon::now();
        $legal_name=session('entity_name');
        // dd($legal_name);
        if ($request->hasFile('photo_path')) {
            $image_path = $request->file('photo_path')->store("image/$legal_name", 'public');
            // dd($image_path);
        }
        $user =  User::create(array('first_name'=>$input['first_name'],'last_name'=>$input['last_name'],'email'=>$input['email'],'owner'=>$input['owner'],'password'=>Hash::make($input['password'])
                ,'created_at'=>$date->toDateTimeString(),'photo_path'=>$image_path));
        $user->assignRole($input['role']);
        $userid = User::latest()->first();
        // dd($userid);
        EntityUser::create(array('entity_id'=>session('entity_id'),'user_id'=>$userid['id'], 'entity_access'=>$entity_acce));
        UserPersonnel::create(array('personnel_id'=>$input['personnel']['id'],'user_id'=>$userid['id']));
        return Redirect::route('user');
    }

    public function show($id)
    {

    }
    public function updateimage(Request $request,$id)
    {
        $legal_name=session('entity_name');
        $image_path ='';
        if ($request->hasFile('photo')) {
            $image_path = $request->file('photo')->store("image/$legal_name", 'public');
        }
        // dd($image_path,$id,$legal_name);
        User::findOrFail($id)->update(array('photo_path'=>$image_path));

        return Redirect::route('user');

    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();
        return Redirect::route('user')->with('success', 'Product Deleted.');
    }

    public function logout(Request $request) {

        session_end();
        Auth::logout();
        return Redirect::route('login');
    }

    protected function validateUser()
    {
     return request()->validate([
                'first_name' => ['required', 'max:50'],
                'entity' => ['required', 'max:50'],
                'owner' => ['required'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required'],
                'password_confirmation' => 'required_with:password|same:password',
                'photo_path' =>['required'],
                'personnel'=>['required'],
     ]);
     }
}
