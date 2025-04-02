@props(['branch'])

<div class="card branch-card h-100">
    <div class="card-body p-0">
        <div class="row g-0">
            <!-- Left Side - Market Avatar -->
            <div class="col-4 branch-avatar-wrapper">
                <div class="branch-avatar">
                    <img src="{{ $branch->market->logo ? asset('storage/' . $branch->market->avatar) : 'https://via.placeholder.com/150' }}"
                        alt="{{ $branch->market->name }}"
                        class="img-fluid rounded-start">
                </div>
            </div>

            <!-- Right Side - Branch Information -->
            <div class="col-8">
                <div class="card-body">
                    <a href="{{ route('front.branch.show', ['branch' => $branch->slug]) }}" class="text-decoration-none">
                        <h5 class="card-title mb-2" style="text-overflow: ellipsis; overflow: hidden; white-space: nowrap; max-width: 100%;">{{ $branch->name }}</h5>
                    </a>

                    <div class="text-muted small mb-2">
                        <i class="fas fa-tag me-1"></i>
                        {{ $branch->market->offers->where('status', 'active')->count() }} Active Offers
                    </div>

                    <div class="mb-2">
                        <a href="{{ route('front.market.show', ['market' => $branch->market->slug]) }}"
                            class="text-decoration-none text-primary">
                            <i class="fas fa-store me-1"></i>
                            {{ $branch->market->name }}
                        </a>
                    </div>

                    <div class="location-info small mb-2">
                        @if($branch->latitude && $branch->longitude)
                        <a href="https://www.google.com/maps?q={{ $branch->latitude }},{{ $branch->longitude }}"
                            target="_blank"
                            class="text-decoration-none text-secondary">
                            <i class="fas fa-map-marker-alt me-1"></i>
                            @else
                            <i class="fas fa-map-marker-alt me-1"></i>
                            @endif
                            @if($branch->neighbours->first())
                            {{ $branch->neighbours->first()->district->emirate->name }} >
                            {{ $branch->neighbours->first()->district->name }} >
                            {{ $branch->neighbours->first()->name }}
                            @endif
                            @if($branch->latitude && $branch->longitude)
                        </a>
                        @endif
                    </div>

                    <div class="branch-actions mt-2">
                        @foreach($branch->contactProfiles as $contact)
                        @switch($contact->type)
                        @case('whatsapp')
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $contact->value) }}"
                            target="_blank"
                            class="btn btn-outline-success btn-sm"
                            title="WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        @break
                        @case('phone')
                        <a href="tel:{{ $contact->value }}"
                            class="btn btn-outline-primary btn-sm"
                            title="Call">
                            <i class="fas fa-phone"></i>
                        </a>
                        @break
                        @case('email')
                        <a href="mailto:{{ $contact->value }}"
                            class="btn btn-outline-secondary btn-sm"
                            title="Email">
                            <i class="fas fa-envelope"></i>
                        </a>
                        @break
                        @case('instagram')
                        <a href="https://instagram.com/{{ ltrim($contact->value, '@') }}"
                            target="_blank"
                            class="btn btn-outline-danger btn-sm"
                            title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        @break
                        @case('facebook')
                        <a href="{{ $contact->value }}"
                            target="_blank"
                            class="btn btn-outline-primary btn-sm"
                            title="Facebook">
                            <i class="fab fa-facebook"></i>
                        </a>
                        @break
                        @case('twitter')
                        <a href="https://twitter.com/{{ ltrim($contact->value, '@') }}"
                            target="_blank"
                            class="btn btn-outline-info btn-sm"
                            title="Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        @break
                        @endswitch
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .branch-card {
        transition: transform 0.2s;
        border: 1px solid rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .branch-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .branch-avatar-wrapper {
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .branch-avatar {
        width: 100%;
        padding-bottom: 100%;
        position: relative;
    }

    .branch-avatar img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: contain;
    }

    .location-info {
        color: #6c757d;
    }

    .branch-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .branch-actions .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 32px;
        height: 32px;
        padding: 0;
    }

    .branch-actions .btn i {
        font-size: 1rem;
    }
</style>