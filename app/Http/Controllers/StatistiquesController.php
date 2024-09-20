<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laboratoire;
use App\Models\Equipe;
use DB;
use Carbon\Carbon;


class StatistiquesController extends Controller
{
    public function usersParLaboratoire()
    {
        $resultats = Laboratoire::withCount('users')->get();

        return response()->json($resultats);
    }

    public function usersParLaboratoireYear()
    {
        $currentYear = Carbon::now()->year;

        $resultats = Laboratoire::whereYear('created_at', $currentYear)
            ->withCount('users')
            ->get();

        return response()->json($resultats);
    }

    public function usersParEquipe()
    {
        $resultats = Equipe::withCount('users')->get();

        return response()->json($resultats);
    }

    public function usersParEquipeYear()
    {
        $currentYear = Carbon::now()->year;

        $resultats = Equipe::whereYear('created_at', $currentYear)
            ->withCount('users')
            ->get();

        return response()->json($resultats);
    }

   /* public function getData(Request $request)
{
    $queryArticles = DB::table('articles')
        ->join('users', 'articles.user_id', '=', 'users.id')
        ->select(DB::raw('count(articles.id) as nombre_articles, users.id, users.nom, users.prénom'))
        ->whereNull('articles.deleted_at')
        ->groupBy('users.id', 'users.nom', 'users.prénom');

    $queryLivres = DB::table('livres')
        ->join('users', 'livres.user_id', '=', 'users.id')
        ->select(DB::raw('count(livres.id) as nombre_livres, users.id, users.nom, users.prénom'))
        ->whereNull('livres.deleted_at')
        ->groupBy('users.id', 'users.nom', 'users.prénom');

    // Appliquer le filtre par année si le paramètre 'annee' est fourni
    if ($request->filled('annee')) {
        $annee = $request->input('annee');
        $queryArticles->where('articles.annee', $annee);
        $queryLivres->where('livres.annee', $annee);
    }

    // Exécuter les requêtes
    $articlesParUtilisateur = $queryArticles->get();
    $livresParUtilisateur = $queryLivres->get();

    // Fusionner les résultats
    $result = [];
    foreach ($articlesParUtilisateur as $article) {
        $result[$article->id] = [
            'name' => $article->prénom . ' ' . $article->nom,
            'uv' => $article->nombre_articles,
            'pv' => 0, // Valeur par défaut
            'amt' => 0 // Valeur par défaut, vous pouvez ajuster cela selon vos besoins
        ];
    }

    foreach ($livresParUtilisateur as $livre) {
        if (isset($result[$livre->id])) {
            $result[$livre->id]['pv'] = $livre->nombre_livres;
        } else {
            $result[$livre->id] = [
                'name' => $livre->prénom . ' ' . $livre->nom,
                'uv' => 0, // Valeur par défaut
                'pv' => $livre->nombre_livres,
                'amt' => 0 // Valeur par défaut, vous pouvez ajuster cela selon vos besoins
            ];
        }
    }

    // Reformatage du résultat final
    $formattedResult = array_values($result);

    // Trier les résultats (par exemple, par le nombre d'articles 'uv')
    usort($formattedResult, function($a, $b) {
        return $b['uv'] - $a['uv']; // Tri descendant par 'uv'
    });

    // Limiter aux 10 premiers résultats
    $top10Result = array_slice($formattedResult, 0, 8);

    return response()->json($top10Result);
}*/
public function getDataEquipe(Request $request)
{
    $queryArticles = DB::table('articles')
        ->join('users', 'articles.user_id', '=', 'users.id')
        ->join('equipes', 'users.equipe_id', '=', 'equipes.id')
        ->select(DB::raw('count(articles.id) as uv, equipes.id as equipe_id, equipes.nom as name'))
        ->whereNull('articles.deleted_at')
        ->groupBy('equipes.id', 'equipes.nom');

    $queryLivres = DB::table('livres')
        ->join('users', 'livres.user_id', '=', 'users.id')
        ->join('equipes', 'users.equipe_id', '=', 'equipes.id')
        ->select(DB::raw('count(livres.id) as pv, equipes.id as equipe_id, equipes.nom as name'))
        ->whereNull('livres.deleted_at')
        ->groupBy('equipes.id', 'equipes.nom');

    // Appliquer le filtre par année si le paramètre 'annee' est fourni
    if ($request->filled('annee')) {
        $annee = $request->input('annee');
        $queryArticles->where('articles.annee', $annee);
        $queryLivres->where('livres.annee', $annee);
    }

    // Exécuter les requêtes
    $articlesParEquipe = $queryArticles->get();
    $livresParEquipe = $queryLivres->get();

    // Fusionner les résultats
    $result = [];
    foreach ($articlesParEquipe as $article) {
        $result[$article->equipe_id] = [
            'name' => $article->name,
            'uv' => $article->uv,
            'pv' => 0 // Valeur par défaut
        ];
    }

    foreach ($livresParEquipe as $livre) {
        if (isset($result[$livre->equipe_id])) {
            $result[$livre->equipe_id]['pv'] = $livre->pv;
        } else {
            $result[$livre->equipe_id] = [
                'name' => $livre->name,
                'uv' => 0, // Valeur par défaut
                'pv' => $livre->pv
            ];
        }
    }

    // Reformatage du résultat final
    $formattedResult = array_values($result);

    // Trier les résultats (par exemple, par le nombre d'articles 'uv')
    //usort($formattedResult, function($a, $b) {
        //return $b['uv'] - $a['uv']; // Tri descendant par 'uv'
    //});

    // Limiter aux 8 premiers résultats
    //$top8Result = array_slice($formattedResult, 0, 8);

    return response()->json($formattedResult);
}

public function getDataLabo(Request $request)
{
    $queryArticles = DB::table('articles')
        ->join('users', 'articles.user_id', '=', 'users.id')
        ->join('laboratoires', 'users.laboratoire_id', '=', 'laboratoires.id')
        ->select(DB::raw('count(articles.id) as uv, laboratoires.id as laboratoire_id, laboratoires.nom as name'))
        ->whereNull('articles.deleted_at')
        ->groupBy('laboratoires.id', 'laboratoires.nom');

    $queryLivres = DB::table('livres')
        ->join('users', 'livres.user_id', '=', 'users.id')
        ->join('laboratoires', 'users.laboratoire_id', '=', 'laboratoires.id')
        ->select(DB::raw('count(livres.id) as pv, laboratoires.id as laboratoire_id, laboratoires.nom as name'))
        ->whereNull('livres.deleted_at')
        ->groupBy('laboratoires.id', 'laboratoires.nom');

    // Appliquer le filtre par année si le paramètre 'annee' est fourni
    if ($request->filled('annee')) {
        $annee = $request->input('annee');
        $queryArticles->where('articles.annee', $annee);
        $queryLivres->where('livres.annee', $annee);
    }

    // Exécuter les requêtes
    $articlesParLaboratoire = $queryArticles->get();
    $livresParLaboratoire = $queryLivres->get();

    // Fusionner les résultats
    $result = [];
    foreach ($articlesParLaboratoire as $article) {
        $result[$article->laboratoire_id] = [
            'name' => $article->name,
            'uv' => $article->uv,
            'pv' => 0 // Valeur par défaut
        ];
    }

    foreach ($livresParLaboratoire as $livre) {
        if (isset($result[$livre->laboratoire_id])) {
            $result[$livre->laboratoire_id]['pv'] = $livre->pv;
        } else {
            $result[$livre->laboratoire_id] = [
                'name' => $livre->name,
                'uv' => 0, // Valeur par défaut
                'pv' => $livre->pv
            ];
        }
    }

    // Reformatage du résultat final
    $formattedResult = array_values($result);

    // Trier les résultats (par exemple, par le nombre d'articles 'uv')
    //usort($formattedResult, function($a, $b) {
      //  return $b['uv'] - $a['uv']; // Tri descendant par 'uv'
    //});

    // Limiter aux 8 premiers résultats
    //$top8Result = array_slice($formattedResult, 0, 8);

    return response()->json($formattedResult);
}






}
