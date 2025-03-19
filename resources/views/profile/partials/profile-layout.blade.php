<div class="container py-5">
    <div class="row">
        <!-- Side Menu -->
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center mb-4">
                        <div class="position-relative d-inline-block">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="Profile" class="rounded-circle mb-3" style="width: 120px; height: 120px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 120px; height: 120px;">
                                    <span class="text-white display-4">{{ substr($user->name, 0, 1) }}</span>
                                </div>
                            @endif
                            <label for="avatar" class="position-absolute bottom-0 end-0 bg-primary text-white rounded-circle p-2" style="cursor: pointer;">
                                <i class="fas fa-camera"></i>
                            </label>
                            <input type="file" id="avatar" name="avatar" class="d-none" accept="image/*" form="profile-form">
                        </div>
                        <h5 class="mb-1">{{ $user->name }}</h5>
                        <p class="text-muted mb-0">{{ $user->email }}</p>
                    </div>
                    
                    <div class="list-group list-group-flush">
                        <a href="#profile" class="list-group-item list-group-item-action {{ request()->is('profile') ? 'active' : '' }}" data-bs-toggle="list">
                            <i class="fas fa-user me-2"></i> Profile Information
                        </a>
                        <a href="#security" class="list-group-item list-group-item-action {{ request()->is('profile/security') ? 'active' : '' }}" data-bs-toggle="list">
                            <i class="fas fa-shield-alt me-2"></i> Security
                        </a>
                        <a href="#notifications" class="list-group-item list-group-item-action {{ request()->is('profile/notifications') ? 'active' : '' }}" data-bs-toggle="list">
                            <i class="fas fa-bell me-2"></i> Notifications
                        </a>
                        <a href="#delete" class="list-group-item list-group-item-action text-danger {{ request()->is('profile/delete') ? 'active' : '' }}" data-bs-toggle="list">
                            <i class="fas fa-trash-alt me-2"></i> Delete Account
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="tab-content">
                        <!-- Profile Information Tab -->
                        <div class="tab-pane fade {{ request()->is('profile') ? 'show active' : '' }}" id="profile">
                            @include('profile.partials.update-profile-information-form')
                        </div>

                        <!-- Security Tab -->
                        <div class="tab-pane fade {{ request()->is('profile/security') ? 'show active' : '' }}" id="security">
                            @include('profile.partials.update-password-form')
                        </div>

                        <!-- Notifications Tab -->
                        <div class="tab-pane fade {{ request()->is('profile/notifications') ? 'show active' : '' }}" id="notifications">
                            <header class="mb-4">
                                <h2 class="h5 mb-1">Notification Preferences</h2>
                                <p class="text-muted mb-0">Manage your notification settings.</p>
                            </header>

                            <form method="post" action="{{ route('profile.notifications.update') }}" class="mt-4">
                                @csrf
                                @method('patch')

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title h6 mb-4">Email Notifications</h5>
                                        <div class="mb-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="email_notifications" name="email_notifications" {{ $user->email_notifications ? 'checked' : '' }}>
                                                <label class="form-check-label" for="email_notifications">Receive email notifications</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title h6 mb-4">Push Notifications</h5>
                                        <div class="mb-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="push_notifications" name="push_notifications" {{ $user->push_notifications ? 'checked' : '' }}>
                                                <label class="form-check-label" for="push_notifications">Receive push notifications</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card border-0 shadow-sm mb-4">
                                    <div class="card-body">
                                        <h5 class="card-title h6 mb-4">SMS Notifications</h5>
                                        <div class="mb-4">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="sms_notifications" name="sms_notifications" {{ $user->sms_notifications ? 'checked' : '' }}>
                                                <label class="form-check-label" for="sms_notifications">Receive SMS notifications</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex align-items-center gap-3">
                                    <button type="submit" class="btn btn-primary">Save</button>

                                    @if (session('status') === 'notifications-updated')
                                        <p class="text-success mb-0">Saved.</p>
                                    @endif
                                </div>
                            </form>
                        </div>

                        <!-- Delete Account Tab -->
                        <div class="tab-pane fade {{ request()->is('profile/delete') ? 'show active' : '' }}" id="delete">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.list-group-item {
    border: none;
    padding: 0.75rem 1rem;
    color: #4B5563;
    transition: all 0.2s;
}

.list-group-item:hover {
    background-color: #F3F4F6;
    color: #1F2937;
}

.list-group-item.active {
    background-color: #EEF2FF;
    color: #4F46E5;
    border-right: 3px solid #4F46E5;
}

.card {
    border: none;
    border-radius: 0.5rem;
}

.tab-content {
    padding: 1rem 0;
}

.form-check-input:checked {
    background-color: #4F46E5;
    border-color: #4F46E5;
}

.form-switch .form-check-input {
    width: 3em;
    height: 1.5em;
    margin-top: 0.25em;
}

.form-switch .form-check-input:focus {
    box-shadow: 0 0 0 0.2rem rgba(79, 70, 229, 0.25);
}
</style> 