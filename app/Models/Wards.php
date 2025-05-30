<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wards extends Model
{
    use HasFactory;

    protected $table = 'wards';

    protected $fillable = [
        'name',
        'full_name',
        'code_name',
        'district_id',
        'adminnistrative_unit_id',
    ];

    public function districts()
    {
        return $this->belongsTo(Districts::class);
    }
}
