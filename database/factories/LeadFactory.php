<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Lead;
use App\Models\Entity;
use App\Models\User;
use DB;
class LeadFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Lead::class;

    public function definition()
    { 
        $user = User::orderBy(DB::raw('RAND()'))->first();
        $Entity = Entity::orderBy(DB::raw('RAND()'))->first();
        $name = $this->faker->text(30);
        return [
            'entity_id'=> $Entity->id,
            'lead_name'=>$this->faker->text(15),
            'lead_mobile'=>$this->faker->tollFreePhoneNumber,
            'lead_alt_mobile'=>$this->faker->tollFreePhoneNumber,
            'lead_landline'=>$this->faker->tollFreePhoneNumber,
            'lead_email'=>$this->faker->companyEmail,
            'description'=>$this->faker->text(50),
            'lead_value'=>rand(1,5),
            'assigned_to'=>'1',
            'source'=>$this->faker->text(50),
            'closed_at'=>$this->faker->dateTimeThisCentury->format('Y-m-d'),
            'lead_type_id'=>'1',
            'lead_pipeline_stage_id'=>'1',
            'expected_close_date'=>$this->faker->dateTimeThisCentury->format('Y-m-d'),
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
