<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    protected $table = 'ledger';
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $casts = [

        'account_type_id' => 'int',
        'entity_id' => 'int',
        'created_by' => 'int',
        'status' => 'int',
        'default_ledger' => 'int',
        'modified_by' => 'int',
        'deleted' => 'int'
    ];

    protected $dates = [
        'created',
        'modified'
    ];

    protected $fillable = [
        'title',
        'account_type_id',
        'type',
        'opening_balance',
        'notes',
        'default_ledger',
        'entity_id',
        'created',
        'created_by',
        'status',
        'modified',
        'modified_by',
        'deleted'
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function accounts()
    {
        return $this->hasMany(Accounts::class);
    }
    public function account_type()
    {
        return $this->hasMany(AccountType::class);
    }
}
