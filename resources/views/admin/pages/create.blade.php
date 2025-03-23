@extends('layouts.admin')

@section('title', 'Create New Page')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Create New Page</h1>
        <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Pages
        </a>
    </div>

    <form action="{{ route('admin.pages.store') }}" method="POST">
        @csrf
        @include('admin.pages._form')

        <div class="mt-4">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Create Page
            </button>
        </div>
    </form>
</div>
@endsection