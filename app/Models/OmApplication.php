<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmApplication extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'om_applications';

    public $timestamps = false;

    protected $casts = [
        'deleted' => 'boolean'
    ];

    public function entity(){
        return $this->belongsTo(Entity::class, 'entity_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::updating(function ($model) {
            $model->modified_at = now();
        });

        static::creating(function ($model) {
            $model->created_at = now();
        });
    }
}
