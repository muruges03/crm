<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Inertia\Inertia;

use Illuminate\Http\Request;

class RolesController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:edit_roles|create_roles|delete_roles', ['only' => ['index','store']]);
         $this->middleware('permission:create_roles', ['only' => ['create','store']]);
         $this->middleware('permission:edit_roles', ['only' => ['edit','update']]);
         $this->middleware('permission:delete_roles', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $length = request('length', 10);
        $sort = request('sort', 'id');
        $order= request('order', 'desc');

        $query = Role::when($request->term, function($query, $term) {
            $query->Where('name', 'LIKE', '%'.$term.'%');
            })->orderBy($sort, $order)->paginate($length);

        return Inertia::render('Roles/Index', ['roles' => $query]);

        return Inertia::render('Roles/Index', [
            'roles' => Role::orderBy('id','ASC')
            ->get()
            // ->transform( function ($role) {
            //         return[
            //             'id' => $role->id,
            //             'name' => $role->name,
            //             'guard_name' => $role->guard_name,
            //             'assignedPermissions' => $role->permissions
            //             ->map
            //             ->only('id', 'name'),
            //              ];
            //         }
			// )
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::get();
       //dd($permissions);
        return Inertia::render('Roles/Create', [
            'permissions' => $permissions,
            'unassignedPermissions' => Permission::all()
            ->map->only('id', 'name'),
            'assignedPermissions' => array(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //validate input
        //dd($request->input('permissions'));
        $request->validate(
            [
                'name' => ['required', 'max:50'],
                'guard_name' => ['required', 'max:50'],
            ]
        );

        $role = Role::create(
            [
                'name' => $request->input('name'),
                'guard_name' => $request->input('guard_name'),
            ]
        );

        $permissions = $request->input('permissions');

        $role->syncPermissions($permissions);

        return Redirect::route('roles')->with('success', 'Role created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return Inertia::render('Roles/Edit', [
            'role' => [
                'id' => $role->id,
                'name' => $role->name,
                'guard_name' => $role->guard_name,
            ],
            //'permissions' => Permission::get()->only('id', 'name'),
            'unassignedPermissions' => Permission::whereNotIn('id', $role->permissions->map->only('id'))
                ->get()
                ->map
                ->only('id', 'name') ,

            'assignedPermissions' => $role->permissions->map->only('id', 'name')

        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $role)
    {
        //validate input
        $request->validate(
            [
                'name' => ['required', 'max:50'],
                'guard_name' => ['required', 'max:50'],
            ]
        );

         $permissions = $request->input('permissions');

         $role = Role::find($role);

         $role->name = $request->input('name');

         $role->guard_name = $request->input('guard_name');

         $role->save();

         $role->syncPermissions($permissions);

         return Redirect::route('roles')->with('success', 'Role created.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        //erase completely
        $role->forceDelete();

        return Redirect::route('roles')->with('success', 'Role Deleted.');
    }
}
