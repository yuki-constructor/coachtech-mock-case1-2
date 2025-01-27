<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'item_name',
        'item_image',
        'brand',
        'price',
        'description'
    ];

    // Itemは多対多の関係でCategoryと関連
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'categories_items');
    }

    // Itemは多対多の関係でConditionと関連
    public function conditions()
    {
        return $this->belongsToMany(Condition::class, 'conditions_items');
    }

    // Itemは1対多の関係でPurchaseと関連
    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }
}
