<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Enums\UserStatus;
use App\Http\Requests\UserRequest;

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
    public function store(UserRequest $request)
    {
        $user = User::create($request->validated());

        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        if (!$user || $user->status === UserStatus::Inactive) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserRequest $request, $id)
    {
        $user = User::findOrFail($id);

        if (!$user || $user->status === UserStatus::Inactive) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->update($request->validated());

        return response()->json($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if (!$user || $user->status === UserStatus::Inactive) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->status = UserStatus::Inactive;
        $user->save();

        return response()->json(['message' => 'User deactivated successfully']);
    }
}
