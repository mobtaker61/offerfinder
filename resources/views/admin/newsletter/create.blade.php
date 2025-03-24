@extends('layouts.admin')

@section('title', 'Create New Newsletter')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Newsletter</h1>
        <a href="{{ route('admin.newsletters.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <form action="{{ route('admin.newsletters.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="subject" class="form-label">Subject <span class="text-danger">*</span></label>
            <input type="text" name="subject" id="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
            @error('subject')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="content" class="form-label">Newsletter Content <span class="text-danger">*</span></label>
            <textarea name="content" id="content" class="form-control summernote @error('content') is-invalid @enderror" rows="5" required>{{ old('content') }}</textarea>
            @error('content')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="text-end">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Newsletter
            </button>
        </div>
    </form>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.css" />
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Summernote
        $('#content').summernote({
            height: 300,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            callbacks: {
                onImageUpload: function(files) {
                    // You can implement image upload functionality here if needed
                    for (let i = 0; i < files.length; i++) {
                        const reader = new FileReader();
                        reader.onloadend = function() {
                            const img = document.createElement('img');
                            img.src = reader.result;
                            $('#content').summernote('insertNode', img);
                        }
                        reader.readAsDataURL(files[i]);
                    }
                }
            }
        });
    });
</script>
@endsection
