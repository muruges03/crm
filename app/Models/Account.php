<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
	protected $table = 'account';
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

	protected $casts = [
		'invoice_id' => 'int',
		'patron_id' => 'int',
		'entity_id' => 'int',
		'untaxed_amount' => 'float',
		'total_amount' => 'float',
		'created_by' => 'int',
		'status' => 'int',
		'modified_by' => 'int',
		'deleted' => 'int'
	];

	protected $dates = [
		'paid_date',
		'created',
		'modified'
	];

	protected $fillable = [
		'invoice_id',
		'patron_id',
		'entity_id',
		'untaxed_amount',
		'total_amount',
		'paid_date',
		'created',
		'created_by',
		'status',
		'modified',
		'modified_by',
		'deleted'
	];

	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}

	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}

	public function patron()
	{
		return $this->belongsTo(Patron::class);
	}
}
