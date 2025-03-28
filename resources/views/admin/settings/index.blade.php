@extends('layouts.admin')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Settings</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Settings</li>
    </ol>

    <div class="row mb-3">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Manage Settings</span>
                    <a href="{{ route('admin.settings.schemas') }}" class="btn btn-sm btn-primary">
                        <i class="fas fa-cog"></i> Manage Setting Definitions
                    </a>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('warning'))
                        <div class="alert alert-warning">
                            {{ session('warning') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if(empty($settingsGroups))
                        <div class="alert alert-info">
                            No settings have been defined yet. <a href="{{ route('admin.settings.schemas') }}">Create some setting definitions</a> to get started.
                        </div>
                    @else
                        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <ul class="nav nav-tabs" id="settingsTabs" role="tablist">
                                @foreach($settingsGroups as $group => $settings)
                                    <li class="nav-item" role="presentation">
                                        <button class="nav-link {{ $loop->first ? 'active' : '' }}" 
                                                id="{{ Str::slug($group) }}-tab" 
                                                data-bs-toggle="tab" 
                                                data-bs-target="#{{ Str::slug($group) }}" 
                                                type="button" 
                                                role="tab">
                                            {{ ucfirst($group) }}
                                        </button>
                                    </li>
                                @endforeach
                            </ul>
                            
                            <div class="tab-content mt-3" id="settingsTabsContent">
                                @foreach($settingsGroups as $group => $settings)
                                    <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" 
                                         id="{{ Str::slug($group) }}" 
                                         role="tabpanel">
                                        
                                        <div class="row">
                                            @foreach($settings as $setting)
                                                <div class="col-md-6 mb-3">
                                                    <div class="form-group">
                                                        <label for="{{ $setting['key'] }}">
                                                            {{ $setting['label'] }}
                                                            @if($setting['is_required'])
                                                                <span class="text-danger">*</span>
                                                            @endif
                                                        </label>
                                                        
                                                        @if($setting['description'])
                                                            <p class="small text-muted">{{ $setting['description'] }}</p>
                                                        @endif
                                                        
                                                        @switch($setting['data_type'])
                                                            @case('text')
                                                                <textarea 
                                                                    name="{{ $setting['key'] }}" 
                                                                    id="{{ $setting['key'] }}" 
                                                                    class="form-control" 
                                                                    rows="3"
                                                                    {{ $setting['is_required'] ? 'required' : '' }}
                                                                >{{ $setting['value'] }}</textarea>
                                                                @break
                                                                
                                                            @case('boolean')
                                                                <div class="form-check form-switch">
                                                                    <input 
                                                                        type="checkbox" 
                                                                        class="form-check-input" 
                                                                        name="{{ $setting['key'] }}" 
                                                                        id="{{ $setting['key'] }}" 
                                                                        value="1" 
                                                                        {{ $setting['value'] ? 'checked' : '' }}
                                                                    >
                                                                </div>
                                                                @break
                                                                
                                                            @case('select')
                                                                <select 
                                                                    name="{{ $setting['key'] }}" 
                                                                    id="{{ $setting['key'] }}" 
                                                                    class="form-select"
                                                                    {{ $setting['is_required'] ? 'required' : '' }}
                                                                >
                                                                    <option value="">Select an option</option>
                                                                    @foreach($setting['options'] as $optionValue => $optionLabel)
                                                                        <option 
                                                                            value="{{ $optionValue }}" 
                                                                            {{ $setting['value'] == $optionValue ? 'selected' : '' }}
                                                                        >
                                                                            {{ $optionLabel }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @break
                                                                
                                                            @case('image')
                                                                <div class="mb-2">
                                                                    @if($setting['value'])
                                                                        <img src="{{ asset('storage/' . $setting['value']) }}" 
                                                                             alt="{{ $setting['label'] }}" 
                                                                             class="img-thumbnail mb-2" 
                                                                             style="max-height: 100px;">
                                                                    @endif
                                                                </div>
                                                                <input 
                                                                    type="file" 
                                                                    name="{{ $setting['key'] }}" 
                                                                    id="{{ $setting['key'] }}" 
                                                                    class="form-control"
                                                                    accept="image/*"
                                                                >
                                                                @break
                                                                
                                                            @case('file')
                                                                <div class="mb-2">
                                                                    @if($setting['value'])
                                                                        <div class="mb-2">
                                                                            Current file: 
                                                                            <a href="{{ asset('storage/' . $setting['value']) }}" target="_blank">
                                                                                {{ basename($setting['value']) }}
                                                                            </a>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <input 
                                                                    type="file" 
                                                                    name="{{ $setting['key'] }}" 
                                                                    id="{{ $setting['key'] }}" 
                                                                    class="form-control"
                                                                >
                                                                @break
                                                                
                                                            @default
                                                                <input 
                                                                    type="{{ $setting['data_type'] === 'password' ? 'password' : 'text' }}" 
                                                                    name="{{ $setting['key'] }}" 
                                                                    id="{{ $setting['key'] }}" 
                                                                    class="form-control" 
                                                                    value="{{ $setting['value'] }}"
                                                                    {{ $setting['is_required'] ? 'required' : '' }}
                                                                >
                                                        @endswitch
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            
                            <div class="mt-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Settings
                                </button>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 