@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <!-- Total Emirates -->
    <div class="col-md-6 col-lg-3">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-globe fa-2x"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Total Emirates</h6>
                    <h3 class="mb-0">{{ \App\Models\Emirate::count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Markets -->
    <div class="col-md-6 col-lg-3">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-success bg-opacity-10 text-success">
                    <i class="fas fa-store fa-2x"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Total Markets</h6>
                    <h3 class="mb-0">{{ \App\Models\Market::count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Branches -->
    <div class="col-md-6 col-lg-3">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-code-branch fa-2x"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Total Branches</h6>
                    <h3 class="mb-0">{{ \App\Models\Branch::count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Offers -->
    <div class="col-md-6 col-lg-3">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-info bg-opacity-10 text-info">
                    <i class="fas fa-tag fa-2x"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Total Offers</h6>
                    <h3 class="mb-0">{{ \App\Models\Offer::count() }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="bg-white rounded-lg shadow-sm p-4">
    <h5 class="mb-4">Recent Activity</h5>
    <div class="timeline">
        @foreach(\App\Models\Offer::with(['branches.market'])->latest()->take(5)->get() as $offer)
            <div class="timeline-item">
                <div class="timeline-marker bg-info text-white">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="timeline-content">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="mb-1">New offer "{{ $offer->title }}" was created</h6>
                            <p class="text-muted mb-0">Available at {{ $offer->branches->pluck('market.name')->implode(', ') }}</p>
                        </div>
                        <small class="text-muted">{{ $offer->created_at->diffForHumans() }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
.timeline {
    position: relative;
    padding: 20px 0;
}

.timeline-item {
    position: relative;
    padding-left: 40px;
    margin-bottom: 20px;
}

.timeline-item:last-child {
    margin-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: 0;
    top: 0;
    width: 30px;
    height: 30px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.timeline-content {
    background: #f8f9fa;
    padding: 15px;
    border-radius: 4px;
}

.timeline-item:not(:last-child)::before {
    content: '';
    position: absolute;
    left: 15px;
    top: 30px;
    bottom: -20px;
    width: 2px;
    background: #e9ecef;
}
</style>
@endsection
