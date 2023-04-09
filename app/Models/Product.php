<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'price',
        'state',
        'state_description',
        'main_image',
        'image1',
        'image2',
        'image3',
        'image4',
        'user_id',
        'category_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function withUrl()
    {
        $this->main_image = asset('images/' . $this->main_image);
        $this->image1 = asset('images/' . $this->image1);
        $this->image2 = asset('images/' . $this->image2);
        $this->image3 = asset('images/' . $this->image3);
        $this->image4 = asset('images/' . $this->image4);
        return $this;
    }
}
