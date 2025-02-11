<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Article::query();

        if ($request->filled('annee')) {
            $query->where('annee', $request->input('annee'));
        }

        if ($request->filled('laboratoire_id')) {
            $query->whereHas('user.laboratoire', function($q) use ($request) {
                $q->where('id', $request->input('laboratoire_id'));
            });
        }

        if ($request->filled('equipe_id')) {
            $query->whereHas('user.equipe', function($q) use ($request) {
                $q->where('id', $request->input('equipe_id'));
            });
        }

        $articles = $query->orderBy('annee', 'desc')->orderBy('id', 'desc')->get(); 
        $totalArticles = $query->count();

        return response()->json([
            'data' => ArticleResource::collection($articles),
            'total' => $totalArticles
        ]);
    }

    public function indexArticles()
    {
        $articles_auth = Article::where('user_id', auth()->id())->orderBy('annee', 'desc')->orderBy('id', 'desc')->get();
        return ArticleResource::collection($articles_auth);
    }

    public function indexArticlesUser($id)
    {
        $articles_auth = Article::where('user_id', $id)->orderBy('annee', 'desc')->orderBy('id', 'desc')->get();
        return ArticleResource::collection($articles_auth);
    }

    public function getArticlesByEquipe($id)
    {
        $articles = Article::whereHas('user', function($query) use ($id) {
            $query->where('equipe_id', $id);
        })->with('user')->orderBy('annee', 'desc')->orderBy('id', 'desc')->get();
    
        //return ArticleResource::collection($articles);
        $total = $articles->count();

        return response()->json([
            'data' => ArticleResource::collection($articles),
            'total' => $total
        ]);
    }

    public function getArticlesByLaboratoire($id)
    {
        $articles = Article::whereHas('user', function($query) use ($id) {
            $query->where('laboratoire_id', $id);
        })->with('user')->orderBy('annee', 'desc')->orderBy('id', 'desc')->get();
    
        //return ArticleResource::collection($articles);
        $total = $articles->count();

        return response()->json([
            'data' => ArticleResource::collection($articles),
            'total' => $total
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreArticleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request)
    {
        $article = new Article();

        $article->titre = $request->input('titre');
        $article->revue = $request->input('revue');
        $article->url = $request->input('url');
        $article->annee = $request->input('annee');
        $article->slug = Str::slug($request->input('titre') . ' ' . $request->input('revue'));
        $article->user_id = auth()->id();
        $article->save();

        return new ArticleResource($article);
    }

    public function storeAdmin(StoreArticleRequest $request)
    {
        $article = new Article();

        $article->titre = $request->input('titre');
        $article->revue = $request->input('revue');
        $article->url = $request->input('url');
        $article->annee = $request->input('annee');
        $article->slug = Str::slug($request->input('titre') . ' ' . $request->input('revue'));
        $article->user_id = $request->input('user_id');
        $article->save();

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateArticleRequest  $request
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->titre = $request->input('titre');
        $article->revue = $request->input('revue');
        $article->url = $request->input('url');
        $article->annee = $request->input('annee');
        $article->slug = Str::slug($request->input('titre') . ' ' . $request->input('revue'));
        $article->user_id = auth()->id();
    
        $article->save();
    
        return new ArticleResource($article);
    }

    public function updateAdmin(UpdateArticleRequest $request, Article $article)
    {
        $article->titre = $request->input('titre');
        $article->revue = $request->input('revue');
        $article->url = $request->input('url');
        $article->annee = $request->input('annee');
        $article->slug = Str::slug($request->input('titre') . ' ' . $request->input('revue'));
        $article->user_id = $request->input('user_id');

        $article->save();

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        $article->delete();
        return response()->noContent();
    }
}
