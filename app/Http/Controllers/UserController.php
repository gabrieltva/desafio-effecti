<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\UserStatus;
use App\Rules\Cpf;
use Illuminate\Validation\Rules\Enum;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('status', UserStatus::Active)->get();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => ['required', 'unique:users', new Cpf],
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:15',
            'cep' => 'required|string|max:9',
            'state' => 'required|string|max:2',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => ['required', new Enum(UserStatus::class)],
        ]);

        $user = User::create($request->all());

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user || $user->status === UserStatus::Inactive) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user || $user->status === UserStatus::Inactive) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'cpf' => ['required', 'unique:users,cpf,' . $user->id, new Cpf],
            'birth_date' => 'required|date',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:15',
            'cep' => 'required|string|max:9',
            'state' => 'required|string|max:2',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'status' => ['required', new Enum(UserStatus::class)],
        ]);

        $user->update($request->all());

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user || $user->status === UserStatus::Inactive) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->status = UserStatus::Inactive;
        $user->save();

        return response()->json(['message' => 'User deactivated successfully']);
    }
}
