@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">Add New Market</h2>

    <form action="{{ route('markets.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Market Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Market Logo</label>
            <input type="file" name="logo" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Website</label>
            <input type="url" name="website" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">App Link</label>
            <input type="url" name="app_link" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">WhatsApp</label>
            <input type="text" name="whatsapp" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Market</button>
    </form>
</div>
@endsection
