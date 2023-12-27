<?php

namespace App\Models;

use App\Models\Category;
use App\Models\ProductDetail;
use App\Traits\HandleImageTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, HandleImageTrait;
    protected $fillable = [
        'name',
        'description',
        'sale',
        'price',
    ];
    public function details(){
        return $this->hasMany(ProductDetail::class);
    }
    public function images(){
        return $this->morphMany(Image::class, 'imageable');
    }
    public function categories(){
        return $this->belongsToMany(Category::class);
    }
    public function getBy($data, $categoryId){
        return $this->whereHas('categories', fn($q)=>$q->where('category_id', $categoryId))->paginate(6);
    }
    public function getByPriceRange($categoryId, $minPrice, $maxPrice)
    {
        $query = $this->categories->where('category_id', $categoryId);

        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }

        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query->get();
    }
}
