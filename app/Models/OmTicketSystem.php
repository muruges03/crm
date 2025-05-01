<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OmTicketSystem extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
    protected $table = 'om_ticket_system';

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
    public function customer()
    {
        return $this->belongsTo(Patron::class, 'customer_id');
    }
    public function contacts()
    {
        return $this->belongsToMany(
            Contact::class,
            'patron_contacts',
            'patron_id',
            'contact_id',
            'customer_id',
            'id'
        );
    }

    public function entity()
    {
        return $this->belongsTo(Entity::class, 'entity_id');
    }
    public function personal()
    {
        return $this->belongsTo(Personnel::class, 'service_by');
    }
    public function type()
    {
        return $this->belongsTo(ServiceType::class, 'service_type');
    }
    public function leadBy(){
        return $this->hasOne(PatronPersonalRel::class, 'customer_id', 'patron_id');
    }
}
