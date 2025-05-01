<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lead extends Model
{
	protected $table = 'leads';
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;


	protected $casts = [
		'lead_value' => 'float',
		'lead_type_id' => 'int',
		'lead_pipeline_stage_id' => 'int',
		'created_by' => 'int',
		'modified_by' => 'int',
		'status' => 'int',
		'displayed' => 'int',
		'deleted' => 'int'
	];

	protected $dates = [
		'closed_at',
		'expected_close_date',
		'created',
		'modified'
	];

	protected $fillable = [
		'id',
		'entity_id',
		'legal_name',
		'lead_name',
		'lead_mobile',
		'lead_alt_mobile',
		'lead_landline',
		'lead_email',
		'description',
		'lead_value',
		'assigned_to',
		'source',
		'closed_at',
		'lead_type_id',
		'lead_pipeline_stage_id',
		'expected_close_date',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'status',
		'displayed',
		'deleted',
	];

	public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
	public function leadcontacts()
	{
		return $this->hasMany(LeadContact::class);
	}
	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}
	public function lead_pipeline_stages()
	{
		return $this->hasMany(LeadPipelineStage::class);
	}
	public function lead_types()
	{
		return $this->hasMany(LeadType::class);
	}
	public function products()
	{
		return $this->hasMany(Product::class);
	}


}
