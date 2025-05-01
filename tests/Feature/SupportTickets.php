<?php

namespace Tests\Feature;

use Tests\Feature\TestHelper;
use App\Models\OmTicketSystem;
use App\Models\SupportTicket;
use App\Models\SupportType;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SupportTickets extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
    // public function test_create_support_tickets()
    // {
    //     $this->withoutExceptionHandling();
    //     $user = User::find(3);

    //     $this->actingAs($user);
    //     $this->postJson('/supportType', [
    //         'type' => 'ticket type',
    //     ]);
    //     $this->assertDatabaseHas('om_service_type', [
    //         'type' => 'ticket type'
    //     ]);
    // }
    // public function test_create_support_tickets()
    // {
    //     $this->withoutExceptionHandling();
    //     $user = User::factory()->create();
    //     $this->actingAs($user);
    //     $response = $this->postJson('/support/store', [
    //         'description' => 'ticket description',
    //         'entity_id' => 1,
    //         'legal_name' => 'Legal company',
    //         'prefix' => 'NEW',
    //         'status' => 0,
    //     ]);
    //     $response->dump();

    //     $response->assertStatus(201);

    //     $this->assertDatabaseHas('om_applications', [
    //         'description' => 'ticket description',
    //     ]);
    // }

    // public function testDeleteTickets(){
    //     $this->withoutExceptionHandling();
    //     $user = User::find(3);
    //     $this->actingAs($user);
    //     $ticket = OmTicketSystem::factory()->create();
    //     $response = $this->delete(route('supportSystem.destroy', $ticket->id));
    //     $response->assertStatus(200);
    //     $this->assertDatabaseMissing('ticket_systems', ['id' => $ticket->id]);
    // }

    public function test_show_ticket_table(){
        $this->withoutExceptionHandling();
        $helper = new TestHelper();
        $user = $helper->login();
        $this->assertAuthenticated();
        // $response = $this->get('/support');
        // $response->assertStatus(200);
    }
}
