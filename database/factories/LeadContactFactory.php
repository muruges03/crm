<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Entity;
use App\Models\Contact;
use App\Models\LeadContact;
use DB;
class LeadContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model =LeadContact::class;

    public function definition()
    {
        return [
            'lead_id'=>Lead::factory()->create()->id,
            'contact_id'=>Contact::factory()->create()->id,
        ];
    }
}
