<?php

namespace App\Http\Controllers;

use App\Models\Equipe;
use App\Models\User;
use App\Http\Requests\StoreEquipeRequest;
use App\Http\Requests\UpdateEquipeRequest;
use App\Http\Resources\EquipeResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Str;

class EquipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $equipes = Equipe::orderBy('id', 'desc')->get();
    $totalEquipes = Equipe::count();

    return response()->json([
        'data' => EquipeResource::collection($equipes),
        'total' => $totalEquipes
    ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEquipeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEquipeRequest $request)
    {
        $equipe = new Equipe();

        $equipe->nom = $request->input('nom');
        $equipe->slug = Str::slug($request->input('nom'));
        $equipe->laboratoire_id = $request->input('laboratoire_id');

        $equipe->save();

        return new EquipeResource($equipe);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Equipe  $equipe
     * @return \Illuminate\Http\Response
     */
    public function show(Equipe $equipe)
    {
        return new EquipeResource($equipe);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEquipeRequest  $request
     * @param  \App\Models\Equipe  $equipe
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEquipeRequest $request, Equipe $equipe)
    {
        $equipe->nom = $request->input('nom');
        $equipe->slug = Str::slug($request->input('nom'));
        $equipe->laboratoire_id = $request->input('laboratoire_id');

        $equipe->save();

        return new EquipeResource($equipe);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Equipe  $equipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Equipe $equipe)
    {
        $equipe->delete();
        return response()->noContent();
    }

    public function equipeUsers($id)
    {
        $equipe = Equipe::findOrFail($id);
        $users = $equipe->users()->orderBy('id', 'desc')->get();
        //return UserResource::collection($users);

        $total = $users->count();

        return response()->json([
            'data' => UserResource::collection($users),
            'total' => $total
        ]);
    }

    public function getUsersByEquipe($equipeId)
    {
        $equipe = Equipe::with(['users.articles', 'users.livres'])
                                  ->findOrFail($equipeId);

        return response()->json($equipe);
    }

    public function getUsersByEquipeAndYear($equipeId, $year)
    {
        $equipe = Equipe::with(['users' => function ($query) use ($year) {
            $query->whereHas('articles', function ($query) use ($year) {
                $query->where('annee', $year);
            })->orWhereHas('livres', function ($query) use ($year) {
                $query->where('annee', $year);
            });
        }, 'users.articles' => function ($query) use ($year) {
            $query->where('annee', $year);
        }, 'users.livres' => function ($query) use ($year) {
            $query->where('annee', $year);
        }])->findOrFail($equipeId);

        return response()->json($equipe);
    }

    public function getTotalLaboratoiresByEquipe($equipeId)
    {
        // Récupérer tous les utilisateurs ayant le `equipe_id` spécifié
        $users = User::where('equipe_id', $equipeId)->get();

        // Récupérer les ID de laboratoires uniques
        $laboratoireIds = $users->pluck('laboratoire_id')->unique();

        // Compter le nombre de laboratoires uniques
        $totalLaboratoires = $laboratoireIds->count();

        return response()->json([
            'total' => $totalLaboratoires
        ]);
    }
}
