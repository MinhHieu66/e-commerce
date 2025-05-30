<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provinces extends Model
{
    use HasFactory;

    protected $table = 'provinces';

    protected $fillable = [
        'name',
        'full_name',
        'code_name',
        'adminnistrative_region_id',
        'adminnistrative_unit_id',

    ];

    public function districts()
    {
        return $this->hasMany(Districts::class);
    }
}
