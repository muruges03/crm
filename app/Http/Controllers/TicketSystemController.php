<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupportSystemRequest;
use App\Models\OmApplication;
use App\Models\OmTicketSystem;
use App\Models\Patron;
use App\Models\Personnel;
use App\Models\ServiceType;
use App\Models\UserGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TicketSystemController extends Controller
{
    public function store(SupportSystemRequest $request)
    {

        $validatedData = $request->validated();
        $validatedData['entity_id'] = $request->entity_id();
        $newTicket = OmTicketSystem::create($validatedData);
        return response()->json([
            'message' => 'Successfully created ticket system',
            'data' => $newTicket->load(['customer', 'type'])
        ], 201);
    }

    public function edit($id)
    {
        $EditData = OmTicketSystem::find($id);
        $ServiceType = ServiceType::all();
        $ServiceBy = Personnel::where('entity_id',  session('entity_id'))->get();
        $Customers = Patron::where('entity_id',  session('entity_id'))->get();
        $UserGrp = UserGroup::all();
        $Application = OmApplication::where([['deleted',0],['entity_id', session('entity_id')]])->get();
        return Inertia::render('SupportTicket/Edit', compact('EditData','Application', 'ServiceType', 'ServiceBy', 'Customers', 'UserGrp'));
    }

    public function update(SupportSystemRequest $request, OmTicketSystem $id)
    {

        $id->update($request->validated());

        return response()->json(['message' => 'Ticket Updated Successfully']);
    }

    public function destroy($id)
    {
        $ticket = OmTicketSystem::find($id);

        $ticket->delete();

        return response()->json(['message' => 'Ticket Deleted Successfully']);
    }

    //store type
    public function storeSupportType(Request $request){
        ServiceType::create([
            'type' => $request->type
        ]);
        return response()->json('Service type saved!');
    }
    public function addGroup(Request $request){
        UserGroup::create([
            'title' => $request->title
        ]);
        return response()->json('User group created!');
    }
    //tat Level Change
    public function tatChange($id,Request $request){
       $ticket =  OmTicketSystem::find($id);
       $ticket->update([
        'tat_level' => $request->tat_level
       ]);
    }
}
