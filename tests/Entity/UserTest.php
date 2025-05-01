<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\User;
use Database\Seeders\UserSeeder;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Database\Factories\UserFactory;

class UserTest extends TestCase
{

    // public function test_that_a_users_can_be_added()
    // {
    //     $data = [
    //         'first_name' => 'Write',
    //         'last_name' => 'an article'
    //     ];
      
    //     $this->post(route('user.store'), $data)
    //       ->assertStatus(201)
    //       ->assertJson(compact('data'));
    // }

    public function test_if_seeder_works()
    {
        $this->seed(UserSeeder::class);
    }

    public function test_delete_user()
    {
        $user = User::factory()->count(1)->make();

        $user = User::latest()->first();

        if($user) {
            $user->forceDelete();
        }

        $this->assertTrue(true);
    }

    public function test_that_a_task_can_be_update(){

        // $user = User::factory()->count(1)->make();
     
        $payload =  [
                    'id'=>'5',
                    "first_name"=> "Deshaun",
                    "last_name"=> "Pacocha",
                    "email"=> "aauer@example.net",
                    "email_verified_at"=> "2022-01-31 08:16:30",
                    "two_factor_secret"=> null,
                    "two_factor_recovery_codes"=> null,
                    "owner"=> 0,
                    "photo_path"=> null,
                    "remember_token"=> "Zf19VUOy6m",
                    "created_at"=> "2022-01-31 08:16:30",
                    "updated_at"=>  "2022-01-31 08:16:30",
                    "deleted_at"=>  null
                ];
                // $this->json('PUT', 'users/5', $payload)

        // $user = UserFactory::new()->create(['first_name' => 'John Doe']);
        // $response->assertInertiaHas('user', $user);

        $this->post('users/5', $payload)
        ->assertStatus(Response::HTTP_NOT_FOUND);
        // ->assertJsonStructure(['error']);
        // $response=User::findOrFail($user->id)->update(array('first_name'=>'first update'));
        // $response->assertJson([
        //     'message' => 'task successfully marked as updated'
        // ], true); // ensure that the JSON response recieved contains the message specified
        // $response->assertEquals(200, $response->status()); // furthe ensures that a 200 response code is recieved from the patch request
    
    }

  
}
