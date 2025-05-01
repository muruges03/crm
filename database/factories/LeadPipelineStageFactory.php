<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\User;
use App\Models\Contact;
use App\Models\Entity;
use App\Models\LeadPipelineStage;
use DB;
class LeadPipelineStageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model =LeadPipelineStage::class;

    public function definition()
    {
        $user = User::orderBy(DB::raw('RAND()'))->first();
        $Entity = Entity::orderBy(DB::raw('RAND()'))->first();
        return [
            'entity_id'=> $Entity->id,
            'code'=>$this->faker->text(15),
            'lead_stage'=>$this->faker->text(15),
            'probability'=>rand(1,5),
            'sort_order'=>rand(1,5),
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
