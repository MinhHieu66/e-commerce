<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'parent_category_id',
        'category_name',
    ];

    public $timestamps = true;

    public function product_categories(): BelongsToMany
    {
        // return $this->belongsToMany(ProductCategory::class, 'category_product', 'product_id', 'category_id');
        return $this->belongsToMany(ProductCategory::class);
    }

    public function product_items(): HasMany
    {
        return $this->HasMany(ProductItem::class, 'product_id');
    }

}
