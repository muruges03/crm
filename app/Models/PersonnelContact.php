<?php



namespace App\Models;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PersonnelContact extends Model
{
	protected $table = 'personnel_contacts';
	public $incrementing = false;
	public $timestamps = false;
    use HasFactory;
	protected $casts = [
		'contact_id' => 'int',
		'personnel_id' => 'int'
	];

	protected $fillable = [
		'contact_id',
		'personnel_id'
	];

	public function contact()
	{
		return $this->belongsTo(Contact::class);
	}

	public function personnel()
	{
		return $this->belongsTo(Personnel::class);
	}
}
