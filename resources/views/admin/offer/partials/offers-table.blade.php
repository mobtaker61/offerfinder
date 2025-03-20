@forelse($offers as $offer)
    <tr>
        <td>{{ $offer->title }}</td>
        <td>{{ $offer->market ? $offer->market->name : 'N/A' }}</td>
        <td>{{ $offer->branches->pluck('name')->implode(', ') }}</td>
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
                       data-offer-id="{{ $offer->id }}">
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