<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Email extends Model
{

	protected $table = 'emails';
	public $timestamps = false;

	protected $casts = [
		'entity_id' => 'int',
		'created_by' => 'int',
		'modified_by' => 'int'
	];

	protected $dates = [
		'created',
		'modified'
	];

	protected $fillable = [
		'entity_id',
		'type',
		'name',
		'subject',
		'notes',
		'team_condition',
		'created',
		'created_by',
		'modified',
		'modified_by'
	];

	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}
}
