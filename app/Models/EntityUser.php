<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntityUser extends Model
{
	protected $table = 'entity_users';
	
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;
	
	protected $casts = [
		'user_id' => 'int',
		'entity_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'entity_id',
		'entity_access'
	];

	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
