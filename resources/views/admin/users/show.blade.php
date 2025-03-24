@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">User Details</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-4">
                            @if($user->avatar)
                                <img src="{{ Storage::url($user->avatar) }}" alt="User Avatar" class="img-thumbnail" style="max-width: 200px;">
                            @else
                                <div class="avatar-placeholder-large">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Basic Information</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Name</th>
                                            <td>{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <th>User Type</th>
                                            <td>
                                                <span class="badge badge-{{ $user->user_type === 'webmaster' ? 'danger' : ($user->user_type === 'admin' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($user->user_type) }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Status</th>
                                            <td>
                                                <span class="badge badge-{{ $user->is_active ? 'success' : 'danger' }}">
                                                    {{ $user->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Created At</th>
                                            <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Last Updated</th>
                                            <td>{{ $user->updated_at->format('Y-m-d H:i:s') }}</td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h5>Contact Information</h5>
                                    <table class="table table-bordered">
                                        <tr>
                                            <th>Phone</th>
                                            <td>{{ $user->phone ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Location</th>
                                            <td>{{ $user->location ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Birth Date</th>
                                            <td>{{ $user->birth_date ? $user->birth_date->format('Y-m-d') : 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Gender</th>
                                            <td>{{ ucfirst($user->gender ?? 'N/A') }}</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Bio</h5>
                            <p class="text-muted">{{ $user->bio ?? 'No bio available.' }}</p>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Social Media Links</h5>
                            <div class="social-links">
                                @if($user->facebook_url)
                                    <a href="{{ $user->facebook_url }}" target="_blank" class="btn btn-facebook">
                                        <i class="fab fa-facebook"></i> Facebook
                                    </a>
                                @endif
                                @if($user->twitter_url)
                                    <a href="{{ $user->twitter_url }}" target="_blank" class="btn btn-twitter">
                                        <i class="fab fa-twitter"></i> Twitter
                                    </a>
                                @endif
                                @if($user->instagram_url)
                                    <a href="{{ $user->instagram_url }}" target="_blank" class="btn btn-instagram">
                                        <i class="fab fa-instagram"></i> Instagram
                                    </a>
                                @endif
                                @if($user->linkedin_url)
                                    <a href="{{ $user->linkedin_url }}" target="_blank" class="btn btn-linkedin">
                                        <i class="fab fa-linkedin"></i> LinkedIn
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <h5>Notification Preferences</h5>
                            <table class="table table-bordered">
                                <tr>
                                    <th>Newsletter Subscription</th>
                                    <td>
                                        <span class="badge badge-{{ $user->newsletter ? 'success' : 'secondary' }}">
                                            {{ $user->newsletter ? 'Subscribed' : 'Not Subscribed' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Email Notifications</th>
                                    <td>
                                        <span class="badge badge-{{ $user->email_notifications ? 'success' : 'secondary' }}">
                                            {{ $user->email_notifications ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Push Notifications</th>
                                    <td>
                                        <span class="badge badge-{{ $user->push_notifications ? 'success' : 'secondary' }}">
                                            {{ $user->push_notifications ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>SMS Notifications</th>
                                    <td>
                                        <span class="badge badge-{{ $user->sms_notifications ? 'success' : 'secondary' }}">
                                            {{ $user->sms_notifications ? 'Enabled' : 'Disabled' }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit User
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back to List
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.avatar-placeholder-large {
    width: 200px;
    height: 200px;
    background-color: #f8f9fa;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #6c757d;
    font-size: 5rem;
    margin: 0 auto;
}

.social-links {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.btn-facebook {
    background-color: #3b5998;
    color: white;
}

.btn-twitter {
    background-color: #1da1f2;
    color: white;
}

.btn-instagram {
    background-color: #e4405f;
    color: white;
}

.btn-linkedin {
    background-color: #0077b5;
    color: white;
}

.btn-facebook:hover,
.btn-twitter:hover,
.btn-instagram:hover,
.btn-linkedin:hover {
    color: white;
    opacity: 0.9;
}
</style>
@endsection 