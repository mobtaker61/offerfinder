<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PermissionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermissionGroupController extends Controller
{
    public function index()
    {
        $groups = PermissionGroup::withCount('users')->paginate(10);
        return view('admin.permissions.groups.index', compact('groups'));
    }

    public function create()
    {
        $availablePermissions = $this->getAvailablePermissions();
        return view('admin.permissions.groups.create', compact('availablePermissions'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permission_groups',
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'string'
        ]);

        PermissionGroup::create($validated);

        return redirect()->route('admin.permission-groups.index')
            ->with('success', 'Permission group created successfully.');
    }

    public function edit(PermissionGroup $group)
    {
        $availablePermissions = $this->getAvailablePermissions();
        return view('admin.permissions.groups.edit', compact('group', 'availablePermissions'));
    }

    public function update(Request $request, PermissionGroup $group)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:permission_groups,name,' . $group->id,
            'description' => 'nullable|string',
            'permissions' => 'required|array',
            'permissions.*' => 'string'
        ]);

        $group->update($validated);

        return redirect()->route('admin.permission-groups.index')
            ->with('success', 'Permission group updated successfully.');
    }

    public function destroy(PermissionGroup $group)
    {
        $group->delete();
        return redirect()->route('admin.permission-groups.index')
            ->with('success', 'Permission group deleted successfully.');
    }

    private function getAvailablePermissions(): array
    {
        return [
            'manage_users' => 'Manage Users',
            'manage_roles' => 'Manage Roles',
            'manage_permissions' => 'Manage Permissions',
            'manage_markets' => 'Manage Markets',
            'manage_branches' => 'Manage Branches',
            'manage_offers' => 'Manage Offers',
            'manage_products' => 'Manage Products',
            'manage_categories' => 'Manage Categories',
            'manage_settings' => 'Manage Settings',
            'view_reports' => 'View Reports',
            'manage_content' => 'Manage Content',
            'manage_media' => 'Manage Media',
            'manage_notifications' => 'Manage Notifications',
            'manage_audit_logs' => 'View Audit Logs',
        ];
    }
} 