@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Branch</h2>

    <form action="{{ route('branches.update', $branch->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Emirate</label>
            <select name="emirate_id" class="form-control" required>
                <option value="">Select Emirate</option>
                @foreach ($emirates as $emirate)
                    <option value="{{ $emirate->id }}" {{ $branch->emirate_id == $emirate->id ? 'selected' : '' }}>{{ $emirate->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Market</label>
            <select name="market_id" class="form-control" required>
                <option value="">Select Market</option>
                @foreach ($markets as $market)
                    <option value="{{ $market->id }}" {{ $branch->market_id == $market->id ? 'selected' : '' }}>{{ $market->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Branch Name</label>
            <input type="text" name="name" class="form-control" value="{{ $branch->name }}" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Location</label>
            <input type="text" name="location" class="form-control" value="{{ $branch->location }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control">{{ $branch->address }}</textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Working Hours</label>
            <input type="text" name="working_hours" class="form-control" value="{{ $branch->working_hours }}">
        </div>

        <div class="mb-3">
            <label class="form-label">Customer Service</label>
            <input type="text" name="customer_service" class="form-control" value="{{ $branch->customer_service }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Branch</button>
    </form>
</div>
@endsection
