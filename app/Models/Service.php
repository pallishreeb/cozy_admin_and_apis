<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'category_id', 'images', 'price', 'discount',
    ];

    protected $casts = [
        'images' => 'array', // Cast the images field to an array
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
