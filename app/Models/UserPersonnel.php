<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserPersonnel extends Model
{
	protected $table = 'user_personnels';
	public $incrementing = false;
	public $timestamps = false;
    use HasFactory;
    
	protected $casts = [
		'user_id' => 'int',
		'personnel_id' => 'int'
	];

	protected $fillable = [
		'user_id',
		'personnel_id'
	];

	public function personnel()
	{
		return $this->belongsTo(Personnel::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
