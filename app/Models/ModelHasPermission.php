<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModelHasPermission extends Model
{
	protected $table = 'model_has_permissions';
	
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;
	
	protected $casts = [
		'permission_id' => 'int',
		'model_id' => 'int'
	];

	public function permission()
	{
		return $this->belongsTo(Permission::class);
	}
}
