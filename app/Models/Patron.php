<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Patron extends Model
{
	protected $table = 'patrons';
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;

	protected $casts = [
		'entity_id' => 'int',
        'credit_ledger_id'=>'int',
'debit_ledger_id'=>'int',
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
		'entity_id',
		'patron_type',
		'legal_name',
		'poc_name',
//        'payment_mode',
        'credit_ledger_id',
        'debit_ledger_id',
		'poc_mobile',
		'poc_alt_mobile',
		'poc_landline',
		'poc_email',
		'gstin',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'status',
		'displayed',
		'deleted',
        'lead_by'
	];

	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}

	public function accounts()
	{
		return $this->hasMany(Account::class);
	}

	public function contacts()
	{
		return $this->belongsToMany(Contact::class, 'patron_contacts');
	}

     //ragul put this invoice excel
     public function patron_contacts()
     {
         return $this->belongsTo(PatronContact::class, 'patron_id');
     }
    public function invoice()
	{
		return $this->belongsTo(Invoice::class, 'patron_id');
	}
}
