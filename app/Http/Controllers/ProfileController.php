<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function show()
    {
        $user = User::find(session('user_id'));
        return view('admin.profile.show', compact('user'));
    }

    public function edit()
    {
        $user = User::find(session('user_id'));
        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = User::find(session('user_id'));

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'current_password' => 'nullable|string',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            if (!$request->filled('current_password') || !Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Senha atual incorreta.'])->withInput();
            }
            $user->password = Hash::make($request->password);
        }

        $user->save();

        // Atualizar sessão
        session(['user_name' => $user->name]);
        session(['user_email' => $user->email]);

        return redirect()->route('admin.profile.show')->with('success', 'Perfil atualizado com sucesso!');
    }

    public function settings()
    {
        $user = User::find(session('user_id'));
        return view('admin.profile.settings', compact('user'));
    }

    public function updateSettings(Request $request)
    {
        $user = User::find(session('user_id'));

        $request->validate([
            'role' => 'required|in:admin,manager',
        ]);

        $user->role = $request->role;
        $user->save();

        return redirect()->route('admin.settings')->with('success', 'Definições atualizadas com sucesso!');
    }
}
