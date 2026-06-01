<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index()
    {
        $guests = Guest::orderBy('name')->paginate(15);
        return view('admin.guests.index', compact('guests'));
    }

    public function create()
    {
        return view('admin.guests.create');
    }

    public function store(StoreGuestRequest $request)
    {
        Guest::create($request->validated());
        return redirect()->route('admin.guests.index')->with('success', 'Hóspede criado com sucesso!');
    }

    public function show(Guest $guest)
    {
        return view('admin.guests.show', compact('guest'));
    }

    public function edit(Guest $guest)
    {
        return view('admin.guests.edit', compact('guest'));
    }

    public function update(UpdateGuestRequest $request, Guest $guest)
    {
        $guest->update($request->validated());
        return redirect()->route('admin.guests.index')->with('success', 'Hóspede atualizado com sucesso!');
    }

    public function destroy(Guest $guest)
    {
        $guest->delete();
        return redirect()->route('admin.guests.index')->with('success', 'Hóspede excluído com sucesso!');
    }
}
