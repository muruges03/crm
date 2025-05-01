<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EntityContact extends Model
{
	protected $table = 'entity_contacts';
	
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;

	protected $casts = [
		'entity_id' => 'int',
		'contact_id' => 'int'
	];

	protected $fillable = [
		'entity_id',
		'contact_id'
	];

	public function contact()
	{
		return $this->belongsTo(Contact::class);
	}

	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}
}
