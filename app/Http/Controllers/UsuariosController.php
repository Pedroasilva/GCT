<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class UsuariosController extends Controller
{
    public function new(Request $request): Response
    {
        return Inertia::render('Usuarios/New', [
            'status' => session('status'),
        ]);
    }

    public function list(Request $request): Response
    {
        return Inertia::render('Usuarios/List', [
            'status' => session('status'),
        ]);
    }
}
