<?php

namespace App\Http\Controllers;

use App\Models\Livre;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLivreRequest;
use App\Http\Requests\UpdateLivreRequest;
use App\Http\Resources\LivreResource;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class LivreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $livres = Livre::orderBy('annee', 'desc')->orderBy('id', 'desc')->get();
    $totalLivres = Livre::count();

    return response()->json([
        'data' => LivreResource::collection($livres),
        'total' => $totalLivres
    ]);
    }

    public function indexLivres(Request $request)
    {
        $livres_auth = Livre::where('user_id', auth()->id())->orderBy('annee', 'desc')->orderBy('id', 'desc')->get();
        return LivreResource::collection($livres_auth);
    }

    public function indexLivresUser($id)
    {
        $livres_auth = Livre::where('user_id', $id)->orderBy('annee', 'desc')->orderBy('id', 'desc')->get();
        return LivreResource::collection($livres_auth);
    }

    public function getLivresByEquipe($id)
    {
        $livres = Livre::whereHas('user', function($query) use ($id) {
            $query->where('equipe_id', $id);
        })->with('user')->orderBy('annee', 'desc')->orderBy('id', 'desc')->get();

        $total = $livres->count();

        return response()->json([
            'data' => LivreResource::collection($livres),
            'total' => $total
        ]);
    
    }

    public function getLivresByLaboratoire($id)
    {
        $livres = Livre::whereHas('user', function($query) use ($id) {
            $query->where('laboratoire_id', $id);
        })->with('user')->orderBy('annee', 'desc')->orderBy('id', 'desc')->get();

        $total = $livres->count();

        return response()->json([
            'data' => LivreResource::collection($livres),
            'total' => $total
        ]);
    
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLivreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLivreRequest $request)
    {
        $livre = new Livre();

        $livre->titre = $request->input('titre');
        $livre->isbn = $request->input('isbn');
        $livre->depot_legal = $request->input('depot_legal');
        $livre->issn = $request->input('issn');
        $livre->annee = $request->input('annee');
        $livre->slug = Str::slug($request->input('titre') . ' ' . $request->input('isbn'));
        $livre->user_id = auth()->id();

        $livre->save();

        return new LivreResource($livre);
    }

    public function storeAdmin(StoreLivreRequest $request)
    {
        $livre = new Livre();

        $livre->titre = $request->input('titre');
        $livre->isbn = $request->input('isbn');
        $livre->depot_legal = $request->input('depot_legal');
        $livre->issn = $request->input('issn');
        $livre->annee = $request->input('annee');
        $livre->slug = Str::slug($request->input('titre') . ' ' . $request->input('isbn'));
        $livre->user_id = $request->input('user_id');

        $livre->save();

        return new LivreResource($livre);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Livre  $livre
     * @return \Illuminate\Http\Response
     */
    public function show(Livre $livre)
    {
        return new LivreResource($livre);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLivreRequest  $request
     * @param  \App\Models\Livre  $livre
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLivreRequest $request, Livre $livre)
    {
        $livre->titre = $request->input('titre');
        $livre->isbn = $request->input('isbn');
        $livre->depot_legal = $request->input('depot_legal');
        $livre->issn = $request->input('issn');
        $livre->annee = $request->input('annee');
        $livre->slug = Str::slug($request->input('titre') . ' ' . $request->input('isbn'));
        $livre->user_id = auth()->id();

        $livre->save();

        return new LivreResource($livre);
    }

    public function updateAdmin(UpdateLivreRequest $request, Livre $livre)
    {
        $livre->titre = $request->input('titre');
        $livre->isbn = $request->input('isbn');
        $livre->depot_legal = $request->input('depot_legal');
        $livre->issn = $request->input('issn');
        $livre->annee = $request->input('annee');
        $livre->slug = Str::slug($request->input('titre') . ' ' . $request->input('isbn'));
        $livre->user_id = $request->input('user_id');

        $livre->save();

        return new LivreResource($livre);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Livre  $livre
     * @return \Illuminate\Http\Response
     */
    public function destroy(Livre $livre)
    {
        $livre->delete();
        return response()->noContent();
    }
}
