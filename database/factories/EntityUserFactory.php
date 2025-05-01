<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Entity;
use App\Models\User;
use App\Models\EntityUser;
use DB;
class EntityUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = EntityUser::class;

    public function definition()
    {
        $user = User::orderBy(DB::raw('RAND()'))->first();
        $Entity = Entity::orderBy(DB::raw('RAND()'))->first();
        return [
            'entity_id'=>$Entity->id,
            'user_id'=>$user->id,
            'entity_access'=>"{id:[".rand(0,30).",".rand(0,30).",".rand(0,30)."]}",
        ];
    }
}
