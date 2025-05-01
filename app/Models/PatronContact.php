<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PatronContact extends Model
{
	protected $table = 'patron_contacts';
	public $incrementing = false;
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;

	protected $casts = [
		'patron_id' => 'int',
		'contact_id' => 'int'
	];

	protected $fillable = [
		'patron_id',
		'contact_id'
	];

	public function contacts()
	{
		return $this->belongsTo(Contact::class, 'contact_id');
	}

	public function patrons()
	{
		return $this->belongsTo(Patron::class, 'patron_id');
	}
}
