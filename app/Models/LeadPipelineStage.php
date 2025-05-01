<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadPipelineStage extends Model
{
	protected $table = 'lead_pipeline_stages';
	
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;

	protected $casts = [
		'probability' => 'int',
		'sort_order' => 'int',
		'entity_id' => 'int',
		'created_by' => 'int',
		'modified_by' => 'int',
		'status' => 'int',
		'displayed' => 'int',
		'deleted' => 'int'
	];

	protected $dates = [
		'created',
		'modified'
	];

	protected $fillable = [
		'code',
		'lead_stage',
		'probability',
		'sort_order',
		'entity_id',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'status',
		'displayed',
		'deleted'
	];

	public function lead()
	{
		return $this->belongsTo(Lead::class);
	}
}
