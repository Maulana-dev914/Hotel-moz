<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (session()->has('user_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            // Limpar qualquer sessão existente em caso de tentativa de login inválida
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            throw ValidationException::withMessages([
                'email' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        // Limpar sessão anterior antes de criar nova
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Criar nova sessão autenticada
        session(['user_id' => $user->id]);
        session(['user_name' => $user->name]);
        session(['user_email' => $user->email]);
        session(['user_role' => $user->role ?? 'manager']);

        return redirect()->route('admin.dashboard')->with('success', 'Bem-vindo, ' . $user->name . '!');
    }
}
