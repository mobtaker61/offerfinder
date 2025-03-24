@extends('layouts.admin')

@section('title', 'Edit Blog Post')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Blog Post</h1>
        <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to List
        </a>
    </div>

    <form id="updateBlogForm" action="{{ route('admin.blog.update', $blog) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="row">
            <!-- Left Column - Main Content -->
            <div class="col-md-8">
                <div class="mb-3">
                    <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $blog->title) }}" required>
                    @error('title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="excerpt" class="form-label">Excerpt</label>
                    <textarea class="form-control @error('excerpt') is-invalid @enderror" id="excerpt" name="excerpt" rows="3">{{ old('excerpt', $blog->excerpt) }}</textarea>
                    @error('excerpt')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content <span class="text-danger">*</span></label>
                    <textarea class="form-control summernote @error('content') is-invalid @enderror" id="content" name="content" rows="10">{{ old('content', $blog->content) }}</textarea>
                    @error('content')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Right Column - Settings -->
            <div class="col-md-4">
                <div class="mb-3">
                    <label class="form-label">Featured Image</label>
                    <div class="d-flex flex-column align-items-center">
                        <div class="image-preview mb-3" style="width: 100%; max-width: 300px;">
                            <img id="preview" src="{{ $blog->image_url }}" alt="Preview" class="img-fluid rounded">
                        </div>
                        <div class="d-flex gap-2 w-100">
                            <div class="flex-grow-1">
                                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" accept="image/*">
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="button" class="btn btn-outline-danger" id="removeImage">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <small class="form-text text-muted mt-1">Recommended size: 1200x630 pixels</small>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="scope" class="form-label">Post Scope <span class="text-danger">*</span></label>
                    <select class="form-select @error('scope') is-invalid @enderror" id="scope" name="scope" required>
                        <option value="global" {{ old('scope', $blog->scope) == 'global' ? 'selected' : '' }}>Global (All Users)</option>
                        <option value="market" {{ old('scope', $blog->scope) == 'market' ? 'selected' : '' }}>Specific Market</option>
                        <option value="branch" {{ old('scope', $blog->scope) == 'branch' ? 'selected' : '' }}>Specific Branch</option>
                    </select>
                    @error('scope')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="market-branch-selects" style="display: none;">
                    <input type="hidden" id="old_branch_id" value="{{ old('branch_id', $blog->branch_id ?? '') }}">
                    <div class="row g-2">
                        <div class="col-12 col-sm-6 market-select">
                            <label for="market_id" class="form-label">Select Market</label>
                            <select class="form-select @error('market_id') is-invalid @enderror" id="market_id" name="market_id">
                                <option value="">Select a Market</option>
                                @foreach($markets as $market)
                                    <option value="{{ $market->id }}" {{ old('market_id', $blog->market_id) == $market->id ? 'selected' : '' }}>
                                        {{ $market->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('market_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12 col-sm-6 branch-select">
                            <label for="branch_id" class="form-label">Select Branch</label>
                            <select class="form-select @error('branch_id') is-invalid @enderror" id="branch_id" name="branch_id">
                                <option value="">Select a Branch</option>
                                @if($blog->branch)
                                    <option value="{{ $blog->branch->id }}" selected>{{ $blog->branch->name }}</option>
                                @endif
                            </select>
                            @error('branch_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title" value="{{ old('meta_title', $blog->meta_title) }}">
                    @error('meta_title')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description" name="meta_description" rows="3">{{ old('meta_description', $blog->meta_description) }}</textarea>
                    @error('meta_description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" name="is_active" value="1" {{ old('is_active', $blog->is_active) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_active">Active</label>
                        @error('is_active')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary mb-2">Update Post</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote-bs5.css" />
<style>
    .image-preview {
        position: relative;
        background-color: #f8f9fa;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        padding: 0.5rem;
    }

    .image-preview img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .market-branch-selects {
        margin-bottom: 1rem;
    }
</style>
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
            ]
        });

        // Image Preview
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('.image-preview').show();
                    $('#preview').attr('src', e.target.result);
                    $('#removeImage').show();
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#image").change(function() {
            readURL(this);
        });

        // Remove Image
        $('#removeImage').click(function() {
            $('#image').val('');
            $('.image-preview').hide();
            $('#preview').attr('src', '#');
            $(this).hide();
        });

        // Handle scope selection
        $('#scope').change(function() {
            const marketBranchSelects = $('.market-branch-selects');
            const marketSelect = $('.market-select');
            const branchSelect = $('.branch-select');
            const marketId = $('#market_id');
            const branchId = $('#branch_id');

            // Reset values and hide all
            marketId.val('');
            branchId.val('');
            marketBranchSelects.hide();
            marketSelect.hide();
            branchSelect.hide();

            // Show relevant fields based on scope
            switch(this.value) {
                case 'market':
                    marketBranchSelects.show();
                    marketSelect.show();
                    break;
                case 'branch':
                    marketBranchSelects.show();
                    marketSelect.show();
                    branchSelect.show();
                    break;
            }
        });

        // Handle market selection for branches
        $('#market_id').change(function() {
            const marketId = $(this).val();
            const branchSelect = $('#branch_id');
            
            if (marketId && $('#scope').val() === 'branch') {
                // Fetch branches for selected market
                $.get(`/admin/get-branches-by-market/${marketId}`, function(data) {
                    branchSelect.empty();
                    branchSelect.append('<option value="">Select a Branch</option>');
                    
                    data.forEach(function(branch) {
                        branchSelect.append(`<option value="${branch.id}">${branch.name}</option>`);
                    });

                    // If there's a previously selected branch, select it
                    const oldBranchId = $('#old_branch_id').val();
                    if (oldBranchId) {
                        branchSelect.val(oldBranchId);
                    }
                });
            }
        });

        // Trigger initial states
        $('#scope').trigger('change');
        if ($('#market_id').val() && $('#scope').val() === 'branch') {
            $('#market_id').trigger('change');
        }
    });
</script>
@endsection