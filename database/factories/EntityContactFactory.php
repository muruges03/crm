<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;
use App\Models\Entity;
use App\Models\Contact;
use App\Models\EntityContact;
use DB;
class EntityContactFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = EntityContact::class;
  
    public function definition()
    {
        $Entity = Entity::orderBy(DB::raw('RAND()'))->first();
        return [
            'entity_id'=> $Entity->id,
            'contact_id'=>rand(1,5),
        ];
    }
}
