<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function index()
    {
        $users = User::all();
        return view('users.index', ['users' => $users]);
    }



    public function __construct()
    {
        $this->middleware(['auth', 'is_admin'])->except(['index', 'show']);
    }

    public function edit(User $user)
    {
        return view('users.edit', ['user' => $user]);
    }



    public function update(Request $request, User $user)
    {
        // Валидация данных
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|numeric|digits_between:8,15|unique:users,phone,' . $user->id,
            'status' => 'required|string|in:pending,enabled,disabled',
            'password' => 'sometimes|nullable|string|min:8|confirmed',
            'is_admin' => 'required|boolean',
        ]);
        // Если пароль предоставлен, то хешируем его перед сохранением
        if ($request->filled('password')) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // Удаляем ключ пароля, чтобы не обновлять его в базе данных
            unset($data['password']);
        }

        // Обновляем модель пользователя
        if (auth()->user()->is_admin) {
            $user->update($data);

            return redirect()->route('users.index')->withSuccess('User updated successfully.');
        } else {
            return redirect()->route('users.index')->withErrors('You do not have permission to perform this action.');
        }
    }


    public function destroy(User $user)
    {
        if (auth()->user()->is_admin) {
            $user->delete();
            return redirect()->route('users.index')->withSuccess('User deleted successfully.');
        } else {
            return redirect()->route('users.index')->withErrors('You do not have permission to perform this action.');
        }
    }
}
