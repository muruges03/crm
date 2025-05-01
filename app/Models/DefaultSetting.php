<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultSetting extends Model
{
    protected $table = 'default_settings';
    public $timestamps = false;
    const CREATED_AT = 'created';
    const UPDATED_AT = 'modified';

    protected $casts = [

        'ledger_id' => 'int',
        'entity_id' => 'int',
        'created_by' => 'int',
        'status' => 'int',
        'modified_by' => 'int',
        'deleted' => 'int'
    ];

    protected $dates = [
        'created',
        'modified',
        'deleted_at'
    ];

    protected $fillable = [
        'type',
        'name',
        'ledger_id',
        'entity_id',
        'created',
        'created_by',
        'status',
        'modified',
        'modified_by',
        'deleted_at',
        'deleted_by',
        'deleted'
    ];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function ledgers()
    {
        return $this->hasMany(Ledger::class);
    }
}
