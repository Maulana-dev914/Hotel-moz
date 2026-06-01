<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function logout(Request $request)
    {
        // Limpar todas as variáveis de sessão
        $request->session()->flush();
        
        // Invalidar a sessão
        $request->session()->invalidate();
        
        // Regenerar o token CSRF
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login')->with('success', 'Você foi desconectado com sucesso.');
    }
}
