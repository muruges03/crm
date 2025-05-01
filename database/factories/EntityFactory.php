<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Entity;
use App\Models\User;
use DB;
class EntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Entity::class;

    public function definition()
    {
       
        $user = User::orderBy(DB::raw('RAND()'))->first();
        $name = $this->faker->text(30);
        return [
            'entity_type'=>$this->faker->randomElement([
                'Organization','Company'
            ]),
            'legal_name'=>$this->faker->text(15),
            'alias'=>$this->faker->text(50),
            'parent_id'=>rand(1,5),
            'description'=>$this->faker->text(200),
            'url'=>$this->faker->url,
            'logo_file'=>'',
            'time_zone'=>$this->faker->randomElement([
               'Asia/Kolkata'
            ]),
            'api_key'=>$name,
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
