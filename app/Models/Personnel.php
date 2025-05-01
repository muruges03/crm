<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personnel extends Model
{
	protected $table = 'personnels';
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
		'deleted' => 'int',
		'user_id' => 'int'
	];

	protected $dates = [
		'date_of_birth',
		'joining_date',
		'created',
		'modified'
	];

	protected $fillable = [
		'entity_id',
		'first_name',
		'last_name',
		'personnel_type',
		'gender',
		'date_of_birth',
		'params',
		'joining_date',
		'notes',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'status',
		'displayed',
		'deleted',
		'user_id'
	];

	// public function contact()
	// {
	// 	return $this->belongsTo(Contact::class);
	// }

	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
