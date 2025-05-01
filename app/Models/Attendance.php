<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table = 'attendance';
    protected $fillable = ['employee_id', 'entity_id','date', 'check_in',
        'check_out','status','created_at','created_by','modified_at',
        'modified_by','deleted_at','deleted_by','deleted'];
    public function entity()
    {
        return $this->belongsTo(Entity::class);
    }
    public function user()
    {
        return $this->belongsTo(Personnel::class);
    }
}
