<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class EnsureAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Verificar se há user_id na sessão
        if (!session()->has('user_id')) {
            return redirect()->route('admin.login')->with('error', 'Você precisa fazer login para acessar esta área.');
        }

        // Verificar se o usuário ainda existe no banco de dados
        $userId = session('user_id');
        $user = User::find($userId);

        if (!$user) {
            // Se o usuário não existe mais, limpar a sessão e redirecionar
            session()->flush();
            return redirect()->route('admin.login')->with('error', 'Sua sessão expirou. Por favor, faça login novamente.');
        }

        return $next($request);
    }
}
