<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Payment extends Model
{
	use SoftDeletes;
	protected $table = 'payments';
	public $timestamps = false;

	protected $casts = [
		'entity_id' => 'int',
		'payment_transaction_id' => 'int',
		'patron_id' => 'int',
		'ledger_id' => 'int',
        'ref_no'=>'int',
        'prefix'=>'int',
		'bill_ref_id' => 'int',
		'total_amount' => 'float',
		'balance_due' => 'float',
		'paid_amount' => 'float',
		'verified_bank' => 'int',
		'journal_status' => 'int',
		'status' => 'int',
        'created_at'=>'int',
		'created_by' => 'int',
		'modified_by' => 'int',
		'deleted_by' => 'int',
		'deleted' => 'int',
        'deleted_at'=>'int',
	];

	protected $dates = [
		'payment_date',
		'modified_at'
	];

	protected $fillable = [
		'entity_id',
		'payment_transaction_id',
		'patron_id',
		'ledger_id',
		'bill_ref_id',
		'payment_type',
		'payment_date',
		'total_amount',
		'balance_due',
		'paid_amount',
        'ref_no',
        'prefix',
		'description',
		'verified_bank',
		'journal_status',
		'status',
		'created_by',
        'created_at',
		'modified_at',
		'modified_by',
		'deleted_by',
		'deleted',
        'deleted_at',
	];
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
//            $query->whereHas('project', function($query) use($search) {
//                $query->where('name', 'like', '%'.$search.'%');
//            });

            $query->orWhereHas('ledger', function($query) use($search) {
                $query->Where('title', 'like', '%'.$search.'%');
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

	public function payment_transaction()
	{
		return $this->belongsTo(PaymentTransaction::class);
	}

	public function project()
	{
		return $this->belongsTo(Project::class);
	}


    //ragul custom relation
    //start
    public function patron_bank()
    {
        return $this->hasMany(PatronBankLookup::class);
    }


}
