<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Journal extends Model
{
	use SoftDeletes;
	protected $table = 'journals';
	public $timestamps = false;

	protected $casts = [
		'entity_id' => 'int',
		'patron_id' => 'int',
		'ledger_id' => 'int',
        'tax_id'    =>'int',
		'transaction_id' => 'int',
		'debit_amount' => 'float',
		'credit_amount' => 'float',
		'status' => 'int',
		'created_by' => 'int',
		'modified_by' => 'int',
		'deleted_by' => 'int',
		'deleted' => 'int'
	];

	protected $dates = [
		'entry_date',
		'deleted_at',
		'created_at',
		'modified_at'
	];

	protected $fillable = [
		'entity_id',
		'patron_id',
		'ledger_id',
		'transaction_id',
        'tax_id',
		'entry_date',
		'debit_amount',
		'credit_amount',
		'narration',
		'notes',
		'status',
		'created_at',
		'created_by',
		'modified_at',
		'modified_by',
		'deleted_at',
		'deleted_by',
		'deleted'
	];

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('entry_date', 'like', '%'.$search.'%');
            });
            $query->whereHas('project', function($query) use($search) {
                $query->where('name', 'like', '%'.$search.'%');
            });
        });
    }

	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}

	public function ledger()
	{
		return $this->belongsTo(Ledger::class);
	}

	public function patron()
	{
		return $this->belongsTo(Patron::class);
	}

	public function transaction()
	{
		return $this->belongsTo(Transaction::class);
	}

    public function account_type()
    {
        return $this->belongsTo(AccountType::class);
    }


}
