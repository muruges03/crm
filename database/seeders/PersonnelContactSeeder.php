<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\PersonnelContact;

class PersonnelContactSeeder extends Seeder
{

    public function run()
    {
        PersonnelContact::factory()->times(1)->create();
    }
}
