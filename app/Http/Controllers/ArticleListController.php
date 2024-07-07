<?php

namespace App\Http\Controllers;

use App\Models\ArticleList;
use App\Http\Requests\StoreArticleListRequest;
use App\Http\Requests\UpdateArticleListRequest;

class ArticleListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $articleLists = ArticleList::with('articles')->get();
        return response()->json($articleLists);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleListRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleListRequest $request)
    {
        $articleList = ArticleList::create([
            'user_id' => $request->user_id,
        ]);

        $articleList->articles()->attach($request->articles);

        return response()->json($articleList->load('articles'), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ArticleList  $articleList
     * @return \Illuminate\Http\Response
     */
    public function show(ArticleList $articleList)
    {
        return response()->json($articleList->load('articles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleListRequest  $request
     * @param  \App\Models\ArticleList  $articleList
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleListRequest $request, ArticleList $articleList)
    {
        $articleList->update([
            'user_id' => $request->user_id,
        ]);

        $articleList->articles()->sync($request->articles);

        return response()->json($articleList->load('articles'));
    }
}