<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
	protected $table = 'products';
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;


	protected $casts = [
		'entity_id' => 'int',
		'sale_price' => 'float',
		'purchase_price' => 'float',
		'quantity' => 'int',
		'category_id' => 'int',
		'tax_id' => 'int',
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
		'name',
		'code',
		'description',
		'sale_price',
		'purchase_price',
		'quantity',
		'category_id',
		'tax_id',
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

	public function tax()
	{
		return $this->belongsTo(Tax::class);
	}

	public function invoice_items()
	{
		return $this->hasMany(InvoiceItem::class);
	}
}
