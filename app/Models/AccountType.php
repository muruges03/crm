<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountType extends Model
{
    protected $table = 'accounttype';
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $casts = [

        'account_id' => 'int',
        'entity_id' => 'int',
        'created_by' => 'int',
        'status' => 'int',
        'modified_by' => 'int',
        'deleted' => 'int'
    ];

    protected $dates = [
        'created',
        'modified'
    ];

    protected $fillable = [
        'type_name',
        'account_id',
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
    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }

}
