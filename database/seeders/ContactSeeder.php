<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Contact;
use App\Models\Entity;
use App\Models\Lead;
class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $contacts= Contact::factory()->times(20)->create();

        // Entity::factory(1)->create()->each(function($entity) use($contacts) {
        //     Lead::factory(rand(1, 4))->create([
        //         'entity_id' => $entity->id
        //     ])->each(function($listing) use($contacts) {
        //         $listing->contacts()->attach($contacts->random(2));
        //     });
        // });


    }
}
