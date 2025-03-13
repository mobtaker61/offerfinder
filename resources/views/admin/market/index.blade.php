@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="my-4">Market List</h2>

    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Logo</th>
                <th>Website</th>
                <th>App Link</th>
                <th>WhatsApp</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($markets as $market)
                <tr>
                    <td>{{ $market->name }}</td>
                    <td>
                        @if($market->logo)
                            <img src="{{ asset('storage/' . $market->logo) }}" alt="{{ $market->name }}" width="50">
                        @else
                            No Logo
                        @endif
                    </td>
                    <td>{{ $market->website }}</td>
                    <td>{{ $market->app_link }}</td>
                    <td>{{ $market->whatsapp }}</td>
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
