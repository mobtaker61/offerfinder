@extends('layouts.admin')

@section('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
@endsection

@push('scripts')
<script>
    $(function() {
        // Handle VIP toggle - unbind first to prevent double binding
        $('.vip-toggle').off('change').on('change', function() {
            const offerId = $(this).data('offer-id');
            const isVip = $(this).prop('checked');
            const $toggle = $(this);
            const $label = $toggle.next('label');
            const originalLabel = $label.text();

            // Show loading state
            $toggle.prop('disabled', true);
            $label.text('Updating...');

            $.ajax({
                url: `/admin/offers/${offerId}/toggle-vip`,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    vip: isVip ? 1 : 0
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('VIP status updated successfully');
                        $label.text(isVip ? 'VIP' : 'Regular');
                    } else {
                        toastr.error(response.message || 'Failed to update VIP status');
                        $toggle.prop('checked', !isVip);
                        $label.text(originalLabel);
                    }
                },
                error: function(xhr) {
                    toastr.error('Failed to update VIP status');
                    $toggle.prop('checked', !isVip);
                    $label.text(originalLabel);
                },
                complete: function() {
                    $toggle.prop('disabled', false);
                }
            });
        });

        // Handle delete - unbind first to prevent double binding
        let deleteOfferId = null;

        $('.delete-offer').off('click').on('click', function() {
            deleteOfferId = $(this).data('offer-id');
            $('#deleteModal').modal('show');
        });

        $('#confirmDelete').off('click').on('click', function() {
            if (!deleteOfferId) return;

            const $button = $(this);
            const originalText = $button.text();
            $button.prop('disabled', true)
                .html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Deleting...');

            $.ajax({
                url: `/admin/offers/${deleteOfferId}`,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        toastr.success('Offer deleted successfully');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000);
                    } else {
                        toastr.error(response.message || 'Failed to delete offer');
                    }
                },
                error: function(xhr) {
                    toastr.error('Error deleting offer');
                    $button.prop('disabled', false).text(originalText);
                },
                complete: function() {
                    $('#deleteModal').modal('hide');
                    deleteOfferId = null;
                }
            });
        });
    });
</script>
@endpush

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Offers Management</h2>
        <a href="{{ route('admin.offers.create') }}" class="btn btn-primary">Add New Offer</a>
    </div>

    <!-- Search Form -->
    <form action="{{ route('admin.offers.index') }}" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search offers..." value="{{ request('search') }}">
            <button type="submit" class="btn btn-outline-primary">Search</button>
        </div>
    </form>

    <!-- Sorting Options -->
    <div class="mb-3">
        <div class="btn-group">
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                class="btn btn-outline-secondary {{ request('sort') == 'title' ? 'active' : '' }}">
                Title
                @if(request('sort') == 'title')
                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                @endif
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'start_date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                class="btn btn-outline-secondary {{ request('sort') == 'start_date' ? 'active' : '' }}">
                Start Date
                @if(request('sort') == 'start_date')
                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                @endif
            </a>
            <a href="{{ request()->fullUrlWithQuery(['sort' => 'end_date', 'direction' => request('direction') == 'asc' ? 'desc' : 'asc']) }}"
                class="btn btn-outline-secondary {{ request('sort') == 'end_date' ? 'active' : '' }}">
                End Date
                @if(request('sort') == 'end_date')
                <i class="fas fa-sort-{{ request('direction') == 'asc' ? 'up' : 'down' }}"></i>
                @endif
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Market</th>
                    <th>Branches</th>
                    <th>Category</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Cover Image</th>
                    <th>PDF</th>
                    <th>VIP</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($offers as $offer)
                <tr>
                    <td>{{ $offer->title }}</td>
                    <td>{{ $offer->market ? $offer->market->name : 'N/A' }}</td>
                    <td>{{ $offer->branches->pluck('name')->implode(', ') }}</td>
                    <td>
                        @if($offer->category)
                            @if($offer->category->parent)
                                <small class="text-muted">{{ $offer->category->parent->name }} &raquo;</small><br>
                            @endif
                            {{ $offer->category->name }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $offer->start_date ? $offer->start_date->format('Y-m-d') : '' }}</td>
                    <td>{{ $offer->end_date ? $offer->end_date->format('Y-m-d') : '' }}</td>
                    <td>
                        @if($offer->cover_image)
                        <img src="{{ asset('storage/' . $offer->cover_image) }}" width="50" class="img-thumbnail">
                        @else
                        No Image
                        @endif
                    </td>
                    <td>
                        @if($offer->pdf)
                        <a href="{{ asset('storage/' . $offer->pdf) }}" target="_blank" class="btn btn-sm btn-warning">View PDF</a>
                        @else
                        No PDF
                        @endif
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input vip-toggle" type="checkbox"
                                {{ $offer->vip ? 'checked' : '' }}
                                data-offer-id="{{ $offer->id }}"
                                role="switch">
                            <label class="form-check-label">{{ $offer->vip ? 'VIP' : 'Regular' }}</label>
                        </div>
                    </td>
                    <td>
                        <a href="{{ route('admin.offers.edit', $offer->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <button class="btn btn-danger btn-sm delete-offer" data-offer-id="{{ $offer->id }}">Delete</button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center">No offers found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $offers->links() }}
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this offer?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
            </div>
        </div>
    </div>
</div>
@endsection