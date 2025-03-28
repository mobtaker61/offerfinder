@extends('layouts.admin')

@section('title', 'Create New Market')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Market</h1>
        <a href="{{ route('admin.markets.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.markets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="mb-3">
                    <label for="name" class="form-label">Market Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                        id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="local_name" class="form-label">Local Name</label>
                    <input type="text" class="form-control @error('local_name') is-invalid @enderror"
                        id="local_name" name="local_name" value="{{ old('local_name') }}">
                    @error('local_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="website" class="form-label">Website</label>
                    <input type="url" class="form-control @error('website') is-invalid @enderror"
                        id="website" name="website" value="{{ old('website') }}">
                    @error('website')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="android_app_link" class="form-label">Android App Link</label>
                    <input type="url" class="form-control @error('android_app_link') is-invalid @enderror"
                        id="android_app_link" name="android_app_link" value="{{ old('android_app_link') }}">
                    @error('android_app_link')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="ios_app_link" class="form-label">iOS App Link</label>
                    <input type="url" class="form-control @error('ios_app_link') is-invalid @enderror"
                        id="ios_app_link" name="ios_app_link" value="{{ old('ios_app_link') }}">
                    @error('ios_app_link')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="whatsapp" class="form-label">WhatsApp Number</label>
                    <input type="text" class="form-control @error('whatsapp') is-invalid @enderror"
                        id="whatsapp" name="whatsapp" value="{{ old('whatsapp') }}"
                        placeholder="Example: 971501234567">
                    <small class="text-muted">Enter the number with country code (e.g., 971501234567)</small>
                    @error('whatsapp')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" checked>
                        <label class="form-check-label" for="is_active">Active</label>
                    </div>
                </div>

                <!-- Market Admin Assignment -->
                <div class="mb-3">
                    <label for="market_admin_id" class="form-label">Market Admin</label>
                    <select class="form-control @error('market_admin_id') is-invalid @enderror" 
                            id="market_admin_id" 
                            name="market_admin_id">
                        <option value="">Select Market Admin</option>
                        @foreach($marketAdmins as $admin)
                            <option value="{{ $admin->id }}" {{ old('market_admin_id') == $admin->id ? 'selected' : '' }}>
                                {{ $admin->name }} ({{ $admin->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('market_admin_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Membership Plan Assignment -->
                <div class="mb-3">
                    <label for="plan_id" class="form-label">Membership Plan</label>
                    <select class="form-control @error('plan_id') is-invalid @enderror" 
                            id="plan_id" 
                            name="plan_id">
                        <option value="">No Plan</option>
                        @foreach($plans as $plan)
                            <option value="{{ $plan->id }}" {{ old('plan_id') == $plan->id ? 'selected' : '' }}>
                                {{ $plan->name }} (Monthly: ${{ $plan->monthly_price }}, Yearly: ${{ $plan->yearly_price }})
                            </option>
                        @endforeach
                    </select>
                    @error('plan_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="mb-3">
                    <label for="logo" class="form-label">Market Logo</label>
                    <input type="file" class="form-control @error('logo') is-invalid @enderror"
                        id="logo" name="logo" accept="image/*">
                    <small class="text-muted">Recommended size: 350x100 pixels</small>
                    @error('logo')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="logo-preview" class="mt-2"></div>
                </div>

                <div class="mb-3">
                    <label for="avatar" class="form-label">Market Avatar</label>
                    <input type="file" class="form-control @error('avatar') is-invalid @enderror"
                        id="avatar" name="avatar" accept="image/*">
                    <small class="text-muted">Recommended size: 256x256 pixels</small>
                    @error('avatar')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div id="avatar-preview" class="mt-2"></div>
                </div>
            </div>
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Market
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Logo preview
        const logoInput = document.getElementById('logo');
        const logoPreview = document.getElementById('logo-preview');

        logoInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    logoPreview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 100px;">`;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Avatar preview
        const avatarInput = document.getElementById('avatar');
        const avatarPreview = document.getElementById('avatar-preview');

        avatarInput.addEventListener('change', function() {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 100px;">`;
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
</script>
@endpush
@endsection