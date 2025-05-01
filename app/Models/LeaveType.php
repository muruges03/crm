<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    protected $table = 'leave_types';
    use HasFactory;

    protected $fillable = ['entity_id', 'name', 'day_allowed', 'remaining_leave_days','status'];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function leave()
    {
        return $this->belongsTo(Leave::class);
    }

}
