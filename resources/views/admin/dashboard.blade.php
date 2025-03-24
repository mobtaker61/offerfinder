@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4 mb-4" id="total-stats">
    <!-- Total Offers -->
    <div class="col-md-6 col-lg-3">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-primary bg-opacity-10 text-primary">
                    <i class="fas fa-tag fa-2x"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Total Offers</h6>
                    <h3 class="mb-0">{{ $stats['total_offers'] }}</h3>
                    <small class="text-success">{{ $additionalStats['active_offers'] }} Active</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Views -->
    <div class="col-md-6 col-lg-3">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-info bg-opacity-10 text-info">
                    <i class="fas fa-eye fa-2x"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Total Views</h6>
                    <h3 class="mb-0">{{ number_format($stats['total_views']) }}</h3>
                    <small class="text-muted">Offers</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Markets -->
    <div class="col-md-6 col-lg-3">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-success bg-opacity-10 text-success">
                    <i class="fas fa-store fa-2x"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Active Markets</h6>
                    <h3 class="mb-0">{{ $additionalStats['active_markets'] }}</h3>
                    <small class="text-muted">of {{ $stats['total_markets'] }} Total</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Active Branches -->
    <div class="col-md-6 col-lg-3">
        <div class="p-4 bg-white rounded-lg shadow-sm">
            <div class="d-flex align-items-center">
                <div class="p-3 rounded-circle bg-warning bg-opacity-10 text-warning">
                    <i class="fas fa-code-branch fa-2x"></i>
                </div>
                <div class="ms-3">
                    <h6 class="text-muted mb-1">Active Branches</h6>
                    <h3 class="mb-0">{{ $additionalStats['active_branches'] }}</h3>
                    <small class="text-muted">of {{ $stats['total_branches'] }} Total</small>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Visit Statistics Chart -->
    <div class="col-md-8">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Visit Statistics (Last 7 Days)</h5>
            </div>
            <canvas id="visitChart" height="300" data-stats='@json($visitStats)'></canvas>
        </div>
    </div>

    <!-- Top Viewed Offers -->
    <div class="col-md-4">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Top Viewed Offers</h5>
                <a href="{{ route('admin.offers.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Views</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topViewedOffers as $offer)
                            <tr>
                                <td>{{ Str::limit($offer['title'], 30) }}</td>
                                <td>{{ number_format($offer['views']) }}</td>
                                <td>{{ $offer['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Latest Offers -->
    <div class="col-md-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Latest Offers</h5>
                <a href="{{ route('admin.offers.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Market</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestOffers as $offer)
                            <tr>
                                <td>{{ Str::limit($offer['title'], 30) }}</td>
                                <td>{{ $offer['market'] }}</td>
                                <td>
                                    <span class="badge bg-{{ $offer['status'] ? 'success' : 'danger' }}">
                                        {{ $offer['status'] ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $offer['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Latest Blog Posts -->
    <div class="col-md-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Latest Blog Posts</h5>
                <a href="{{ route('admin.blog.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestBlogPosts as $post)
                            <tr>
                                <td>{{ Str::limit($post['title'], 30) }}</td>
                                <td>{{ $post['author'] }}</td>
                                <td>
                                    <span class="badge bg-{{ $post['status'] ? 'success' : 'warning' }}">
                                        {{ $post['status'] ? 'Published' : 'Draft' }}
                                    </span>
                                </td>
                                <td>{{ $post['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Latest Users -->
    <div class="col-md-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Latest Users</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Joined</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestUsers as $user)
                            <tr>
                                <td>{{ $user['name'] }}</td>
                                <td>{{ $user['email'] }}</td>
                                <td>
                                    <span class="badge bg-{{ $user['status'] ? 'success' : 'danger' }}">
                                        {{ $user['status'] ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $user['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Latest Branches -->
    <div class="col-md-6">
        <div class="bg-white rounded-lg shadow-sm p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5 class="mb-0">Latest Branches</h5>
                <a href="{{ route('admin.branches.index') }}" class="btn btn-sm btn-primary">View All</a>
            </div>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Market</th>
                            <th>Neighbours</th>
                            <th>Status</th>
                            <th>Created</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($latestBranches as $branch)
                            <tr>
                                <td>{{ $branch['name'] }}</td>
                                <td>{{ $branch['market'] }}</td>
                                <td>
                                    @foreach($branch['neighbours'] as $neighbour)
                                        <span class="badge bg-secondary me-1">{{ $neighbour }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge bg-{{ $branch['status'] ? 'success' : 'danger' }}">
                                        {{ $branch['status'] ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td>{{ $branch['created_at'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('visitChart').getContext('2d');
    const visitData = JSON.parse(document.getElementById('visitChart').dataset.stats);

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: visitData.map(item => item.date),
            datasets: [{
                label: 'Daily Views',
                data: visitData.map(item => item.views),
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1,
                fill: true,
                backgroundColor: 'rgba(75, 192, 192, 0.1)'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString();
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush

<style>
.table th {
    font-weight: 600;
    font-size: 0.875rem;
}

.table td {
    font-size: 0.875rem;
}

.badge {
    font-size: 0.75rem;
    padding: 0.35em 0.65em;
}

#total-stats .col-md-6 {
    height: 100%;
}

#total-stats .col-md-6 > div {
    height: 100%;
    display: flex;
    flex-direction: column;
}

#total-stats .col-md-6 > div > div {
    flex: 1;
    display: flex;
    align-items: center;
}
</style>
@endsection
