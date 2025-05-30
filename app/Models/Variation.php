<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Variation extends Model
{
    use HasFactory;

    protected $table = 'variations';

    protected $fillable = [
        'category_id',
        'name',
    ];

    public $timestamps = true;

    public function variation_options(): HasMany
    {
        return $this->hasMany(VariationOption::class);
    }
}
