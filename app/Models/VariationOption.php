<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VariationOption extends Model
{
    use HasFactory;

    protected $table = 'variation_options';

    protected $fillable = [
        'variation_id',
        'value',
    ];

    public $timestamps = true;

    public function product_configurations(): HasMany
    {
        return $this->hasMany(ProductConfiguration::class, 'variation_option_id');
    }

    public function variations()
    {
        return $this->belongsTo(Variation::class, 'variation_id');
    }
}
