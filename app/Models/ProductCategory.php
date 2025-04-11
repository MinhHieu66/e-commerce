<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductCategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'product_image',

    ];

    public $timestamps = true;

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(Variation::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'parent_id');
    }

    public function promotion_categories(): HasMany
    {
        return $this->hasMany(ProductCategory::class, 'category_id');
    }
}
