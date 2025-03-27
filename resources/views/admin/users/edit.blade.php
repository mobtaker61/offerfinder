@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit User</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password">Password (leave blank to keep current)</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                                </div>

                                <div class="form-group mb-3">
                                    <label for="user_type">User Type</label>
                                    <select class="form-control @error('user_type') is-invalid @enderror" 
                                            id="user_type" 
                                            name="user_type" 
                                            required>
                                        @foreach(\App\Models\User::getUserTypes() as $value => $label)
                                            <option value="{{ $value }}" {{ old('user_type', $user->user_type) == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Market Selection (for Market Admin) -->
                                <div class="form-group mb-3" id="marketSelection" style="display: none;">
                                    <label>Assigned Market</label>
                                    <select class="form-control @error('market_id') is-invalid @enderror" 
                                            id="market_id" 
                                            name="market_id">
                                        <option value="">Select Market</option>
                                        @foreach($markets as $market)
                                            <option value="{{ $market->id }}" {{ old('market_id', $user->markets->first()->id ?? '') == $market->id ? 'selected' : '' }}>
                                                {{ $market->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('market_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Branch Selection (for Branch Admin) -->
                                <div class="form-group mb-3" id="branchSelection" style="display: none;">
                                    <label>Select Market First</label>
                                    <select class="form-control @error('branch_market_id') is-invalid @enderror" 
                                            id="branch_market_id" 
                                            name="branch_market_id">
                                        <option value="">Select Market</option>
                                        @foreach($markets as $market)
                                            <option value="{{ $market->id }}" {{ old('branch_market_id', $user->branches->first()->market_id ?? '') == $market->id ? 'selected' : '' }}>
                                                {{ $market->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('branch_market_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <div id="branchDropdownContainer" style="display: none; margin-top: 10px;">
                                        <label>Assigned Branch</label>
                                        <select class="form-control @error('branch_id') is-invalid @enderror" 
                                                id="branch_id" 
                                                name="branch_id">
                                            <option value="">Select Branch</option>
                                        </select>
                                        @error('branch_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label>Permission Groups</label>
                                    <div class="border p-3 rounded">
                                        @foreach($permissionGroups as $group)
                                            <div class="custom-control custom-checkbox mb-2">
                                                <input type="checkbox" 
                                                       class="custom-control-input" 
                                                       id="group_{{ $group->id }}" 
                                                       name="permission_groups[]" 
                                                       value="{{ $group->id }}"
                                                       {{ in_array($group->id, old('permission_groups', $user->permissionGroups->pluck('id')->toArray())) ? 'checked' : '' }}>
                                                <label class="custom-control-label" for="group_{{ $group->id }}">
                                                    {{ $group->name }}
                                                    <small class="text-muted">({{ count($group->permissions) }} permissions)</small>
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group mb-3">
                                    <label for="avatar">Avatar</label>
                                    @if($user->avatar)
                                        <div class="mb-2">
                                            <img src="{{ Storage::url($user->avatar) }}" alt="Current Avatar" class="img-thumbnail" style="max-height: 100px;">
                                        </div>
                                    @endif
                                    <input type="file" class="form-control @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                                    @error('avatar')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Max file size: 1MB. Supported formats: JPG, PNG, GIF</small>
                                </div>

                                <div class="form-group mb-3">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="is_active">Active</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone">Phone</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="location">Location</label>
                                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location', $user->location) }}">
                                    @error('location')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="birth_date">Birth Date</label>
                                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date?->format('Y-m-d')) }}">
                                    @error('birth_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="gender">Gender</label>
                                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                                        <option value="">Select Gender</option>
                                        <option value="male" {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                        <option value="female" {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                        <option value="other" {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>
                                    @error('gender')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="bio">Bio</label>
                                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio', $user->bio) }}</textarea>
                                    @error('bio')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="facebook_url">Facebook URL</label>
                                    <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url" name="facebook_url" value="{{ old('facebook_url', $user->facebook_url) }}">
                                    @error('facebook_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="twitter_url">Twitter URL</label>
                                    <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" id="twitter_url" name="twitter_url" value="{{ old('twitter_url', $user->twitter_url) }}">
                                    @error('twitter_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="instagram_url">Instagram URL</label>
                                    <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" id="instagram_url" name="instagram_url" value="{{ old('instagram_url', $user->instagram_url) }}">
                                    @error('instagram_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group mb-3">
                                    <label for="linkedin_url">LinkedIn URL</label>
                                    <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url', $user->linkedin_url) }}">
                                    @error('linkedin_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <h4>Notification Preferences</h4>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="newsletter" 
                                               name="newsletter" 
                                               value="1" 
                                               {{ old('newsletter', $user->newsletter) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="newsletter">Subscribe to Newsletter</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="email_notifications" 
                                               name="email_notifications" 
                                               value="1" 
                                               {{ old('email_notifications', $user->email_notifications) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="email_notifications">Email Notifications</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="push_notifications" 
                                               name="push_notifications" 
                                               value="1" 
                                               {{ old('push_notifications', $user->push_notifications) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="push_notifications">Push Notifications</label>
                                    </div>
                                </div>
                                <div class="form-group mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" 
                                               class="custom-control-input" 
                                               id="sms_notifications" 
                                               name="sms_notifications" 
                                               value="1" 
                                               {{ old('sms_notifications', $user->sms_notifications) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="sms_notifications">SMS Notifications</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update User</button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const userTypeSelect = document.getElementById('user_type');
    const marketSelection = document.getElementById('marketSelection');
    const branchSelection = document.getElementById('branchSelection');
    const branchMarketSelect = document.getElementById('branch_market_id');
    const branchDropdownContainer = document.getElementById('branchDropdownContainer');
    const branchSelect = document.getElementById('branch_id');

    function toggleSelections() {
        const selectedType = userTypeSelect.value;
        
        if (selectedType === '{{ \App\Models\User::TYPE_MARKET_ADMIN }}') {
            marketSelection.style.display = 'block';
            branchSelection.style.display = 'none';
        } else if (selectedType === '{{ \App\Models\User::TYPE_BRANCH_ADMIN }}') {
            marketSelection.style.display = 'none';
            branchSelection.style.display = 'block';
            branchDropdownContainer.style.display = 'none';
            branchSelect.value = '';
        } else {
            marketSelection.style.display = 'none';
            branchSelection.style.display = 'none';
        }
    }

    // Handle market selection for branch admin
    branchMarketSelect.addEventListener('change', function() {
        const marketId = this.value;
        branchDropdownContainer.style.display = 'none';
        branchSelect.value = '';

        if (marketId) {
            const url = `/admin/markets/${marketId}/branches`;
            
            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw new Error(data.error || `HTTP error! status: ${response.status}`);
                        });
                    }
                    return response.json();
                })
                .then(branches => {
                    if (!Array.isArray(branches)) {
                        throw new Error('Invalid response format');
                    }
                    branchSelect.innerHTML = '<option value="">Select Branch</option>';
                    branches.forEach(branch => {
                        branchSelect.innerHTML += `<option value="${branch.id}">${branch.name}</option>`;
                    });
                    branchDropdownContainer.style.display = 'block';
                })
                .catch(error => {
                    alert('Error loading branches. Please try again.');
                });
        }
    });

    // Add event listener for user type change
    userTypeSelect.addEventListener('change', toggleSelections);
    
    // Run on page load
    toggleSelections();

    // If branch market is pre-selected, trigger the change event
    if (branchMarketSelect.value) {
        branchMarketSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection