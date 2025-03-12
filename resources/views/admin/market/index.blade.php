@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded shadow-md">
    <h2 class="text-xl font-bold">Manage Markets</h2>

    <a href="{{ route('markets.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded">Add New Market</a>

    <table class="mt-4 w-full border">
        <thead>
            <tr class="bg-gray-200">
                <th class="border px-4 py-2">#</th>
                <th class="border px-4 py-2">Name</th>
                <th class="border px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($markets as $market)
                <tr>
                    <td class="border px-4 py-2">{{ $market->id }}</td>
                    <td class="border px-4 py-2">{{ $market->name }}</td>
                    <td class="border px-4 py-2">
                        <a href="{{ route('markets.edit', $market) }}" class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('markets.destroy', $market) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-2 py-1 rounded" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
