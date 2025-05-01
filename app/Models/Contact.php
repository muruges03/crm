<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Contact extends Model
{
	protected $table = 'contacts';
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;

	protected $casts = [
		'created_by' => 'int',
		'modified_by' => 'int',
		'status' => 'int',
		'displayed' => 'int',
		'deleted' => 'int',
	];

	protected $dates = [
		'created',
		'modified'
	];

	protected $fillable = [
		'id',
        'person_name',
		'line_1',
		'line_2',
		'city',
		'state_name',
		'zipcode',
		'landmark',
		'contact_type',
		'tag',
		'email',
		'mobile',
		'alt_mobile',
		'land_line',
        'relation_type',
		'secondary_address',
		'secondary_contact_name',
		'secondary_email',
		'secondary_phone',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'status',
		'displayed',
		'deleted',
		'entity_id'
	];
	// public function contact()
    // {
    //     return $this->belongsTo(Contact::class);
    // }
	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}

	public function entities()
	{
		return $this->belongsToMany(Entity::class, 'entity_contacts');
	}

	public function leads()
	{
		return $this->belongsToMany(Lead::class, 'lead_contacts');
	}
//ragul
    // public function patron_contacts()
    //  {
    //      return $this->belongsTo(PatronContact::class, 'contact_id');
    //  }
	// public function contactlead()
	// {
	// 	return $this->hasMany(LeadContact::class);
	// }
}
