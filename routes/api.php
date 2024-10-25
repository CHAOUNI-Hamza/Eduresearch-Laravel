<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LaboratoireController;
use App\Http\Controllers\EquipeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\LivreController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\StatistiquesController;
use App\Http\Controllers\DoctorantController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', 'App\Http\Controllers\AuthController@login');
    Route::post('logout', 'App\Http\Controllers\AuthController@logout');
    Route::post('refresh', 'App\Http\Controllers\AuthController@refresh');
    Route::post('me', 'App\Http\Controllers\AuthController@me');

});


Route::apiResource('laboratoires', LaboratoireController::class);

Route::apiResource('equipes', EquipeController::class);
Route::get('/total-laboratoires/{equipeId}', [EquipeController::class, 'getTotalLaboratoiresByEquipe']);

Route::apiResource('users', UserController::class);
Route::put('users/{user}/password', [UserController::class, 'updatePassword']);

Route::apiResource('livres', LivreController::class);
Route::post('admin/livres', [LivreController::class, 'storeAdmin']);
Route::put('admin/livres/{livre}', [LivreController::class, 'updateAdmin']);

Route::apiResource('articles', ArticleController::class);
Route::post('admin/articles', [ArticleController::class, 'storeAdmin']);
Route::put('admin/articles/{article}', [ArticleController::class, 'updateAdmin']);

Route::apiResource('doctorants', DoctorantController::class);
Route::post('admin/doctorants', [DoctorantController::class, 'storeAdmin']);
Route::put('admin/doctorants/{livre}', [DoctorantController::class, 'updateAdmin']);
// Route pour obtenir les doctorants d'un professeur
Route::get('admin/professor/doctorants', [DoctorantController::class, 'getDoctorants']);

// Route pour obtenir le laboratoire d'un professeur
Route::get('admin/professor/laboratoire', [DoctorantController::class, 'getLaboratoire']);


// Routes avancées
Route::get('users/{id}/articles', [UserController::class, 'userArticles']);
Route::get('users/{id}/livres', [UserController::class, 'userLivres']);
Route::get('laboratoires/{id}/equipes', [LaboratoireController::class, 'laboratoireEquipes']);
Route::get('laboratoires/{id}/users', [LaboratoireController::class, 'laboratoireUsers']);
Route::get('equipes/{id}/users', [EquipeController::class, 'equipeUsers']);
Route::get('art', [ArticleController::class, 'indexArticles']);
Route::get('articles/users/{id}/chef', [ArticleController::class, 'indexArticlesUser']);
Route::get('liv', [LivreController::class, 'indexLivres']);
Route::get('livres/users/{id}/chef', [LivreController::class, 'indexLivresUser']);
Route::get('laboratoires/{id}/users/labo', [LaboratoireController::class, 'getUsersByLaboratoire']);
Route::get('laboratoires/{id}/users/year/{year}', [LaboratoireController::class, 'getUsersByLaboratoireAndYear']);
Route::get('equipes/{id}/users/labo', [EquipeController::class, 'getUsersByEquipe']);
Route::get('equipes/{id}/users/year/{year}', [EquipeController::class, 'getUsersByEquipeAndYear']);
Route::get('/statistiques/users-par-laboratoire', [StatistiquesController::class, 'usersParLaboratoire']);
Route::get('/statistiques/users-par-laboratoire-year', [StatistiquesController::class, 'usersParLaboratoireYear']);
Route::get('/statistiques/users-par-equipe', [StatistiquesController::class, 'usersParEquipe']);
Route::get('/statistiques/users-par-equipe-year', [StatistiquesController::class, 'usersParEquipeYear']);
Route::get('/chart-data-equipe', [StatistiquesController::class, 'getDataEquipe']);
Route::get('/chart-data-labo', [StatistiquesController::class, 'getDataLabo']);

Route::get('articles/equipe/{id}', [ArticleController::class, 'getArticlesByEquipe']);
Route::get('articles/laboratoire/{id}', [ArticleController::class, 'getArticlesByLaboratoire']);

Route::get('livres/equipe/{id}', [LivreController::class, 'getLivresByEquipe']);
Route::get('livres/laboratoire/{id}', [LivreController::class, 'getLivresByLaboratoire']);

Route::get('/laboratoire/{id}/equipes', [LaboratoireController::class, 'getEquipesByLaboratoireId']);





