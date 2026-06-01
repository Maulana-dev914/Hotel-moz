<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    public function showForgotPasswordForm()
    {
        // Se já estiver logado, redirecionar para o dashboard
        if (session()->has('user_id')) {
            return redirect()->route('admin.dashboard');
        }
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors(['email' => 'Email não encontrado.'])->withInput();
        }

        // Gerar token de reset
        $token = Str::random(64);
        session(['password_reset_token_' . $user->id => $token]);
        session(['password_reset_email_' . $user->id => $user->email]);
        session(['password_reset_expires_' . $user->id => now()->addHours(1)]);

        // Em produção, você enviaria um email aqui
        // Por enquanto, vamos mostrar o token na tela (apenas para desenvolvimento)
        return redirect()->route('admin.password.reset', ['token' => $token, 'email' => $user->email])
            ->with('success', 'Instruções de recuperação enviadas. Verifique seu email.');
    }

    public function showResetForm(Request $request)
    {
        // Se já estiver logado, redirecionar para o dashboard
        if (session()->has('user_id')) {
            return redirect()->route('admin.dashboard');
        }

        $token = $request->token;
        $email = $request->email;

        if (!$token || !$email) {
            return redirect()->route('admin.password.forgot')
                ->withErrors(['error' => 'Link inválido.']);
        }

        return view('auth.reset-password', compact('token', 'email'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Email não encontrado.'])->withInput();
        }

        // Verificar token
        $storedToken = session('password_reset_token_' . $user->id);
        $expires = session('password_reset_expires_' . $user->id);

        if (!$storedToken || $storedToken !== $request->token || !$expires || now()->gt($expires)) {
            return back()->withErrors(['token' => 'Token inválido ou expirado.'])->withInput();
        }

        // Atualizar senha
        $user->password = Hash::make($request->password);
        $user->save();

        // Limpar sessão
        session()->forget('password_reset_token_' . $user->id);
        session()->forget('password_reset_email_' . $user->id);
        session()->forget('password_reset_expires_' . $user->id);

        return redirect()->route('admin.login')
            ->with('success', 'Senha alterada com sucesso! Faça login com a nova senha.');
    }
}
