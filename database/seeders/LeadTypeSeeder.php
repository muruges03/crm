<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\LeadType;

class LeadTypeSeeder extends Seeder
{

    public function run()
    {
        LeadType::factory()->times(2)->create();
    }
}
