<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
	protected $table = 'invoices';
	public $timestamps = false;
	const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';
    use HasFactory;

	protected $casts = [
		'entity_id' => 'int',
        'ledger_id' => 'int',
		'untaxed_amount' => 'float',
		'tax_amount' => 'float',
		'total_amount' => 'float',
		'discount_amount' => 'float',
		'category_id' => 'int',
		'patron_id' => 'int',
		'is_sent'=>'int',
		'created_by' => 'int',
		'modified_by' => 'int',
		'deleted' => 'int'
	];

	protected $dates = [
		'invoiced_at',
		'due_at',
		'created',
		'modified',
		'start_date',
		'end_date',
	];

	protected $fillable = [
		'entity_id',
		'type',
		'prefix',
        'cancel_status',
		'invoice_number',
		'order_number',
		'paid_status',
		'start_date',
		'end_date',
		'invoiced_at',
		'due_at',
		'untaxed_amount',
		'tax_amount',
		'total_amount',
		'discount_amount',
		'category_id',
		'patron_id',
        'ledger_id',
		'notes',
		'is_sent',
		'status',
		'created',
		'created_by',
		'modified',
		'modified_by',
		'deleted'
	];


    public function scopeFilter($query, array $filters)
    {

        $query->when($filters['invoice_number'] ?? null, function ($query, $search) {
//            dd($query,$search);
            $query->where(function ($query) use ($search) {
//                $startDate = Carbon::createFromFormat('Y-m-d',$search);
                $query->where('invoice_number', 'like', '%'.$search.'%')
                ->orWhere('prefix', 'like', '%'.$search.'%')
                    ->orWhere('untaxed_amount', 'like', '%'.$search.'%')
                    ->orWhere('total_amount', 'like', '%'.$search.'%')
//                $query->whereDate('date_order', 'like', '%'.$startDate.'%')
                    ->orwhereHas('patrons', function ($subq) use ($search) {
                        $subq->where(function ($subq2) use ($search) {
                            $subq2->orWhere('legal_name', 'like', '%'.$search.'%');
                        });
                    });
            });
        });


    }
	public function entity()
	{
		return $this->belongsTo(Entity::class);
	}

	public function accounts()
	{
		return $this->hasMany(Account::class);
	}

	public function invoice_items()
	{
		return $this->hasMany(InvoiceItem::class);
	}

	public function taxes()
	{
		return $this->belongsToMany(Tax::class)
					->withPivot('id', 'account_id', 'entity_id', 'name', 'amount', 'created', 'created_by', 'modified', 'modified_by', 'status', 'displayed', 'deleted');
	}

    //ragul put this invoice excel
    public function patrons()
	{
		return $this->belongsTo(Patron::class, 'patron_id');
	}
    public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }

}
