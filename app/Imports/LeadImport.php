<?php

namespace App\Imports;


use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\RegistersEventListeners;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Events\AfterImport;
use Maatwebsite\Excel\Validators\Failure;
use Throwable;
use App\Models\Lead;
use App\Models\User;
use App\Models\LeadType;
use App\Models\LeadPipelineStage;
use App\Models\LeadContact;
use App\Models\Contact;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class LeadImport implements
    ToCollection,
    WithHeadingRow,
    SkipsOnError,
    WithValidation,
    SkipsOnFailure,
    WithBatchInserts,
    WithChunkReading,
    ShouldQueue,
    WithEvents
{
    use Importable, SkipsErrors, SkipsFailures, RegistersEventListeners;

    public function collection(Collection $rows)
    {
        $date = Carbon::now();
        $entity_id= session('entity_id');
        // dd(session('entity_id'),$rows);
        foreach ($rows as $key) {
            //start validation            
            $assigned_to = User::where('email',$key['assigned_to'])->get();
            if(count($assigned_to) > 0)
                $key['assigned_to'] = $key['assigned_to'];
            else{
                $key['assigned_to'] = '';
            }
            Validator::make($key->toArray(), [
                'assigned_to'   => ['required'],
            ])->validate(); 
       }
        $leadtype = LeadType::where('deleted',0)->where('entity_id',session('entity_id'))->orderBy('id', 'ASC')->get();
        $leadpipstage = LeadPipelineStage::where('deleted',0)->where('entity_id',session('entity_id'))->orderBy('id', 'ASC')->get();
        
        // dd($leadtype[0]['id'],$leadpipstage[0]['id']);
        foreach ($rows as $row) {
            $user = User::where('email',$row['assigned_to'])->get();
            // dd($user[0]['id']);
            $lead = Lead::updateOrCreate([
                'entity_id'     => $entity_id,
                'lead_name'     => $row['lead_name'] ? $row['lead_name'] : null,
                'lead_mobile'   => $row['lead_mobile'],
                'lead_email'    => $row['lead_email'],
                'description'   => $row['description'],
                'assigned_to'   => $row['assigned_to'],
                'lead_value'    => $row['lead_value'],
                'source'        => $row['source'],
                'closed_at'     => $row['closed_at'],
                'expected_close_date' => $row['expected_close_date'],
                'lead_type_id'  => $leadtype[0]['id'],
                'assigned_to'   => $user[0]['id'],
                'lead_pipeline_stage_id' => $leadpipstage[0]['id'],
                'created'       => $date->toDateTimeString(),
                'created_by'    => Auth::user()->id,
            ]);
            $contact = Contact::updateOrCreate([
                'entity_id'     =>  $entity_id,
                'person_name'   => $row['person_name'],
                'line_1'        => $row['address'],
                'mobile'        => $row['mobile'],
                'city'          => $row['city'],
                'state_name'    => $row['state_name'],
                'zipcode'       => $row['zip_code'] ? $row['zip_code'] : null,
                'landmark'      => $row['land_mark'],
                'contact_type'  => 'Office',
                'created'       => $date->toDateTimeString(),
                'created_by'    => Auth::user()->id,
            ]);
            $lead->leadcontacts()->create([
                'lead_id'       => $lead->id,
                'contact_id'    => $contact->id
            ]);
        }
    }

    public function rules(): array
    {
        return [
            // 'lead_name' => "required|unique:leads,lead_name"
        ];
    }

    public function chunkSize(): int
    {
        return 1000;
    }
    public function batchSize(): int
    {
        return 1000;
    }
    public static function afterImport(AfterImport $event)
    {
    }

    public function onFailure(Failure ...$failure)
    {
    }
}
