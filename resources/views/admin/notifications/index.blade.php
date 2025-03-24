@extends('layouts.admin')

@section('title', 'Notifications Management')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="card-title">Push Notifications</h2>

        <a href="{{ route('notifications.create') }}" class="btn btn-primary mb-3">Send New Notification</a>

        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($notifications as $notification)
                    <tr>
                        <td>{{ $notification->id }}</td>
                        <td>{{ $notification->title }}</td>
                        <td>{{ $notification->message }}</td>
                        <td>{{ $notification->created_at->format('d M Y h:i A') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
