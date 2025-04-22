<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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

    public function list(Request $request): Response
    {
        return Inertia::render('Users/List', [
            'status' => session('status'),
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
}
