<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase;

class TestHelper
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
   public function login($user = null){
    if(!$user){
       $user = User::factory()->create();
    }
    return $this->signIn($user);
   }

   protected function signIn($user = null){
    $user = $user ?: User::factory()->create();
    auth()->login($user);
    return $user;
   }
}
