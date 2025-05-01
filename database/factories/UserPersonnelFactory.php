<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Entity;
use App\Models\User;
use App\Models\UserPersonnel;
use App\Models\Personnel;
use DB;

class UserPersonnelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = UserPersonnel::class;

    public function definition()
    {
        $user = User::orderBy(DB::raw('RAND()'))->first();

        return [
            'personnel_id'=>Personnel::factory()->create()->id,
            'user_id'=>$user->id,
            // 'user_id'=>factory('App\Models\User')->create()->id,
        ];
    }
}
