<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\EntityUser;

class EntityUserSeeder extends Seeder
{

    public function run()
    {
        EntityUser::factory()->times(1000)->create();
    }
}
