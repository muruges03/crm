<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Entity;

class EntitySeeder extends Seeder
{

    public function run()
    {
        dd('hiii');
        Entity::factory()->create();
    }
}
