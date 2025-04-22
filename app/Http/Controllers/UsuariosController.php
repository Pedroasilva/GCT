<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response as HttpResponse;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controller;

class UsuariosController extends Controller
{
    public function new(): Response
    {
        return Inertia::render('Users/New', [
            'status' => session('status'),
            'roles' => Role::all()->pluck('name')->toArray(),
        ]);
    }

    public function list(): Response
    {
        $users = User::withTrashed()->with('roles')->get()->map(function ($user) {
            return [
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->getRoleNames()->first(),
            'deleted_at' => $user->deleted_at,
            ];
        });

        return Inertia::render('Users/List', [
            'status' => session('status'),
            'users' => $users
        ]);
    }

    public function store(Request $request): RedirectResponse|Response
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role' => 'required|string|exists:roles,name',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->assignRole($request->role);

        return Redirect::route('users.new');
    }

    public function show(User $user): JsonResponse
    {
        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->getRoleNames()->first(),
        ]);
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|string|exists:roles,name',
            'password' => 'required|string|min:8',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $user->syncRoles($request->role);

        return Redirect::route('users.list');
    }

    public function destroy(User $user)
    {
        $user->delete();
    }

    public function activate(User $user)
    {
        $user->restore();
    }
}
