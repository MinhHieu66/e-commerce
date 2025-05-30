<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Districts extends Model
{
    use HasFactory;

    protected $table = 'districts';

    protected $fillable = [
        'name',
        'full_name',
        'code_name',
        'province_id',
        'adminnistrative_unit_id',
    ];

    public function provinces()
    {
        return $this->belongsTo(Provinces::class);
    }

    public function wards()
    {
        return $this->hasMany(Wards::class);
    }
}
