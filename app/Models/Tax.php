<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tax extends Model
{
	protected $table = 'taxes';
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;

	protected $casts = [
		'tax_amount' => 'float',
		'account_id' => 'int',
		'parent_id' => 'int',
		'entity_id' => 'int',
		'created_by' => 'int',
		'modified_by' => 'int',
		'status' => 'int',
		'visibility' => 'int',
		'deleted' => 'int'
	];

	protected $dates = [
		'created',
		'modified'
	];

	protected $fillable = [
		'tax_name',
		'tax_type',
		'tax_amount',
		'account_id',
		'parent_id',
		'tax_group',
		'entity_id',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'status',
		'visibility',
		'deleted'
	];

	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}

	public function invoice_items()
	{
		return $this->hasMany(InvoiceItem::class);
	}

	public function products()
	{
		return $this->hasMany(Product::class);
	}
}
