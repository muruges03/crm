<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Personnel;

class PersonnelSeeder extends Seeder
{
    public function run()
    {
        Personnel::factory()->times(4)->create();
    }
}
