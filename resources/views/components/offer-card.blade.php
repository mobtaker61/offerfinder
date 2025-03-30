@php
$markets = $offer->branches->groupBy('market.name');
$now = now();
$isExpired = $offer->end_date < $now;
$isUpcoming = $offer->start_date > $now;
$remainingDays = $isUpcoming 
    ? \App\Helpers\DateHelper::calculateRemainingDays($offer->start_date)
    : \App\Helpers\DateHelper::calculateRemainingDays($offer->end_date);
$backgroundImage = $offer->cover_image ? asset('storage/' . $offer->cover_image) : asset('images/default-cover.jpg');
@endphp

<div class="offer-card w-100 d-flex flex-column position-relative">
    <div class="offer-card-background">
        <div class="background-image {{ $isExpired || $isUpcoming ? 'grayscale' : '' }}" style="background-image: url('{{ $backgroundImage }}')"></div>
        @if($isExpired)
            <div class="status-badge expired-badge">Expired</div>
        @elseif($isUpcoming)
            <div class="status-badge upcoming-badge">Upcoming</div>
        @endif
        <div class="overlay"></div>
        <div class="offer-card-content">
            <div class="top-section w-100">
                <div class="d-flex justify-content-between align-items-center">
                    <!-- Market Avatars Overlay -->
                    @foreach ($markets as $marketName => $branches)
                    @php
                    $market = $branches->first()->market;
                    @endphp
                    <div class="market-avatar" title="{{ $marketName }}">
                        <img src="{{ $market->logo ? asset('storage/' . $market->avatar) : 'https://placehold.co/40x40?text=avatar' }}"
                            alt="{{ $marketName }}"
                            class="rounded-circle"
                            style="width: 40px; height: 40px;">
                    </div>
                    @endforeach
                    <!-- Share Button -->
                    <a href="#" class="wishlist text-white" target="_blank" id="shareBtn-{{ $offer->id }}"
                        data-id="{{ $offer->id }}" data-title="{{ $offer->title }}">
                        <i class="fa fa-share"></i>
                    </a>
                </div>
            </div>

            <div class="bottom-section">
                @if(!$isExpired)
                    <div class="countdown-section">
                        <div class="countdown-timer position-relative"
                            data-end-date="{{ $isUpcoming ? $offer->start_date : $offer->end_date }}"
                            data-is-upcoming="{{ $isUpcoming ? 'true' : 'false' }}">
                            <label class="position-absolute">
                                {{ $isUpcoming ? 'Offer starts in...' : 'Offer ends in...' }}
                            </label>
                            <div class="d-flex justify-content-evenly">
                                <div class="time-block">
                                    <span class="days">{{ $remainingDays }}</span>
                                    <small>DAYS</small>
                                </div>
                                <div class="separator">:</div>
                                <div class="time-block">
                                    <span class="hours">00</span>
                                    <small>HOURS</small>
                                </div>
                                <div class="separator">:</div>
                                <div class="time-block">
                                    <span class="minutes">00</span>
                                    <small>MINS</small>
                                </div>
                                <div class="separator">:</div>
                                <div class="time-block">
                                    <span class="seconds">00</span>
                                    <small>SECS</small>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const countdownElements = document.querySelectorAll('.countdown-timer');

        countdownElements.forEach(element => {
            const endDate = new Date(element.dataset.endDate).getTime();
            const isUpcoming = element.dataset.isUpcoming === 'true';

            // Update immediately
            updateCountdown(element, endDate, isUpcoming);

            // Then update every second
            const timer = setInterval(function() {
                const shouldContinue = updateCountdown(element, endDate, isUpcoming);
                if (!shouldContinue) {
                    clearInterval(timer);
                }
            }, 1000);
        });
    });

    function updateCountdown(element, targetDate, isUpcoming) {
        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance < 0) {
            if (isUpcoming) {
                window.location.reload(); // Refresh the page when offer starts
            }
            return false;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        element.querySelector('.days').textContent = days.toString().padStart(2, '0');
        element.querySelector('.hours').textContent = hours.toString().padStart(2, '0');
        element.querySelector('.minutes').textContent = minutes.toString().padStart(2, '0');
        element.querySelector('.seconds').textContent = seconds.toString().padStart(2, '0');
        
        return true;
    }
</script>