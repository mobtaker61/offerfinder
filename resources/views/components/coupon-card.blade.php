@props(['coupon'])

<div class="coupon-card" data-bs-toggle="modal" data-bs-target="#couponModal{{ $coupon->id }}" style="cursor: pointer;">
<div class="coupon-background" data-bg-image="{{ $coupon->image ? Storage::url($coupon->image) : asset('images/placeholder.jpg') }}">
        <div class="coupon-overlay">
            <!-- Top Section -->
            <div class="coupon-top">
                <div class="market-info">
                    @if($coupon->couponable_type === 'App\Models\Market')
                    @if($coupon->couponable->avatar)
                    <img src="{{ Storage::url($coupon->couponable->avatar) }}" alt="{{ $coupon->couponable->name }}" class="market-avatar">
                    @else
                    <div class="market-avatar-placeholder">
                        <i class="fas fa-store"></i>
                    </div>
                    @endif
                    @else
                    @if($coupon->couponable->market->avatar)
                    <img src="{{ Storage::url($coupon->couponable->market->avatar) }}" alt="{{ $coupon->couponable->market->name }}" class="market-avatar">
                    @else
                    <div class="market-avatar-placeholder">
                        <i class="fas fa-store"></i>
                    </div>
                    @endif
                    @endif
                </div>
                <div class="coupon-status">
                    @if($coupon->is_unlimited)
                    <span class="badge bg-success">Unlimited</span>
                    @else
                    <span class="badge bg-primary">{{ $coupon->used_count }}/{{ $coupon->usage_limit }}</span>
                    @endif
                </div>
            </div>

            <!-- Bottom Section -->
            <div class="coupon-bottom">
                <div class="coupon-actions">
                    <div class="validity-info">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Valid until {{ $coupon->end_date->format('M d, Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Coupon Details Modal -->
<div class="modal fade" id="couponModal{{ $coupon->id }}" tabindex="-1" aria-labelledby="couponModalLabel{{ $coupon->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header border-0">
                <h5 class="modal-title" id="couponModalLabel{{ $coupon->id }}">Coupon Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="row g-0">
                    <!-- Left Column -->
                    <div class="col-md-7 p-4">
                        <img src="{{ $coupon->image ? Storage::url($coupon->image) : asset('images/placeholder.jpg') }}" alt="{{ $coupon->title }}" class="img img-fluid" style="width: 100%;">

                        <h3 class="mb-3">{{ $coupon->title }}</h3>
                        <p class="text-muted mb-4">{{ $coupon->description }}</p>
                    </div>
                    <!-- Right Column -->
                    <div class="col-md-5 p-4">
                        <div class="coupon-info">
                            <div class="info-item mb-3">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>
                                <span>Valid from {{ $coupon->start_date->format('M d, Y') }} to {{ $coupon->end_date->format('M d, Y') }}</span>
                            </div>
                            <div class="info-item mb-3">
                                <i class="fas fa-ticket-alt text-primary me-2"></i>
                                <span>
                                    @if($coupon->is_unlimited)
                                    Unlimited usage / {{ $coupon->used_count }} times used
                                    @else
                                    {{ $coupon->used_count }} of {{ $coupon->usage_limit }} times used
                                    @endif
                                </span>
                            </div>
                            <div class="d-flex align-items-center mb-3">
                                @if($coupon->couponable_type === 'App\Models\Market')
                                @if($coupon->couponable->avatar)
                                <img src="{{ Storage::url($coupon->couponable->avatar) }}" alt="{{ $coupon->couponable->name }}" class="market-avatar me-3">
                                @else
                                <div class="market-avatar-placeholder me-3">
                                    <i class="fas fa-store"></i>
                                </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $coupon->couponable->name }}</h6>
                                    <small class="text-muted">Market</small>
                                </div>
                                @else
                                @if($coupon->couponable->market->avatar)
                                <img src="{{ Storage::url($coupon->couponable->market->avatar) }}" alt="{{ $coupon->couponable->market->name }}" class="market-avatar me-3">
                                @else
                                <div class="market-avatar-placeholder me-3">
                                    <i class="fas fa-store"></i>
                                </div>
                                @endif
                                <div>
                                    <h6 class="mb-0">{{ $coupon->couponable->market->name }}</h6>
                                    <small class="text-muted">Market</small>
                                </div>
                                @endif
                            </div>
                        </div>

                        @if($coupon->couponable_type === 'App\Models\Branch')
                        <div class="branch-info">
                            <h6 class="mb-0">{{ $coupon->couponable->name }}</h6>
                            <small class="text-muted">Branch</small>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.coupon-background').forEach(el => {
    el.style.backgroundImage = `url('${el.dataset.bgImage}')`;
});
</script>