<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTransaction extends Model
{
	use SoftDeletes;
	protected $table = 'payment_transactions';
	public $timestamps = false;

	protected $casts = [
		'entity_id' => 'int',
		'ledger_id' => 'int',
		'bill_ref_id' => 'int',
		'patron_id' => 'int',
		'total_amount' => 'float',
		'verified_bank' => 'int',
		'journal_status' => 'int',
		'status' => 'int',
		'created_by' => 'int',
		'modified_by' => 'int',
		'deleted_by' => 'int',
		'deleted' => 'int',
	];

	protected $dates = [
		'payment_date',
		'modified_at',
        'created_at',
        'deleted_at',
	];

	protected $fillable = [
		'entity_id',
		'ledger_id',
		'project_id',
		'bill_ref_id',
		'patron_id',
		'payment_date',
		'total_amount',
		'description',
		'verified_bank',
		'journal_status',
        'filename',
        'payment_type',
        'ref_no',
        'prefix',
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
//            $query->whereHas('project', function($query) use($search) {
            $query->where('payment_type', 'like', '%'.$search.'%')
                    ->orWhere('total_amount', 'like', '%'.$search.'%')
//            });
                ->orwhereHas('patron', function ($subq) use ($search) {
                    $subq->where(function ($subq2) use ($search) {
                        $subq2->orWhere('legal_name', 'like', '%' . $search . '%');
                    });
                })
            ->orWhereHas('ledger', function($query) use($search) {
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

	public function payments()
	{
		return $this->hasMany(Payment::class);
	}

}
