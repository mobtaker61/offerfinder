<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('permissionGroups')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $permissionGroups = PermissionGroup::all();
        return view('admin.users.create', compact('permissionGroups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'user_type' => ['required', Rule::in(array_keys(User::getUserTypes()))],
            'permission_groups' => 'nullable|array',
            'permission_groups.*' => 'exists:permission_groups,id',
            'is_active' => 'boolean'
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'user_type' => $validated['user_type'],
            'is_active' => $request->boolean('is_active', true)
        ]);

        if (!empty($validated['permission_groups'])) {
            $user->permissionGroups()->attach($validated['permission_groups']);
        }

        return redirect()->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        $permissionGroups = PermissionGroup::all();
        return view('admin.users.edit', compact('user', 'permissionGroups'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'user_type' => ['required', Rule::in(array_keys(User::getUserTypes()))],
            'permission_groups' => 'nullable|array',
            'permission_groups.*' => 'exists:permission_groups,id',
            'is_active' => 'boolean'
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'user_type' => $validated['user_type'],
            'is_active' => $request->boolean('is_active', true)
        ]);

        if (isset($validated['password'])) {
            $user->update(['password' => Hash::make($validated['password'])]);
        }

        // Sync permission groups
        $user->permissionGroups()->sync($validated['permission_groups'] ?? []);

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
} 