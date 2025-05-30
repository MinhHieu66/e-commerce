<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotionCategory extends Model
{
    use HasFactory;

    protected $table = 'promotion_categories';

    protected $fillable = [
        'category_id',
        'name',
    ];

    public $timestamps = true;

    public function promotions()
    {
        return $this->belongsTo(Promotion::class);
    }

    public function product_categories()
    {
        return $this->belongsTo(ProductCategory::class, 'parent_category_id');
    }
}