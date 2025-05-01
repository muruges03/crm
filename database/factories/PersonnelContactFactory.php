<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Personnel;
use App\Models\Contact;
use App\Models\PersonnelContact;
use DB;
class  PersonnelContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model =PersonnelContact::class;

    public function definition()
    {
        return [
            'personnel_id'=>Personnel::factory()->create()->id,
            'contact_id'=>Contact::factory()->create()->id,
        ];
    }
}
