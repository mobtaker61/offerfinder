@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Market List</h1>
        <a href="{{ route('admin.markets.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Add New Market
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Logo</th>
                    <th>Name</th>
                    <th>Local Name</th>
                    <th>Website</th>
                    <th>Apps</th>
                    <th>WhatsApp</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($markets as $market)
                <tr>
                    <td class="text-center">
                        @if($market->logo)
                        <img src="{{ asset('storage/' . $market->logo) }}" alt="{{ $market->name }}" width="100" class="img-thumbnail">
                        @else
                        <div class="text-muted">No Logo</div>
                        @endif
                    </td>
                    <td>{{ $market->name }}</td>
                    <td>{{ $market->local_name ?? '-' }}</td>
                    <td>
                        @if($market->website)
                        <a href="{{ $market->website }}" target="_blank" class="btn btn-sm btn-outline-primary">
                            <i class="fas fa-globe"></i> Visit Website
                        </a>
                        @else
                        <span class="text-muted">Not set</span>
                        @endif
                    </td>
                    <td>
                        <div class="btn-group">
                            @if($market->android_app_link)
                            <a href="{{ $market->android_app_link }}" target="_blank" class="btn btn-sm btn-outline-success" title="Android App">
                                <i class="fab fa-android"></i>
                            </a>
                            @endif
                            @if($market->ios_app_link)
                            <a href="{{ $market->ios_app_link }}" target="_blank" class="btn btn-sm btn-outline-dark" title="iOS App">
                                <i class="fab fa-apple"></i>
                            </a>
                            @endif
                        </div>
                    </td>
                    <td>
                        @if($market->whatsapp)
                        <a href="https://wa.me/{{ $market->whatsapp }}" target="_blank" class="btn btn-sm btn-outline-info">
                            <i class="fab fa-whatsapp"></i> Contact
                        </a>
                        @else
                        <span class="text-muted">Not set</span>
                        @endif
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input status-switch" type="checkbox"
                                data-market-id="{{ $market->id }}"
                                {{ $market->is_active ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.markets.edit', $market->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.markets.destroy', $market->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this market?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                            <a href="{{ route('admin.branches.index', ['market_id' => $market->id]) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-store"></i>
                            </a>
                            <a href="{{ route('admin.offers.index', ['market_id' => $market->id]) }}" class="btn btn-success btn-sm">
                                <i class="fas fa-tag"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const statusSwitches = document.querySelectorAll('.status-switch');

        statusSwitches.forEach(switchElement => {
            switchElement.addEventListener('change', function() {
                const marketId = this.dataset.marketId;
                const isActive = this.checked;

                fetch(`/admin/markets/${marketId}/toggle-status`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            is_active: isActive
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Show success toast
                            const toast = new bootstrap.Toast(document.createElement('div'));
                            toast.show();
                        } else {
                            // Revert switch if failed
                            this.checked = !isActive;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        this.checked = !isActive;
                    });
            });
        });
    });
</script>
@endpush
@endsection