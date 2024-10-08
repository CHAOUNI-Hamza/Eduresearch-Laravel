<?php

namespace App\Http\Controllers;

use App\Models\Doctorant;
use App\Http\Requests\StoreDoctorantRequest;
use App\Http\Requests\UpdateDoctorantRequest;
use App\Http\Resources\DoctorantResource;
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
        $doctorant->date_inscription = Carbon::createFromFormat('d-m-Y', $request->input('date_inscription'))->format('Y-m-d');
        $doctorant->nationalite = $request->input('nationalite', 'marocaine'); 
        if ($request->has('date_soutenance')) {
            $doctorant->date_soutenance = Carbon::createFromFormat('d-m-Y', $request->input('date_soutenance'))->format('Y-m-d');
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
        $doctorant->date_inscription = Carbon::createFromFormat('d-m-Y', $request->input('date_inscription'))->format('Y-m-d');
        $doctorant->nationalite = $request->input('nationalite', 'marocaine'); 
        if ($request->has('date_soutenance')) {
            $doctorant->date_soutenance = Carbon::createFromFormat('d-m-Y', $request->input('date_soutenance'))->format('Y-m-d');
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
        $doctorant->date_inscription = Carbon::createFromFormat('d-m-Y', $request->input('date_inscription'))->format('Y-m-d');
        $doctorant->nationalite = $request->input('nationalite', 'marocaine'); 
        if ($request->has('date_soutenance')) {
            $doctorant->date_soutenance = Carbon::createFromFormat('d-m-Y', $request->input('date_soutenance'))->format('Y-m-d');
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
        $doctorant->date_inscription = Carbon::createFromFormat('d-m-Y', $request->input('date_inscription'))->format('Y-m-d');
        $doctorant->nationalite = $request->input('nationalite', 'marocaine'); 
        if ($request->has('date_soutenance')) {
            $doctorant->date_soutenance = Carbon::createFromFormat('d-m-Y', $request->input('date_soutenance'))->format('Y-m-d');
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
