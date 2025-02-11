<?php

namespace App\Http\Controllers;

use App\Models\Doctorant;
use App\Models\Laboratoire;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreDoctorantRequest;
use App\Http\Requests\UpdateDoctorantRequest;
use App\Http\Resources\DoctorantResource;
use App\Http\Resources\UserResource;
use Carbon\Carbon;

class DoctorantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $doctorants = Doctorant::with('user')->get();
        return DoctorantResource::collection($doctorants);
    }

    // Obtenir les doctorants d'un professeur
    public function getDoctorants(Request $request)
    {
        if ($request->filled('prof_id')) {
            $doctorants = Doctorant::where('user_id', $request->input('prof_id'))
                ->with('user')
                ->orderBy('created_at', 'desc') // Trier par `created_at` en ordre décroissant
                ->get();
        } else {
            $doctorants = Doctorant::with('user')
                ->orderBy('created_at', 'desc') // Trier par `created_at` en ordre décroissant
                ->get();
        }

        return DoctorantResource::collection($doctorants);
    }

    // Obtenir les doctorants avec filtrage par date de soutenance
    public function getDoctorantsDateSoutenance(Request $request)
    {
        $query = Doctorant::with('user')->orderBy('created_at', 'desc');

        // Filtrer par date_soutenance si fourni
        if ($request->filled('date_soutenance')) {
            $query->whereDate('date_soutenance', $request->input('date_soutenance'));
        }

        $doctorants = $query->get();

        return DoctorantResource::collection($doctorants);
    }

    // Obtenir le laboratoire d'un professeur
    public function getLaboratoire(Request $request)
    {
        $laboratoire = Laboratoire::with('doctorants.user')->find($request->input('id_labo'));

    if (!$laboratoire) {
        return response()->json(['message' => 'Laboratoire non trouvé'], 404);
    }

    return response()->json($laboratoire->doctorants);

        // Charger le professeur avec son laboratoire et ses doctorants
    //$professeur = User::with(['laboratoire', 'doctorants'])->findOrFail($request->input('id_prof'));

    // Retourner la ressource UserResource
    //return new UserResource($professeur);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDoctorantRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(StoreDoctorantRequest $request)
    {
        $doctorant = new Doctorant();
        $doctorant->CIN = $request->input('CIN');
        $doctorant->APOGEE = $request->input('APOGEE');
        $doctorant->NOM = $request->input('NOM');
        $doctorant->PRENOM = $request->input('PRENOM');
        $doctorant->date_inscription = Carbon::createFromFormat('Y-m-d', $request->input('date_inscription'))->format('Y-m-d');
        $doctorant->nationalite = $request->input('nationalite', 'marocaine'); 
        if ($request->has('date_soutenance')) {
            $doctorant->date_soutenance = Carbon::createFromFormat('Y-m-d', $request->input('date_soutenance'))->format('Y-m-d');
        }
        $doctorant->sujet_these = $request->input('sujet_these');
        $doctorant->user_id = $request->input('user_id');
        $doctorant->save();
        return new DoctorantResource($doctorant);
    }

    public function storeAdmin(StoreDoctorantRequest $request)
    {
        $doctorant = new Doctorant();
        $doctorant->CIN = $request->input('CIN');
        $doctorant->APOGEE = $request->input('APOGEE');
        $doctorant->NOM = $request->input('NOM');
        $doctorant->PRENOM = $request->input('PRENOM');
        $doctorant->date_inscription = Carbon::createFromFormat('Y-m-d', $request->input('date_inscription'))->format('Y-m-d');
        $doctorant->nationalite = $request->input('nationalite', 'marocaine'); 
        if ($request->has('date_soutenance')) {
            $doctorant->date_soutenance = Carbon::createFromFormat('Y-m-d', $request->input('date_soutenance'))->format('Y-m-d');
        }
        $doctorant->sujet_these = $request->input('sujet_these');
        $doctorant->user_id = $request->input('user_id');
        $doctorant->save();
        return new DoctorantResource($doctorant);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Doctorant  $doctorant
     * @return \Illuminate\Http\Response
     */
    public function show(Doctorant $doctorant)
    {
        return new DoctorantResource($doctorant);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDoctorantRequest  $request
     * @param  \App\Models\Doctorant  $doctorant
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDoctorantRequest $request, Doctorant $doctorant)
    {
        $doctorant->CIN = $request->input('CIN');
        $doctorant->APOGEE = $request->input('APOGEE');
        $doctorant->NOM = $request->input('NOM');
        $doctorant->PRENOM = $request->input('PRENOM');
        $doctorant->date_inscription = Carbon::createFromFormat('Y-m-d', $request->input('date_inscription'))->format('Y-m-d');
        $doctorant->nationalite = $request->input('nationalite', 'marocaine'); 
        if ($request->has('date_soutenance')) {
            $doctorant->date_soutenance = Carbon::createFromFormat('Y-m-d', $request->input('date_soutenance'))->format('Y-m-d');
        }
        $doctorant->sujet_these = $request->input('sujet_these');
        $doctorant->user_id = $request->input('user_id');
        $doctorant->save();
        return new DoctorantResource($doctorant);
    }

    public function updateAdmin(UpdateDoctorantRequest $request, Doctorant $doctorant)
    {
        $doctorant->CIN = $request->input('CIN');
        $doctorant->APOGEE = $request->input('APOGEE');
        $doctorant->NOM = $request->input('NOM');
        $doctorant->PRENOM = $request->input('PRENOM');
        $doctorant->date_inscription = Carbon::createFromFormat('Y-m-d', $request->input('date_inscription'))->format('Y-m-d');
        $doctorant->nationalite = $request->input('nationalite', 'marocaine'); 
        if ($request->has('date_soutenance')) {
            $doctorant->date_soutenance = Carbon::createFromFormat('Y-m-d', $request->input('date_soutenance'))->format('Y-m-d');
        }
        $doctorant->sujet_these = $request->input('sujet_these');
        $doctorant->user_id = $request->input('user_id');
        $doctorant->save();
        return new DoctorantResource($doctorant);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Doctorant  $doctorant
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctorant $doctorant)
    {
        $doctorant->delete();
        return response()->noContent();
    }
}
