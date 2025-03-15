@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Emirates</h2>
    <a href="{{ route('emirates.create') }}" class="btn btn-primary my-3">Add New Emirate</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($emirates as $emirate)
                <tr>
                    <td>{{ $emirate->name }}</td>
                    <td>
                        <a href="{{ route('emirates.edit', $emirate->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('emirates.destroy', $emirate->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('markets.index', ['emirate_id' => $emirate->id]) }}" class="btn btn-info btn-sm">Markets</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection