<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UpdateUserPasswordRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Response;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('id', 'desc')->get();
        $totalUsers = User::count();

        return response()->json([
            'data' => UserResource::collection($users),
            'total' => $totalUsers
        ]);
    }

    public function getProfesseurs(Request $request)
    {
        $query = User::with(['laboratoire', 'doctorants'])
        ->where('role', 0); // 0 = professeur

        // Vérifiez si un filtre par professeur est demandé
        if ($request->has('prof_id')) {
            $query->where('id', $request->input('prof_id'));
        }

        $professeurs = $query->get()
            ->map(function ($user) {
                return [
                    'nom' => $user->nom,
                    'prenom' => $user->prénom,
                    'laboratoire' => $user->laboratoire ? $user->laboratoire->nom : null,
                    'nombre_doctorants' => $user->doctorants->count(),
                ];
            });

        return response()->json($professeurs);
    }

    public function store(StoreUserRequest $request)
    {
        $user = new User();

        $user->nom = $request->input('nom');
        $user->prénom = $request->input('prénom');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password')); 
        $user->slug = Str::slug($request->input('nom') . ' ' . $request->input('prénom'));
        $user->laboratoire_id = $request->input('laboratoire_id');
        $user->equipe_id = $request->input('equipe_id');
        $user->role = $request->input('role');

        $user->save();

        return new UserResource($user);
    }

    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function update(UpdateUserRequest $request, User $user)
    {        
        $user->nom = $request->input('nom');
        $user->prénom = $request->input('prénom');
        $user->email = $request->input('email');
        $user->slug = Str::slug($request->input('nom') . ' ' . $request->input('prénom'));
        $user->laboratoire_id = $request->input('laboratoire_id');
        $user->equipe_id = $request->input('equipe_id');
        $user->role = $request->input('role');

        $user->save();

        return new UserResource($user);
    }

    public function updatePassword(Request $request, User $user)
    {
        $user->password = bcrypt($request->input('newPassword'));
        $user->save();
        return response()->json([
            'message' => 'Password updated successfully.',
            'user' => new UserResource($user),
        ], Response::HTTP_OK);
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    public function userArticles($id)
    {
        $user = User::findOrFail($id);
        return UserResource::collection($user->articles);
        //return response()->json($user->articles);
    }

    public function userLivres($id)
    {
        $user = User::findOrFail($id);
        return UserResource::collection($user->livres);
        //return response()->json($user->livres);
    }

}
