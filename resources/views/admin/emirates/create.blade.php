@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Add New Emirate</h2>

    <form action="{{ route('emirates.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Save Emirate</button>
    </form>
</div>
@endsection