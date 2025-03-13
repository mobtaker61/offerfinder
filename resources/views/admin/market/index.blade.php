@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">Manage Markets</h2>

    <a href="{{ route('markets.create') }}" class="btn btn-primary mb-3">Add New Market</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Logo</th>
                <th>#</th>
                <th>Name</th>
                <th>Website</th>
                <th>App Link</th>
                <th>WhatsApp</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($markets as $market)
                <tr>
                    <td>
                        @if ($market->logo)
                            <img src="{{ asset('storage/' . $market->logo) }}" width="50">
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $market->id }}</td>
                    <td>{{ $market->name }}</td>
                    <td>{{ $market->website }}</td>
                    <td>{{ $market->app_link }}</td>
                    <td>{{ $market->whatsapp }}</td>
                    <td>
                        <a href="{{ route('markets.edit', $market) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('markets.destroy', $market) }}" method="POST" class="d-inline">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
