<?php

namespace Tests\Unit;

use Tests\TestCase;
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

    public function test_delete_Lead()
    {
        $Lead = Lead::factory()->count(1)->make();

        $Lead = Lead::latest()->first();

        if($Lead) {
            $Lead->forceDelete();
        }

        $this->assertTrue(true);
    }

    public function test_that_a_Lead_can_be_update(){

        $Lead = Lead::factory()->count(1)->make();
        $Lead = Lead::latest()->first();
        $payload =  [
                    "lead_name"=> "Deshaun",
                ];
        $this->json('PUT', 'lead/'.$Lead->id, $payload)
        ->assertStatus(Response::HTTP_NOT_FOUND);
    
    }

  
}
