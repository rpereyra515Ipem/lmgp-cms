<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            AuditLog::create([
                'user_id' => Auth::id(),
                'action' => 'LOGIN',
                'entity_type' => 'User',
                'entity_id' => Auth::id(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'created_at' => now(),
            ]);

            return redirect()->intended(route('admin.dashboard'));
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    /**
     * Redirige al inicio de sesión de Google (modo stateless)
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->stateless()->redirect();
    }

    /**
     * Procesa la respuesta de Google y valida el dominio institucional (modo stateless)
     */
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $email = strtolower($googleUser->getEmail());

            // REGLA DE SEGURIDAD ESTRICTA: Solo cuentas oficiales @liceopaz.edu.ar
            $esDominioOficial = Str::endsWith($email, '@liceopaz.edu.ar');

            if (! $esDominioOficial) {
                AuditLog::create([
                    'user_id' => null,
                    'action' => 'LOGIN_GOOGLE_REJECTED',
                    'entity_type' => 'Auth',
                    'entity_id' => null,
                    'ip_address' => request()->ip(),
                    'user_agent' => request()->userAgent(),
                    'old_values' => json_encode(['email' => $email]),
                    'new_values' => json_encode(['motivo' => 'Cuenta externa no autorizada']),
                    'created_at' => now(),
                ]);

                return redirect()->route('login')->withErrors([
                    'email' => 'Acceso denegado: solo se admiten cuentas oficiales @liceopaz.edu.ar.',
                ]);
            }

            // Buscar si ya existe el usuario o crearlo en su primer ingreso
            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $googleUser->getName(),
                    'password' => Hash::make(Str::random(32)),
                    'role' => 'docente',
                ]
            );

            Auth::login($user);

            // Registro de auditoría institucional
            AuditLog::create([
                'user_id' => $user->id,
                'action' => 'LOGIN_GOOGLE_SUCCESS',
                'entity_type' => 'User',
                'entity_id' => $user->id,
                'ip_address' => request()->ip(),
                'user_agent' => request()->userAgent(),
                'new_values' => json_encode(['email' => $email, 'role' => $user->role]),
                'created_at' => now(),
            ]);

            // Redirige automáticamente al espacio docente
            return redirect()->intended(route('docentes.index'))->with('success', 'Sesión iniciada correctamente.');
        } catch (\Throwable $e) {
            Log::error('Error en autenticación Google: ' . $e->getMessage());

            return redirect()->route('login')->withErrors([
                'email' => 'Ocurrió un error al autenticar con Google. Intente nuevamente.',
            ]);
        }
    }
}
