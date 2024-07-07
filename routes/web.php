<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShoppingListController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Rutas para ShoppingList
Route::resource('shopping-lists', ShoppingListController::class);
Route::post('/shopping-lists/{shoppingList}/add-article', [ShoppingListController::class, 'addArticle'])->name('shopping-lists.add-article');

// Rutas para Article
Route::resource('articles', ArticleController::class);

// Rutas para ArticleList
Route::resource('article-lists', ArticleListController::class);
