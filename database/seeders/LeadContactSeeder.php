<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\LeadContact;

class LeadContactSeeder extends Seeder
{

    public function run()
    {
        LeadContact::factory()->times(1)->create();
    }
}
