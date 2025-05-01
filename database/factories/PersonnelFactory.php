<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Entity;
use App\Models\User;
use App\Models\Personnel;
use DB;
class PersonnelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Personnel::class;

    public function definition()
    {
        $user = User::orderBy(DB::raw('RAND()'))->first();
        $Entity = Entity::orderBy(DB::raw('RAND()'))->first();
        $name = $this->faker->text(30);
        return [
            'entity_id'=>$Entity->id,
            'first_name'=>$this->faker->text(15),
            'last_name'=>$this->faker->text(5),
            'personnel_type'=>'Employee',
            'gender'=>$this->faker->randomElement([
                'Male', 'Female'
            ]),
            'date_of_birth'=>$this->faker->dateTimeThisCentury->format('Y-m-d'),
            'params'=>'{"department":"Marketing","role":"Jr.Technical Liaison","employee_code":"1","aadharcard":"image\/ONE MODO\/proof\/SFzdTLgPgDspCIVqGFfx5zG1RtBL6bVQRy1i6H4X.png","proof_document":"image\/ONE MODO\/proof\/K6L9Wl5N9BGTOnMmBxGN4kQYYMo1r28YvEPGIXfd.png"}',
            'joining_date'=>$this->faker->dateTimeThisCentury->format('Y-m-d'),
            'notes'=>$this->faker->text(15),
            'proof_document'=> '',
            'aadharcard'=>'',
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
