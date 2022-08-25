<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Product extends Model
{
    use HasFactory,HasTranslations;

    public $translatable = ['name','description'];

    protected $fillable = [
        'sku',
        'name',
        "description",
        "price",
        "stock",
        "status",
        "order",
        "category_id",


    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
