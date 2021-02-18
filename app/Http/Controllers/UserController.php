<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use GrahamCampbell\ResultType\Success;

class UserController extends Controller
{

    public function index()
    {
        $users =User::paginate(5);
        return view('users.index', compact('users'));
    }

    public function cliente()
    {
        $users =User::paginate(5);
        return view('users.cliente', compact('users'));
    }

    public function administrador()
    {
        $users =User::paginate(5);
        return view('users.persona.administrador', compact('users'));
    }

    public function instructor()
    {
        $users =User::paginate(5);
        return view('users.persona.instructor', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $user=User::create($request->only('name', 'carnet_identidad','email','direccion','nro_telefono','tipo')
        +[
            'password' => bcrypt($request->input('password')),
        ]);
        return redirect()->route('users.show', $user->id)->with('success', 'Usuario creado correctamente');
    }
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->only('name', 'carnet_identidad','email','direccion','nro_telefono','tipo');
        $password=$request->input('password');
        if($password)
            $data['password'] = bcrypt($password);
        $user->update($data);
        return redirect()->route('users.show', $user->id)->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return back()->with('success','Usuario eliminado correctamente');
    }
}
