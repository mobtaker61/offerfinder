<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingSchema;
use App\Models\SettingValue;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SettingsController extends Controller
{
    protected $settingsService;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    /**
     * Display a listing of the settings.
     */
    public function index()
    {
        $settingsGroups = $this->settingsService->getAllGrouped();
        
        return view('admin.settings.index', [
            'settingsGroups' => $settingsGroups
        ]);
    }

    /**
     * Show the form for managing setting schemas.
     */
    public function manageSchemas()
    {
        $schemas = SettingSchema::orderBy('group')
            ->orderBy('display_order')
            ->get();
            
        $groups = SettingSchema::select('group')
            ->distinct()
            ->pluck('group')
            ->toArray();
            
        return view('admin.settings.schemas', [
            'schemas' => $schemas,
            'groups' => $groups
        ]);
    }

    /**
     * Store a new setting schema.
     */
    public function storeSchema(Request $request)
    {
        $validated = $request->validate([
            'key' => 'required|string|max:255|unique:settings_schema,key',
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group' => 'required|string|max:255',
            'data_type' => [
                'required',
                Rule::in(['string', 'integer', 'boolean', 'float', 'array', 'object', 'file', 'image', 'email', 'url', 'text', 'select'])
            ],
            'options' => 'nullable|string',
            'default_value' => 'nullable|string',
            'is_required' => 'boolean',
            'display_order' => 'integer',
            'is_active' => 'boolean'
        ]);
        
        $schema = $this->settingsService->createSchema($validated);
        
        if ($schema) {
            return redirect()->route('admin.settings.schemas')
                ->with('success', 'Setting schema created successfully.');
        }
        
        return redirect()->route('admin.settings.schemas')
            ->with('error', 'Failed to create setting schema.');
    }

    /**
     * Update the specified setting schema.
     */
    public function updateSchema(Request $request, $id)
    {
        $validated = $request->validate([
            'key' => [
                'required',
                'string', 
                'max:255',
                Rule::unique('settings_schema', 'key')->ignore($id)
            ],
            'label' => 'required|string|max:255',
            'description' => 'nullable|string',
            'group' => 'required|string|max:255',
            'data_type' => [
                'required',
                Rule::in(['string', 'integer', 'boolean', 'float', 'array', 'object', 'file', 'image', 'email', 'url', 'text', 'select'])
            ],
            'options' => 'nullable|string',
            'default_value' => 'nullable|string',
            'is_required' => 'boolean',
            'display_order' => 'integer',
            'is_active' => 'boolean'
        ]);
        
        if ($this->settingsService->updateSchema($id, $validated)) {
            return redirect()->route('admin.settings.schemas')
                ->with('success', 'Setting schema updated successfully.');
        }
        
        return redirect()->route('admin.settings.schemas')
            ->with('error', 'Failed to update setting schema.');
    }

    /**
     * Remove the specified setting schema.
     */
    public function destroySchema($id)
    {
        if ($this->settingsService->deleteSchema($id)) {
            return redirect()->route('admin.settings.schemas')
                ->with('success', 'Setting schema deleted successfully.');
        }
        
        return redirect()->route('admin.settings.schemas')
            ->with('error', 'Failed to delete setting schema.');
    }

    /**
     * Update setting values.
     */
    public function updateValues(Request $request)
    {
        $settings = $request->except('_token');
        $userId = Auth::id();
        $success = true;
        
        foreach ($settings as $key => $value) {
            if (!$this->settingsService->set($key, $value, $userId)) {
                $success = false;
            }
        }
        
        if ($success) {
            return redirect()->route('admin.settings.index')
                ->with('success', 'Settings updated successfully.');
        }
        
        return redirect()->route('admin.settings.index')
            ->with('warning', 'Some settings could not be updated.');
    }
}
