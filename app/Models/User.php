<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
	protected $table = 'users';
	use HasFactory;
    use Notifiable;
    use SoftDeletes;
    use HasRoles;

	protected $casts = [
		'owner' => 'bool'
	];

	protected $dates = [
		'email_verified_at'
	];

	protected $hidden = [
		'password',
		'two_factor_secret',
		'remember_token'
	];

	protected $fillable = [
		'first_name',
		'last_name',
		'email',
		'email_verified_at',
		'password',
		'two_factor_secret',
		'two_factor_recovery_codes',
		'owner',
		'photo_path',
		'remember_token'
	];

	public function entities()
	{
		return $this->belongsToMany(Entity::class, 'entity_users')
		->withPivot('entity_access');
	}

    public function getPermissionArray()
    {
        return $this->getAllPermissions()->mapWithKeys(function($pr){
            return [$pr['name'] => true];
        });

    }
	public function mark_task_as_completed()
    {
        $this->first_name = 'test';
        $this->save();
    }

	public function is_completed()
    {
        return $this->first_name;
    }

	public function personnels()
	{
		return $this->belongsToMany(Personnel::class, 'user_personnels');
	}

}
