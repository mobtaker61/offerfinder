@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <h2>Create New User</h2>
    <form action="{{ route('admin.users.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                    @error('name')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                    @error('email')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                    @error('password')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="user_type">User Type</label>
                    <select class="form-control @error('user_type') is-invalid @enderror" id="user_type" name="user_type" required>
                        <option value="">Select User Type</option>
                        @foreach(App\Models\User::getUserTypes() as $value => $label)
                        <option value="{{ $value }}" {{ old('user_type') == $value ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                        @endforeach
                    </select>
                    @error('user_type')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}">
                    @error('phone')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="avatar">Avatar</label>
                    <input type="file" class="form-control-file @error('avatar') is-invalid @enderror" id="avatar" name="avatar">
                    @error('avatar')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                    <small class="form-text text-muted">Max file size: 1MB. Supported formats: JPG, PNG, GIF</small>
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="location">Location</label>
                    <input type="text" class="form-control @error('location') is-invalid @enderror" id="location" name="location" value="{{ old('location') }}">
                    @error('location')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="birth_date">Birth Date</label>
                    <input type="date" class="form-control @error('birth_date') is-invalid @enderror" id="birth_date" name="birth_date" value="{{ old('birth_date') }}">
                    @error('birth_date')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-6">
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender">
                        <option value="">Select Gender</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                        <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="bio">Bio</label>
                    <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3">{{ old('bio') }}</textarea>
                    @error('bio')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="facebook_url">Facebook URL</label>
                    <input type="url" class="form-control @error('facebook_url') is-invalid @enderror" id="facebook_url" name="facebook_url" value="{{ old('facebook_url') }}">
                    @error('facebook_url')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="twitter_url">Twitter URL</label>
                    <input type="url" class="form-control @error('twitter_url') is-invalid @enderror" id="twitter_url" name="twitter_url" value="{{ old('twitter_url') }}">
                    @error('twitter_url')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="instagram_url">Instagram URL</label>
                    <input type="url" class="form-control @error('instagram_url') is-invalid @enderror" id="instagram_url" name="instagram_url" value="{{ old('instagram_url') }}">
                    @error('instagram_url')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="linkedin_url">LinkedIn URL</label>
                    <input type="url" class="form-control @error('linkedin_url') is-invalid @enderror" id="linkedin_url" name="linkedin_url" value="{{ old('linkedin_url') }}">
                    @error('linkedin_url')
                    <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="is_active">Active</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <h4>Notification Preferences</h4>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="newsletter" name="newsletter" value="1" {{ old('newsletter') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="newsletter">Subscribe to Newsletter</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="email_notifications" name="email_notifications" value="1" {{ old('email_notifications', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="email_notifications">Email Notifications</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="push_notifications" name="push_notifications" value="1" {{ old('push_notifications', true) ? 'checked' : '' }}>
                        <label class="custom-control-label" for="push_notifications">Push Notifications</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input type="checkbox" class="custom-control-input" id="sms_notifications" name="sms_notifications" value="1" {{ old('sms_notifications') ? 'checked' : '' }}>
                        <label class="custom-control-label" for="sms_notifications">SMS Notifications</label>
                    </div>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Create User</button>
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection