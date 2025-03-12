@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Market</h2>

    <form action="{{ route('markets.update', $market->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Market Name</label>
            <input type="text" name="name" class="form-control" value="{{ $market->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Current Logo</label><br>
            @if ($market->logo)
                <img src="{{ asset('storage/' . $market->logo) }}" width="100">
            @endif
        </div>

        <div class="mb-3">
            <label class="form-label">Change Logo</label>
            <input type="file" name="logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Update Market</button>
    </form>
</div>
@endsection
