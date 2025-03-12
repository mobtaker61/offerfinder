@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Market</h2>

    <form action="{{ route('markets.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Market Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Market Logo</label>
            <input type="file" name="logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Save Market</button>
    </form>
</div>
@endsection
