<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Entity;
use App\Models\EntityUser;
use App\Models\EntityContact;
use App\Models\User;
use Database\Seeders\EntitySeeder;
use Database\Seeders\EntityUserSeeder;
use Database\Seeders\EntityContactSeeder;
use Database\Seeders\ContactSeeder;
use Illuminate\Support\Str;
use Illuminate\Http\Response;

class EntityTest extends TestCase
{


    public function test_if_seeder_works()
    {
        $this->seed(EntitySeeder::class);
    }

    // public function test_that_a_entities_can_be_added()
    // {
    //     $data = [
    //         'legal_name' => 'Write',
    //         'description' => 'Write and publish an article'
    //     ];

    //     $this->post(route('entities.store'), $data)
    //       ->assertStatus(201)
    //       ->assertJson(compact('data'));
    // }
    // public function test_if_seeder_works()
    // {

    //     $task =  Entity::factory()->times(1)->create();

    //     $this->post('entities',$task->toArray());

    //     $this->assertEquals(1,Entity::all()->count());
    // }

    // public function test_delete_entity()
    // {
    //     $Entity = Entity::factory()->count(1)->make();
    //     // $EntityUser = EntityUser::factory()->count(1)->make();
    //     // $EntityContact = EntityContact::factory()->count(1)->make();
    //     $Entity = Entity::latest()->first();
    //     // $EntityUser = EntityUser::latest()->first();
    //     // $EntityContact = EntityContact::latest()->first();

    //     if($Entity) {
    //         $Entity->forceDelete();
    //     }
    //     // if($EntityUser) {
    //     //     $EntityUser->forceDelete();
    //     // }
    //     // if($EntityContact) {
    //     //     $EntityContact->forceDelete();
    //     // }

    //     $this->assertTrue(true);
    // }

    // public function test_that_a_entity_can_be_update(){

    //     $Entity = Entity::factory()->count(1)->make();

    //     $payload =  [
    //                 "legal_name"=> "Deshaun",
    //             ];
    //     $this->json('PUT', 'entities/4', $payload)
    //     ->assertStatus(Response::HTTP_NOT_FOUND);

    // }


    // public function test_delete_entity_seeder_user()
    // {
    //     $Entity = Entity::factory()->count(1)->make();
    //     $Entity = Entity::latest()->first();
    //     if($Entity) {
    //         $Entity->forceDelete();
    //     }
    //     $this->assertTrue(true);
    // }

    // public function test_that_a_entity_seeder_can_be_update(){


    //     $Entity = Entity::factory()->count(1)->make();
    //     $Entity = Entity::latest()->first();
    //     $data =  [
    //                 "code"=> "Beatae.asdas",
    //                 'lead_stage'=>'123'
    //             ];
    //     $this->json('put', 'api/entities/5', $data)
    //     ->assertStatus(Response::HTTP_NOT_FOUND);

    // }

    // // public function test_insert()
    // // {
    // //     $response = $this->post('/entities/create',[
    // //         'legal_name' => 'ragul',
    // //         'alias' => 's',
    // //         'parent_id'=> '1',
    // //         'description'=> '123456',
    // //         'url'=>'dsafds',
    // //         'logo_file'=>'',
    // //         'time_zone'=>'Asia/Kolkata',
    // //         'api_key'=>'fdsfadsf',
    // //         // 'created'=>,
    // //         // 'created_by'=>,
    // //         // 'modified'=>,
    // //         // 'modified_by'=>,
    // //         // 'status'=>,
    // //         // 'displayed'=>,
    // //         // 'deleted'=>,

    // //     ]);
    // //     $response->assertStatus(200);
    // //     $this->assertTrue(count(Entity::all()) > 1);
    // // }

    // public function authorized_entities_can_update_the_task(){


    //     $this->actingAs(User::factory()->create());

    //     $task = Entity::factory()->create(['user_id' => Auth::id()]);
    //     $task->legal_name = "Updated Title";

    //     $this->put('/entities/'.$task->id, $task->toArray());

    //     $this->assertDatabaseHas('entities',['id'=> $task->id , 'legal_name' => 'Updated Title']);

    // }

    // public function authorized_user_can_delete_the_task(){


    //     $this->actingAs(User::factory()->create());

    //     $task = Entities::factory()->create(['user_id' => Auth::id()]);

    //     $this->get('entities/'.$task->id);

    //     $this->assertDatabaseMissing('entities',['id'=> $task->id]);

    // }

    // public function unauthorized_user_cannot_delete_the_task(){

    //     $this->actingAs(User::factory()->create());

    //     $task = Entity::factory()->create();

    //     $response = $this->delete('/entities/'.$task->id);

    //     $response->assertStatus(403);
    // }

}
