<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProductItem extends Model
{
    use HasFactory;

    protected $table = 'product_items';

    protected $fillable = [
        'product_id',
        'SKU',
        'qty_in_stock',
        'product_image',
        'price',

    ];

    public $timestamps = true;

    public function products(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function variation_options(): BelongsToMany
    {
        return $this->belongsToMany(VariationOption::class, 'product_configurations', 'product_item_id', 'variation_option_id');
    }

    public function product_configurations(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
