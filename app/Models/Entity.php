<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Entity extends Model
{
	protected $table = 'entities';
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;

	protected $casts = [
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
		'entity_type',
		'parent_id',
		'legal_name',
		'alias',
		'description',
		'gstin',
		'url',
		'logo_file',
		'time_zone',
		'api_key',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'status',
		'displayed',
		'deleted'
	];

	public function contacts()
	{
		return $this->belongsToMany(Contact::class, 'entity_contacts');
	}

	public function users()
	{
		return $this->belongsToMany(User::class, 'entity_users')
					->withPivot('entity_access');
	}

	public function lead_types()
	{
		return $this->hasMany(LeadType::class);
	}

	public function leads()
	{
		return $this->hasMany(Lead::class);
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
