<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
	use SoftDeletes;
	protected $table = 'transactions';
	public $timestamps = false;

	protected $casts = [
		'entity_id' => 'int',
        'origin_id' => 'int',
		'patron_id' => 'int',
		'tx_amount' => 'float',
		'status' => 'int',
		'created_by' => 'int',
		'modified_by' => 'int',
		'deleted_by' => 'int',
		'deleted' => 'int'
	];

	protected $dates = [
		'tx_date',
		'created_at',
		'deleted_at',
		'modified_at'
	];

	protected $fillable = [
		'entity_id',
		'patron_id',
		'project_id',
        'ref_no',
        'origin_id',
		'tx_date',
		'tx_amount',
		'tx_type',
		'description',
		'reference',
		'status',
		'created_at',
		'created_by',
		'modified_at',
		'modified_by',
		'deleted_by',
		'deleted_at',
		'deleted'
	];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {

        });
    }
	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}

	public function patron()
	{
		return $this->belongsTo(Patron::class);
	}

	public function journals()
	{
		return $this->hasMany(Journal::class);
	}
	// Ragul custom query with
	public function ledger()
    {
        return $this->hasMany(Ledger::class);
    }
}
