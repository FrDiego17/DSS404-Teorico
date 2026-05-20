<?php

namespace App\Http\Controllers;

use App\Models\Organizacion;
use Illuminate\Http\Request;

class OrganizacionesPublicasController extends Controller
{

    public function index()
    {
        $organizaciones = Organizacion::where('estado_verificacion', 'verificada')
            ->whereHas('user', function($query) {
                $query->where('estado', 'activo');
            })->get();

        return view('organizaciones', compact('organizaciones'));
    }
}