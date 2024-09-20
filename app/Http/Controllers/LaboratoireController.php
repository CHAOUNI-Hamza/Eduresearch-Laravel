<?php

namespace App\Http\Controllers;

use App\Models\Laboratoire;
use App\Http\Requests\StoreLaboratoireRequest;
use App\Http\Requests\UpdateLaboratoireRequest;
use App\Http\Resources\LaboratoireResource;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use App\Http\Resources\EquipeResource;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class LaboratoireController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laboratoires = Laboratoire::orderBy('id', 'desc')->get();
    $totalLaboratoires = Laboratoire::count();

    return response()->json([
        'data' => LaboratoireResource::collection($laboratoires),
        'total' => $totalLaboratoires
    ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLaboratoireRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreLaboratoireRequest $request)
    {
        $laboratoire = new Laboratoire();

        $laboratoire->nom = $request->input('nom');
        $laboratoire->slug = Str::slug($request->input('nom'));

        $laboratoire->save();

        return new LaboratoireResource($laboratoire);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Laboratoire  $laboratoire
     * @return \Illuminate\Http\Response
     */
    public function show(Laboratoire $laboratoire)
    {
        return new LaboratoireResource($laboratoire);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateLaboratoireRequest  $request
     * @param  \App\Models\Laboratoire  $laboratoire
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateLaboratoireRequest $request, Laboratoire $laboratoire)
    {
        $laboratoire->nom = $request->input('nom');
        $laboratoire->slug = Str::slug($request->input('nom'));

        $laboratoire->save();

        return new LaboratoireResource($laboratoire);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Laboratoire  $laboratoire
     * @return \Illuminate\Http\Response
     */
    public function destroy(Laboratoire $laboratoire)
    {
        $laboratoire->delete();
        return response()->noContent();
    }

    public function laboratoireEquipes($id)
    {
        $laboratoire = Laboratoire::findOrFail($id);
        return response()->json($laboratoire->equipes);
    }

    /*public function laboratoireUsers($id)
    {
        $laboratoire = Laboratoire::findOrFail($id);
        $users = $laboratoire->users()->orderBy('id', 'desc')->get();
        $total = $users->count();
        return response()->json([
            'data' => UserResource::collection($users),
            'total' => $total
        ]);
    }*/
    public function laboratoireUsers($id, Request $request)
{
    $laboratoire = Laboratoire::findOrFail($id);
    $usersQuery = $laboratoire->users()->orderBy('id', 'desc');
    
    if ($request->filled('equipe_id')) {
        $usersQuery->where('equipe_id', $request->equipe_id);
    }
    
    $users = $usersQuery->get();
    $total = $users->count();
    
    return response()->json([
        'data' => UserResource::collection($users),
        'total' => $total
    ]);
}



    public function getUsersByLaboratoire($laboratoireId)
    {
        $laboratoire = Laboratoire::with(['users.articles', 'users.livres'])
                                  ->findOrFail($laboratoireId);

        return response()->json($laboratoire);
    }

    public function getUsersByLaboratoireAndYear($laboratoireId, $year)
    {
        $laboratoire = Laboratoire::with(['users' => function ($query) use ($year) {
            $query->whereHas('articles', function ($query) use ($year) {
                $query->where('annee', $year);
            })->orWhereHas('livres', function ($query) use ($year) {
                $query->where('annee', $year);
            });
        }, 'users.articles' => function ($query) use ($year) {
            $query->where('annee', $year);
        }, 'users.livres' => function ($query) use ($year) {
            $query->where('annee', $year);
        }])->findOrFail($laboratoireId);

        return response()->json($laboratoire);
    }

    public function getEquipesByLaboratoireId($laboratoireId)
    {
        // Trouver le laboratoire par son ID
        $laboratoire = Laboratoire::findOrFail($laboratoireId);

        // Obtenir les équipes associées au laboratoire
        $equipes = $laboratoire->equipes;

        // Calculer le nombre total d'équipes
        $totalEquipes = $equipes->count();

        // Retourner les équipes sous forme de JSON (ou comme vous le souhaitez)
        return response()->json([
            'equipes' => EquipeResource::collection($equipes),
            'data' => $equipes,
            'total' => $totalEquipes,
        ]);
    }

}
