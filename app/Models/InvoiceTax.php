<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class InvoiceTax extends Model
{
	protected $table = 'invoice_tax';
	public $timestamps = false;

	protected $casts = [
		'tax_id' => 'int',
		'invoice_id' => 'int',
		'entity_id' => 'int',
		'account_id'=> 'int',
		'amount' => 'float',
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
		'tax_id',
		'name',
		'invoice_id',
		'account_id',
		'entity_id',
		'amount',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'status',
		'displayed',
		'deleted'
	];

	public function invoice()
	{
		return $this->belongsTo(Invoice::class);
	}

	public function tax()
	{
		return $this->belongsTo(Tax::class);
	}
}
