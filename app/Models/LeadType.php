<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LeadType extends Model
{
	protected $table = 'lead_types';
	
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;

	protected $casts = [
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
		'lead_type',
		'created',
		'entity_id',
		'created_by',
		'modified',
		'modified_by',
		'status',
		'displayed',
		'deleted'
	];

	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}

	public function lead()
	{
		return $this->belongsTo(Lead::class);
	}
}
