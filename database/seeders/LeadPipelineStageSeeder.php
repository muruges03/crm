<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\LeadPipelineStage;

class LeadPipelineStageSeeder extends Seeder
{

    public function run()
    {
        LeadPipelineStage::factory()->times(3)->create();
    }
}
