<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Comercio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Muestra el formulario de login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Procesa el login 
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:8',
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials)) {
            return back()->withErrors([
                'email' => 'Credenciales incorrectas.',
            ])->withInput($request->only('email'));
        }

        $user = Auth::user();

        if ($user->estado === 'pendiente') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Tu cuenta está pendiente de aprobación.',
            ])->withInput($request->only('email'));
        }

        if ($user->estado === 'inactivo') {
            Auth::logout();
            return back()->withErrors([
                'email' => 'Tu cuenta ha sido suspendida por el administrador.',
            ])->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        // Redirige según el rol
        return match ($user->rol) {
            'organizacion' => redirect()->route('ong.dashboard'),
            'comercio'     => redirect()->route('comercio.dashboard'),
            'admin'        => redirect()->route('admin.dashboard'),
            default        => redirect('/'),
        };
    }

    // Cierra la sesión
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    // Muestra el formulario de registro ONG
    public function showRegistroOng()
    {
        return view('ong.registro');
    }

    // Procesa el registro de ONG
    public function registroOng(Request $request)
    {
        $messages = [
            'nombre.required'              => 'El nombre de la organización es obligatorio.',
            'nombre.max'                   => 'El nombre no puede exceder los 255 caracteres.',
            'email.required'               => 'El correo electrónico es obligatorio.',
            'email.email'                  => 'Debes ingresar un correo válido.',
            'email.unique'                 => 'Este correo ya está registrado.',
            'password.required'            => 'La contraseña es obligatoria.',
            'password.min'                 => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'           => 'Las contraseñas no coinciden.',
            'nit.required'                 => 'El NIT es obligatorio.',
            'nit.min'                      => 'El NIT debe tener al menos 14 caracteres.',
            'nit.max'                      => 'El NIT no puede exceder los 20 caracteres.',
            'registro_asociacion.required' => 'El número de registro de asociación es obligatorio.',
            'departamento.required'        => 'Debes seleccionar un departamento.',
            'direccion.required'           => 'La dirección es obligatoria.',
            'capacidad.required'           => 'La capacidad es obligatoria.',
            'capacidad.min'                => 'La capacidad debe ser al menos de 1.',
            'hora_inicio.required'         => 'La hora de inicio es obligatoria.',
            'hora_cierre.required'         => 'La hora de cierre es obligatoria.',
        ];

        $request->validate([
            'nombre'               => 'required|string|max:255',
            'email'                => 'required|email|unique:users,email',
            'password'             => 'required|min:8|confirmed',
            'nit'                  => 'required|string|min:14|max:20',
            'registro_asociacion'  => 'required|string|max:20',
            'departamento'         => 'required|string',
            'direccion'            => 'required|string|max:255',
            'capacidad'            => 'required|integer|min:1',
            'hora_inicio'          => 'required',
            'hora_cierre'          => 'required',
        ], $messages);

        $user = User::create([
            'name'     => $request->nombre,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => 'organizacion',
            'estado'   => 'pendiente',
        ]);

        \App\Models\Organizacion::create([
        'user_id'             => $user->id,
        'nombre_oficial'      => $request->nombre,
        'numero_registro'     => $request->registro_asociacion,
        'representante_legal' => 'Pendiente de actualizar',
        'telefono_contacto'   => 'Sin especificar',
        'direccion'           => $request->direccion . ', ' . $request->departamento,
        'estado_verificacion' => 'pendiente',
    ]);

    return redirect()->route('login')->with('success', '¡Registro exitoso! Tu cuenta está pendiente de aprobación.');
    }

    // Muestra el formulario de registro de comercio
    public function showRegistroCom()
    {
        return view('comercio.registro');
    }

    // Muestra el selector de tipo de cuenta
    public function showRegistro()
    {
        return view('auth.registro');
    }

    public function registroCom(Request $request)
    {
        $messages = [
            'nombre_comercial.required'          => 'El nombre comercial es obligatorio.',
            'nombre_comercial.max'               => 'El nombre comercial no puede exceder 255 caracteres.',
            'nombre_registrado.required'         => 'El nombre registrado es obligatorio.',
            'email.required'                     => 'El correo electrónico es obligatorio.',
            'email.email'                        => 'Debes ingresar un correo válido.',
            'email.unique'                       => 'Este correo ya está registrado.',
            'password.required'                  => 'La contraseña es obligatoria.',
            'password.min'                       => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed'                 => 'Las contraseñas no coinciden.',
            'nit.required'                       => 'El NIT es obligatorio.',
            'nit.min'                            => 'El NIT debe tener al menos 14 caracteres.',
            'nit.unique'                         => 'Este NIT ya se encuentra registrado.',
            'no_autorizacion_sanitaria.required' => 'El número de autorización sanitaria es obligatorio.',
            'telefono.required'                  => 'El teléfono de contacto es obligatorio.',
            'telefono.min'                       => 'El teléfono debe tener al menos 8 caracteres.',
            'telefono.max'                       => 'El teléfono no puede exceder los 20 caracteres.',
            'direccion.required'                 => 'La dirección es obligatoria.',
        ];

        $request->validate([
            'nombre_comercial'         => 'required|string|max:255',
            'nombre_registrado'        => 'required|string|max:255',
            'email'                    => 'required|email|unique:users,email',
            'password'                 => 'required|min:8|confirmed',
            'nit'                      => 'required|string|min:14|unique:comercios,nit',
            'no_autorizacion_sanitaria'=> 'required|string',
            'telefono'                 => 'required|string|min:8|max:20',
            'direccion'                => 'required|string|max:255',
        ], $messages);

        $user = User::create([
            'name'     => $request->nombre_comercial,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'rol'      => 'comercio',
            'estado'   => 'pendiente',
        ]);

        Comercio::create([
            'user_id'                   => $user->id,
            'nombre_comercial'          => $request->nombre_comercial,
            'nombre_registrado'         => $request->nombre_registrado,
            'nit'                       => $request->nit,
            'no_autorizacion_sanitaria' => $request->no_autorizacion_sanitaria,
            'telefono'                  => $request->telefono,
            'direccion'                 => $request->direccion,
        ]);

        return redirect()->route('login')->with('success', '¡Registro exitoso! Tu cuenta está pendiente de aprobación.');
    }
}