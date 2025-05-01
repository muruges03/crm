<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportRequest;
use App\Models\OmApplication;
use App\Models\OmTicketSystem;
use App\Models\Patron;
use App\Models\Personnel;
use App\Models\ServiceType;
use App\Models\UserGroup;
use GuzzleHttp\RedirectMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('menu_support');

        $ServiceType = ServiceType::all();
        $ServiceBy = Personnel::where('entity_id', session('entity_id'))->get();
        $Customers = Patron::where('entity_id', session('entity_id'))->get();
        $UserGrp = UserGroup::all();
        $Application = OmApplication::where([['deleted',0],['entity_id', session('entity_id')]])->get();
        $TicketSystem = OmTicketSystem::with(['customer', 'type'])->where('entity_id', session('entity_id'))->get();
        return Inertia::render('SupportTicket/Index', compact('ServiceType', 'ServiceBy', 'Customers', 'TicketSystem', 'UserGrp', 'Application'));
    }
    public function SupportTicket()
    {
        $TicketSystem = OmTicketSystem::with(['customer', 'type'])->where('entity_id', session('entity_id'))->get();
        return response()->json($TicketSystem, 200);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Inertia::render('SupportTicket/SupportTicket');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function store(SupportRequest $request)
    {
        $applicationData = $request->validate([
            'description' => 'required',
            'legal_name' => 'required|string',
            'status' => 'nullable',
            'prefix' => 'nullable',
            'entity_id' => 'nullable'
        ]);
        $applicationData['entity_id'] = $request->getEntityId();
        $applicationData['status'] = $request->status ?? 0 ;
        OmApplication::create($applicationData);
        return back()->with('success', 'Application created successfully!');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
