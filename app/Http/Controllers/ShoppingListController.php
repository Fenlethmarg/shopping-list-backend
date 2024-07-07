<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreShoppingListRequest;
use App\Http\Requests\UpdateShoppingListRequest;
use App\Models\Article;
use App\Models\ShoppingList;
use App\Models\User;
use Illuminate\Http\Client\Request;
class ShoppingListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $shoppingLists = ShoppingList::with('articles')->get();
        return response()->json($shoppingLists);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ShoppingList  $shoppingList
     * @return \Illuminate\Http\Response
     */
    public function show(ShoppingList $shoppingList)
    {
        return response()->json($shoppingList->load('articles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreShoppingListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShoppingListRequest $request)
    {
        $shoppingList = ShoppingList::create([
            'user_id' => $request->user_id,
        ]);

        foreach ($request->articles as $article) {
            $shoppingList->articles()->attach($article['article_id'], ['quantity' => $article['quantity']]);
        }

        return response()->json($shoppingList->load('articles'), 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateShoppingListRequest  $request
     * @param  \App\Models\ShoppingList  $shoppingList
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShoppingListRequest $request, ShoppingList $shoppingList)
    {

        // Actualizar artículos: eliminar los antiguos y agregar los nuevos
        $shoppingList->articles()->detach();
        foreach ($request->articles as $article) {
            $shoppingList->articles()->attach($article['article_id'], ['quantity' => $article['quantity']]);
        }

        return response()->json($shoppingList->load('articles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ShoppingList  $shoppingList
     * @return \Illuminate\Http\Response
     */
    public function destroy(ShoppingList $shoppingList)
    {
        $shoppingList->delete();
        return response()->json(null, 204);
    }

    /**
     * Add an article with quantity to the specified shopping list.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ShoppingList  $shoppingList
     * @return \Illuminate\Http\Response
     */
    public function addArticle(Request $request, ShoppingList $shoppingList)
    {
        $request->validate([
            'article_id' => 'required|exists:articles,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $article = Article::findOrFail($request->article_id);

        $shoppingList->articles()->attach($article->id, ['quantity' => $request->quantity]);

        return response()->json($shoppingList->load('articles'));
    }
}
