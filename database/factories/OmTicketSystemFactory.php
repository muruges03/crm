<?php

namespace Database\Factories;

use App\Models\Entity;
use App\Models\Patron;
use App\Models\ServiceType;
use App\Models\UserGroup;
use Illuminate\Database\Eloquent\Factories\Factory;

class OmTicketSystemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'entity_id' => Entity::factory(),
            'customer_id' => 1,
            'made_by' => UserGroup::factory(),
            'service_type' => ServiceType::factory(),
            'service_by' => 1,
            'date' => $this->faker->date('Y-m-d H:i:s'),
            'description' => $this->faker->paragraph(1),
            'tat_date' => $this->faker->date('Y-m-d'),
        ];
    }
}
