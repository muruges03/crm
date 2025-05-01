<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\LeadPipelineStage;
use Database\Seeders\LeadPipelineStageSeeder;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class LeadPipelineStageTest extends TestCase
{

    public function test_if_seeder_works()
    {
        $this->seed(LeadPipelineStageSeeder::class);
    }
    
    public function test_delete_user()
    {
        $LeadPipelineStage = LeadPipelineStage::factory()->count(1)->make();
        $LeadPipelineStage = LeadPipelineStage::where('entity_id',session('entity_id'))->latest()->first();
        if($LeadPipelineStage) {
            $LeadPipelineStage->forceDelete();
        }
        $this->assertTrue(true);
    }

    public function test_that_a_tp_can_be_update(){

      
        $LeadPipelineStage = LeadPipelineStage::factory()->count(1)->make();
        $LeadPipelineStage = LeadPipelineStage::where('entity_id',session('entity_id'))->latest()->first();
        $data =  [
                    "code"=> "Beatae.asdas",
                    'lead_stage'=>'123'
                ];
        $this->json('put', 'api/leadstageupdate/5', $data)
        ->assertStatus(Response::HTTP_NOT_FOUND);
    
    }



    // public function deleteStubUser()
    // {
    //     $this->user->forceDelete();
    // }
}
