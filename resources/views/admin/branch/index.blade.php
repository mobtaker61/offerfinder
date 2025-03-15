@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Branch Management</h2>
    <a href="{{ route('branches.create') }}" class="btn btn-primary my-3">Add New Branch</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Market</th>
                <th>Name</th>
                <th>Location</th>
                <th>Address</th>
                <th>Working Hours</th>
                <th>Customer Service</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($branches as $branch)
                <tr>
                    <td>{{ $branch->market->name }}</td>
                    <td>{{ $branch->name }}</td>
                    <td>{{ $branch->location }}</td>
                    <td>{{ $branch->address }}</td>
                    <td>{{ $branch->working_hours }}</td>
                    <td>{{ $branch->customer_service }}</td>
                    <td>
                        <a href="{{ route('branches.edit', $branch) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('branches.destroy', $branch) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                        <a href="{{ route('offers.index', ['branch_id' => $branch->id]) }}" class="btn btn-success btn-sm">Offers</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="d-flex justify-content-center mt-4">
        {{ $branches->links() }}
    </div>
</div>
@endsection
