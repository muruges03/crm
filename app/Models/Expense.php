<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'expenses';
    public $timestamps = false;

    protected $casts = [
        'entity_id' => 'int',
        'paid_through' => 'int',
        'expense_id' => 'int',
        'machine_id'=>'int',
        'vendor_id' => 'int',
        'move_id'=> 'int',
        'status' => 'int',
        'made_by'=> 'int',
        'created_by' => 'int',
        'modified_by' => 'int',
        'deleted_by' => 'int',
        'deleted' => 'int'
    ];

    protected $dates = [
        'date',
        'deleted_at',
        'modified_at',
        'created_at',
    ];

    protected $fillable = [
        'entity_id',
        'paid_through',
        'date',
        'prefix',
        'ref_no',
        'made_by',
        'expense_id',
        'machine_id',
        'note',
        'vendor_id',
        'amount',
        'move_id',
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
                $query->where('ref_no', 'like', '%'.$search.'%')
                    ->orWhere('amount', 'like', '%'.$search.'%');
            });
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
    public function ledger()
    {
        return $this->belongsTo(Ledger::class);
    }
    public function personnel()
    {
        return $this->belongsTo(Personnel::class);
    }



}
