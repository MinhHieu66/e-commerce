<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Promotion extends Model
{
    use HasFactory;

    protected $table = 'promotions';

    protected $fillable = [
        'name',
        'description',
        'discount_rate',
        'start_date',
        'end_date',
    ];

    public $timestamps = true;

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(ProductCategory::class, 'promotion_categories', 'promotion_id', 'category_id');
    }
}