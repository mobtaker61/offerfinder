<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Models\PermissionGroup;
use App\Models\Market;
use App\Models\Branch;
use Illuminate\Support\Facades\Log;

class UserManagementController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::with(['permissionGroups', 'markets', 'branches'])->latest()->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        $permissionGroups = PermissionGroup::all();
        $markets = Market::all();
        $branches = Branch::all();
        return view('admin.users.create', compact('permissionGroups', 'markets', 'branches'));
    }

    /**
     * Store a newly created user in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8',
                'user_type' => ['required', 'string', Rule::in(array_keys(User::getUserTypes()))],
                'market_id' => ['nullable', 'required_if:user_type,' . User::TYPE_MARKET_ADMIN, 'exists:markets,id'],
                'branch_market_id' => ['nullable', 'required_if:user_type,' . User::TYPE_BRANCH_ADMIN, 'exists:markets,id'],
                'branch_id' => ['nullable', 'required_if:user_type,' . User::TYPE_BRANCH_ADMIN, 'exists:branches,id'],
                'permission_groups' => 'required|array',
                'permission_groups.*' => 'exists:permission_groups,id',
                'avatar' => 'nullable|image|max:1024',
                'is_active' => 'boolean',
                'phone' => 'nullable|string|max:20',
                'location' => 'nullable|string|max:255',
                'birth_date' => 'nullable|date',
                'gender' => 'nullable|string|in:male,female,other',
                'bio' => 'nullable|string|max:1000',
                'facebook_url' => 'nullable|url|max:255',
                'twitter_url' => 'nullable|url|max:255',
                'instagram_url' => 'nullable|url|max:255',
                'linkedin_url' => 'nullable|url|max:255',
                'newsletter' => 'boolean',
                'email_notifications' => 'boolean',
                'push_notifications' => 'boolean',
                'sms_notifications' => 'boolean',
            ]);

            $user = new User($validated);
            $user->password = Hash::make($validated['password']);
            $user->is_active = $request->boolean('is_active', true);
            $user->newsletter = $request->boolean('newsletter', false);
            $user->email_notifications = $request->boolean('email_notifications', true);
            $user->push_notifications = $request->boolean('push_notifications', true);
            $user->sms_notifications = $request->boolean('sms_notifications', false);

            if ($request->hasFile('avatar')) {
                $user->avatar = $request->file('avatar')->store('avatars', 'public');
            }

            $user->save();

            $user->permissionGroups()->sync($validated['permission_groups']);

            if ($user->user_type === User::TYPE_MARKET_ADMIN && isset($validated['market_id'])) {
                $user->markets()->attach($validated['market_id']);
            } elseif ($user->user_type === User::TYPE_BRANCH_ADMIN && isset($validated['branch_id'])) {
                $user->branches()->attach($validated['branch_id']);
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            Log::error("Error creating user: " . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to create user. Please try again.');
        }
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        $permissionGroups = PermissionGroup::all();
        $markets = Market::all();
        $branches = Branch::all();
        return view('admin.users.edit', compact('user', 'permissionGroups', 'markets', 'branches'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8',
                'user_type' => ['required', 'string', Rule::in(array_keys(User::getUserTypes()))],
                'market_id' => ['nullable', 'required_if:user_type,' . User::TYPE_MARKET_ADMIN, 'exists:markets,id'],
                'branch_market_id' => ['nullable', 'required_if:user_type,' . User::TYPE_BRANCH_ADMIN, 'exists:markets,id'],
                'branch_id' => ['nullable', 'required_if:user_type,' . User::TYPE_BRANCH_ADMIN, 'exists:branches,id'],
                'permission_groups' => 'required|array',
                'permission_groups.*' => 'exists:permission_groups,id',
                'avatar' => 'nullable|image|max:1024',
                'is_active' => 'boolean',
                'phone' => 'nullable|string|max:20',
                'location' => 'nullable|string|max:255',
                'birth_date' => 'nullable|date',
                'gender' => 'nullable|string|in:male,female,other',
                'bio' => 'nullable|string|max:1000',
                'facebook_url' => 'nullable|url|max:255',
                'twitter_url' => 'nullable|url|max:255',
                'instagram_url' => 'nullable|url|max:255',
                'linkedin_url' => 'nullable|url|max:255',
                'newsletter' => 'boolean',
                'email_notifications' => 'boolean',
                'push_notifications' => 'boolean',
                'sms_notifications' => 'boolean',
            ]);

            // Remove password from validated data if it's empty
            if (empty($validated['password'])) {
                unset($validated['password']);
            } else {
                $validated['password'] = Hash::make($validated['password']);
            }

            $user->fill($validated);
            $user->is_active = $request->boolean('is_active', true);
            $user->newsletter = $request->boolean('newsletter', false);
            $user->email_notifications = $request->boolean('email_notifications', true);
            $user->push_notifications = $request->boolean('push_notifications', true);
            $user->sms_notifications = $request->boolean('sms_notifications', false);

            if ($request->hasFile('avatar')) {
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }
                $user->avatar = $request->file('avatar')->store('avatars', 'public');
            }

            $user->save();

            $user->permissionGroups()->sync($validated['permission_groups']);

            // Update market associations
            $user->markets()->detach();
            if ($user->user_type === User::TYPE_MARKET_ADMIN && isset($validated['market_id'])) {
                $user->markets()->attach($validated['market_id']);
            }

            // Update branch associations
            $user->branches()->detach();
            if ($user->user_type === User::TYPE_BRANCH_ADMIN && isset($validated['branch_id'])) {
                $user->branches()->attach($validated['branch_id']);
            }

            return redirect()->route('admin.users.index')
                ->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            Log::error("Error updating user: " . $e->getMessage());
            return back()->withInput()->with('error', 'Failed to update user. Please try again.');
        }
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Delete avatar if exists
        if ($user->avatar) {
            Storage::delete($user->avatar);
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }

    /**
     * Toggle user active status
     */
    public function toggleActive(User $user)
    {
        $user->update(['is_active' => !$user->is_active]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User status updated successfully.');
    }
} 