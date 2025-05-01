<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use App\Models\Entity;
use App\Models\Lead;
use Database\Seeders\LeadSeeder;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class LeadTest extends TestCase
{

    public function test_if_seeder_works()
    {
        $this->seed(LeadSeeder::class);
    }

    public function test_delete_lead()
    {
        $lead = Lead::factory()->count(1)->make();

        $lead = Lead::latest()->first();

        if($lead) {
            $lead->forceDelete();
        }

        $this->assertTrue(true);
    }

    public function test_that_a_lead_can_be_update(){

        //Given we have a signed in user
        $lead = Lead::factory()->count(1)->make();

        $lead = Lead::latest()->first();
        $lead->legal_name = "Updated legal name";
        $payload =  [
                    'entity_id'=>'1',
                    'legal_name' => 'Lilsian',
                    'lead_mobile' => '852968596',
                    'lead_alt_mobile'=>'8523969685',
                    'lead_landline'=>'044253362',
                    'lead_email'=>'srag1ul@gmail.com',
                    'description'=>'dfsg1dfasg',
                    'lead_value'=>'10010',
                    'assigned_to'=>'sun1dar',
                    'source'=>'facebo1ok',
                    'closed_at'=>'25/12/2021',
                    'lead_type_id '=>'1',
                    'lead_pipeline_stage_id '=>'1',
                    'expected_close_date'=>'20/02022',

                ];
        $this->json('put', 'api/lead/'.$lead->id, $payload)
        ->assertStatus(Response::HTTP_NOT_FOUND);

    }


}
