@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">Market List</h2>
    <a href="{{ route('market.create') }}" class="btn btn-primary my-3">Add New Market</a>

    <table class="table">
        <thead>
            <tr>
                <th>Logo</th>
                <th>Name</th>
                <th>Website</th>
                <th>App Link</th>
                <th>WhatsApp</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($markets as $market)
                <tr>
                    <td>
                        @if($market->logo)
                            <img src="{{ asset('storage/' . $market->logo) }}" alt="{{ $market->name }}" width="100">
                        @else
                            No Logo
                        @endif
                    </td>
                    <td>{{ $market->name }}</td>
                    <td>{{ $market->website }}</td>
                    <td><a href="{{ $market->app_link }}">{{ $market->name }} App</a></td>
                    <td><a href="https://wa.me/{{ $market->whatsapp }}">PM on Whatsapp </td>
                    <td>
                        <a href="{{ route('markets.edit', $market->id) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('markets.destroy', $market->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
