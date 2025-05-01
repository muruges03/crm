<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\LeadType;
use App\Models\User;
use App\Models\Entity;
use DB;
class LeadTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = LeadType::class;

    public function definition()
    { 
        $user = User::orderBy(DB::raw('RAND()'))->first();
        $Entity = Entity::orderBy(DB::raw('RAND()'))->first();
        $name = $this->faker->text(30);
        return [
            'entity_id'=> $Entity->id,
            'lead_type'=>$this->faker->text(15),
            'created'=>$this->faker->dateTimeThisCentury->format('Y-m-d'),
            'created_by'=>$user->id,
            'modified'=>$this->faker->dateTimeThisCentury->format('Y-m-d'),
            'modified_by'=>$user->id,
            'status'=>rand(0,1),
            'displayed'=>rand(0,1),
            'deleted'=>rand(0,1),
        ];
    }
}
