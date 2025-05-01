<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    protected $table = 'accounts';
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $casts = [
        'entity_id'  => 'int',
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
        'name',
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

    public function accountType()
    {
        return $this->belongsTo(AccountType::class);
    }
}
