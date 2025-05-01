<?php

namespace App\Http\Controllers;

use App\Models\Entity;
use Illuminate\Http\Request;
use DB;
use Inertia\Inertia;
use Redirect;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $entityuser = DB::table('entity_users')->where('user_id', session('login_web_59ba36addc2b2f9401580f014c7f58ea4e30989d'))->get();
        $entity_parent = DB::table('entities')->where('id', $entityuser[0]->entity_id)->select('id', 'parent_id')->get()->toArray();
        $entyuser = json_decode($entityuser[0]->entity_access);
        foreach ($entyuser as $x => $y) {
            foreach ($y as $value) {
                if ($entity_parent[0]->parent_id == "Null") {
                    $adminentity[] = DB::table('entities')->where('id', $value)->select('id', 'legal_name')->get()->toArray();
                } else {
                    $adminentity = DB::table('entities')->where('id', session('entity_id'))->select('id', 'legal_name')->get();
                }
            }
        }
        $orgination = Entity::where('entity_type', 'Organization')->where('deleted', 0)->select('id', 'legal_name')->get();
        $company = Entity::where('entity_type', 'Company')->where('deleted', 0)->select('id', 'legal_name')->get();
        return Inertia::render('Home', compact('adminentity', 'orgination', 'company'));
    }
    public function entity($id, Request $request)
    {
        $session = entity($id);
        return Redirect::back();
    }
}
