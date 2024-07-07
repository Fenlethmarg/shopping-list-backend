<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShoppingListDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'shopping_list_id',
        'quantity',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    public function shoppingList()
    {
        return $this->belongsTo(ShoppingList::class);
    }
}