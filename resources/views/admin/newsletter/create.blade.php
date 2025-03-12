@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create New Newsletter</h2>

    <form action="{{ route('newsletters.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Subject</label>
            <input type="text" name="subject" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Newsletter Content (HTML Supported)</label>
            <textarea name="content" id="editor" class="form-control" rows="5" required></textarea>
        </div>

        <button class="btn btn-primary">Create Newsletter</button>
    </form>
</div>

<!-- Include CKEditor -->
<script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor');
</script>
@endsection
