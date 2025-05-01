<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvoiceItem extends Model
{
	protected $table = 'invoice_items';
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;

	protected $casts = [
		'entity_id' => 'int',
		'invoice_id' => 'int',
		'product_id' => 'int',
		'quantity' => 'float',
		'price' => 'float',
		'tax_id' => 'int',
		'tax_amount' => 'float',
		'discount_amount' => 'float',
		'total_amount' => 'float',
		'created_by' => 'int',
		'modified_by' => 'int',
		'deleted' => 'int'
	];

	protected $dates = [
		'created',
		'modified'
	];

	protected $fillable = [
		'entity_id',
		'invoice_id',
		'product_id',
		'quantity',
		'description',
		'price',
		'tax_id',
		'discount_type',
		'tax_amount',
		'discount_amount',
		'total_amount',
		'order',
		'created',
		'created_by',
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

	public function product()
	{
		return $this->belongsTo(Product::class);
	}

	public function tax()
	{
		return $this->belongsTo(Tax::class);
	}
}
