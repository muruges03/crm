<?php

namespace Tests\Unit;


use Tests\TestCase;
use App\Models\User;
use App\Models\Entity;
use App\Models\Personnel;
use Database\Seeders\PersonnelSeeder;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class PersonnelTest extends TestCase
{
  
    
    public function test_if_seeder_works()
    {
        $this->seed(PersonnelSeeder::class);
    }
    public function test_delete_perosnnel()
    {
        $personnel = Personnel::factory()->count(1)->make();

        $personnel = Personnel::latest()->first();

        if($personnel) {
            $personnel->forceDelete();
        }

        $this->assertTrue(true);
    }


    public function test_that_a_task_can_be_update(){

        //Given we have a signed in user
        $personnel = Personnel::factory()->count(1)->make();

        $personnel = Personnel::latest()->first();
        $personnel->first_name = "Updated first name";
        $payload =  [
                    'entity_id'=>'1',
                    'first_name' => 'Lilian',
                    'last_name' => 's',
                    'personnel_type'=>'Employee',
                    'gender'=>'male',
                    'date_of_birth'=>'28/06/1999',
                    'params'=>'{"department":"DEveloper","role":"SD"}',
                    'joining_date'=>'2/8/2022',
                    'notes'=>'hello world',
                ];
        $this->json('put', 'api/personnels/'.$personnel->id, $payload)
        ->assertStatus(Response::HTTP_NOT_FOUND);

    }

}
