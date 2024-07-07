<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
    ];

    public function details()
    {
        return $this->hasMany(ShoppingListDetail::class);
    }

    public function articleLists()
    {
        return $this->belongsToMany(ArticleList::class, 'article_list_article');
    }
}