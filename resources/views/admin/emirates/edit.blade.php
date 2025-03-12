@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Emirate</h2>

    <form action="{{ route('emirates.update', $emirate->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $emirate->name }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Emirate</button>
    </form>
</div>
@endsection