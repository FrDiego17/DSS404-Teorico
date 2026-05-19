<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Impacto;

class ImpactoController extends Controller
{
    /* Muestra todas las publicaciones de impacto creadas por ONG */
    public function index()
    {
        $impactosGlobales = Impacto::with('organizacion')->latest()->get();

        return view('impacto', compact('impactosGlobales'));
    }
}