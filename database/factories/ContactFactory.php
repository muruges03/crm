<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Contact;
use App\Models\Entity;
use App\Models\User;
use DB;
class ContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = Contact::class;

    public function definition()
    {
        $name = $this->faker->text(30);
        $user = User::orderBy(DB::raw('RAND()'))->first();
        return [
            'entity_id'=>rand(1,4),
            'line_1'=>$this->faker->text(100),
            'line_2'=>$this->faker->text(100),
            'city'=>$this->faker->city,
            'state_name'=>$this->faker->state,
            'zipcode'=>$this->faker->postcode,
            'landmark'=>$this->faker->address,
            'contact_type'=>$this->faker->randomElement([
                'Default','Office','Billing','Shipping'
            ]),
            'tag'=>$name,
            'email'=>$this->faker->unique()->safeEmail,
            'mobile'=>$this->faker->phoneNumber,
            'alt_mobile'=>$this->faker->phoneNumber,
            'land_line'=>$this->faker->phoneNumber,
            'relation_type'=>$this->faker->text(100),
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
