<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Models\Entity;
use App\Models\EntityUser;
use App\Models\ModelHasRole;
use Carbon\Carbon;
use App\Models\UserPersonnel;
use App\Models\Personnel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use DB;


class UsersController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:edit_users|create_users|delete_users', ['only' => ['index','store']]);
         $this->middleware('permission:create_users', ['only' => ['create','store']]);
         $this->middleware('permission:edit_users', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_users', ['only' => ['destroy']]);;
    }

    public function edit(User $user)
    {
        $entityusers = EntityUser::join('entities','entities.id', '=', 'entity_users.entity_id')
                                    ->join('users', 'users.id' , '=','entity_users.user_id')
                                    ->where('users.id','=', $user->id)
                                    ->where('entities.deleted','0')
                                    ->get(['entities.id','entities.legal_name']);

        $entity=EntityUser::join('entities','entities.id', '=', 'entity_users.entity_id')
                                    ->join('users', 'users.id' , '=','entity_users.user_id')
                                    ->where('users.id','=', $user->id)
                                    ->where('entities.deleted','0')
                                    ->get('entities.id');
        $personnel=UserPersonnel::join('personnels','personnels.id','=','user_personnels.personnel_id')
                                ->where('user_personnels.user_id',$user->id)->get(['personnels.first_name']);

        // dd( $personnel,$entityusers,$entity);
        $enitycompany=Entity::where('parent_id',session('entity_id'))->where('deleted','0')->get()->map->only('id','legal_name');

        //enity company select fetch data
        $entityuser = DB::table('entity_users')->where('user_id',$user->id)->get();
        // dd($user->id,$entityuser);
        $entyuser=json_decode($entityuser[0]->entity_access);
        foreach( $entyuser as $x) {
            foreach($x as $value){
                 $data[]=DB::table('entities')->where('id',$value)->where('deleted','0')->select('id', 'legal_name')->get();
            }
        }
        // dd($data,$entityusers,$enitycompany);
        return Inertia::render('User/Edit', [
            'user' => [
                'id' => $user->id,
                'first_name' => $user->first_name,
                'last_name' => $user->last_name,
                'email' => $user->email,
                'entity'=>$entity[0]->id,
                'owner' => $user->owner,
                'photo' => $user->photo_path,
                'deleted_at' => $user->deleted_at,
                'roles'=> $user->roles,
            ],
            'roles'=>Role::orderBy('id')
            ->get()
            ->map->only('id','name'),
            'entyuser'=>$data,
            'entityusers'=>$entityusers,
            'enitycompany'=>$enitycompany,
            'personnel'=>$personnel,
        ]);
    }

    public function update(User $user)
    {
        $input = Request::all();
        // dd($input);
        Request::validate([
            'first_name' => ['required', 'max:50'],
            'email' => ['required', 'max:50', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => ['required','nullable'],
            'password_confirmation' => 'required_with:password|same:password',
            'owner' => ['required', 'boolean'],
            'role' => ['required'],
        ]);
        // dd($input);
        if(!empty($input['entity_access'])){
            foreach($input['entity_access'] as $x) {
                $arr[] = $x['id'];
            }
            $arr[] .=session('entity_id');
            $entity_acce=json_encode(array('id'=>array_unique($arr)));
        }else{
            $entity_acce='{"id":['.$input['entity'].']}';
        }
        // dd($arr,$entity_acce);
        // dd(json_encode(array('id'=>$arr)));

        $users =  User::findOrFail($user->id)->update(array(
            'first_name'    => $input['first_name'],
            'last_name'     => $input['last_name'],
            'email'         => $input['email'],
            'owner'         => $input['owner'],
            'password'      => Hash::make($input['password'])
        ));
        // dd($user->id);
        //then assign role
        ModelHasRole::where('model_id', $user->id)->delete();

        //then assign role
        $user->assignRole(Request::get('role'));

        DB::table('entity_users')
            ->where('user_id', $user->id)
            ->update(array('entity_id'=>$input['entity'],'entity_access'=>$entity_acce));

        return Redirect::route('user');

    }

}
