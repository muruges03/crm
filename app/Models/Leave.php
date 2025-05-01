<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leave extends Model
{
    protected $table = 'leaves';
    use HasFactory;

    protected $fillable = ['employee_id','entity_id', 'start_date', 'end_date', 'leave_type_id', 'reason', 'leave_status','status','created_at','created_by','modified_at','updated_at',
        'updated_by','deleted_at','deleted_by','deleted'];

    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
