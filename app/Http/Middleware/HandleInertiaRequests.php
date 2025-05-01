<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\EntityUser;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    public function version(Request $request)
    {
        return parent::version($request);
    }

    /**
     * Defines the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function share(Request $request)
    {
        if(Auth::user()){
            $entyusr=EntityUser::join('entities','entity_users.entity_id','entities.id')
                                ->where('user_id','=',session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'))
                                ->get(['entity_users.*','entities.status']);
            if($entyusr[0]['status']=='0') {
                Auth::logout();
                session_end();
            }else{
                if(session('entity_id')==null){
                    $session=entity($entyusr[0]['entity_id']);
                }
            }
        }
        return array_merge(parent::share($request), [
            'auth' => function () use ($request) {
                return [
                    'user' => $request->user() ? [
                        'id' => $request->user()->id,
                        // 'first_name' => $request->user()->first_name,
                        // 'last_name' => $request->user()->last_name,
                        // 'email' => $request->user()->email,
                        // 'owner' => $request->user()->owner,
                        'roles'=> $request->user()->roles->pluck('name'),
                        'permissions'=> $request->user()->permissions->pluck('name'),
                        'can' =>$request->user() ? $request->user()->getPermissionArray() : [],
                    ] : null,
                ];
            },
            'flash' => function () use ($request) {
                return [
                    'success' => $request->session()->get('success'),
                    'error' => $request->session()->get('error'),
                ];
            },
        ]);
    }
}
