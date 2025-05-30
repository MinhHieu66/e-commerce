<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'product_image',
        'category_id',
    ];

    public $timestamps = true;

    // public function product_categories()
    // {
    //     return $this->hasMany(ProductCategory::class);
    // }

    public function product_categories(): BelongsTo
    {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }

    public function product_items(): HasMany
    {
        return $this->HasMany(ProductItem::class, 'product_id');
    }

}
