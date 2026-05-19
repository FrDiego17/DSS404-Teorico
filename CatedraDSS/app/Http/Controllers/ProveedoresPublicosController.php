<?php

namespace App\Http\Controllers;

use App\Models\Comercio;
use Illuminate\Http\Request;

class ProveedoresPublicosController extends Controller
{
    /* Listado de proveedores registrados */
    public function index()
    {
        $proveedores = Comercio::all(); 

        return view('proveedores', compact('proveedores'));
    }
}