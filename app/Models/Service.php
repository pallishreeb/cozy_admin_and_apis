<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = [
        'name', 'category_id', 'image', 'price', 'discount',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
