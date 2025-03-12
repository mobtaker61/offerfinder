@extends('layouts.app')

@section('content')
<!-- Include Latest CKEditor -->
<script src="https://cdn.ckeditor.com/4.25.1-lts/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>

<div class="card shadow-sm">
    <div class="card-body">
        <h2 class="card-title">Send Push Notification</h2>

        <form action="{{ route('notifications.store') }}" method="POST">
            @csrf

            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>

            <label class="form-label mt-3">Message</label>
            <textarea name="message" class="form-control" required></textarea>

            <button class="btn btn-success mt-3">Send Notification</button>
        </form>
    </div>
</div>
@endsection
