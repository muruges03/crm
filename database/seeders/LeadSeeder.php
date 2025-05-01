<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Lead;

class LeadSeeder extends Seeder
{

    public function run()
    {
        Lead::factory()->times(3)->create();
    }
}
