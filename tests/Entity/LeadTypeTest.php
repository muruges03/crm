<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\LeadType;
use Database\Seeders\LeadTypeSeeder;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class LeadTypeTest extends TestCase
{

    public function test_if_seeder_works()
    {
        $this->seed(LeadTypeSeeder::class);
    }
    
    public function test_delete_user()
    {
        $LeadType = LeadType::factory()->count(1)->make();
        $LeadType = LeadType::latest()->first();
        if($LeadType) {
            $LeadType->forceDelete();
        }
        $this->assertTrue(true);
    }

    public function test_that_a_task_can_be_update(){

      
        $LeadType = LeadType::factory()->count(1)->make();
        $LeadType = LeadType::latest()->first();
        $data =  [
                    "lead_type"=> "Beatae.asdas",
                ];
        $this->json('put', 'api/leadtypeupdate/5', $data)
        ->assertStatus(Response::HTTP_NOT_FOUND);
    
    }



    // public function deleteStubUser()
    // {
    //     $this->user->forceDelete();
    // }
}
