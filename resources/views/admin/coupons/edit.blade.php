@extends('layouts.admin')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Coupon</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.coupons.update', $coupon) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $coupon->title) }}" required>
                            @error('title')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $coupon->description) }}</textarea>
                            @error('description')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="image">Image</label>
                            @if($coupon->image)
                                <div class="mb-2">
                                    <img src="{{ $coupon->image_url }}" alt="{{ $coupon->title }}" class="img-thumbnail" style="max-width: 200px;">
                                </div>
                            @endif
                            <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image">
                            @error('image')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Maximum file size: 2MB. Supported formats: JPEG, PNG, JPG, GIF</small>
                        </div>

                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror" id="start_date" name="start_date" value="{{ old('start_date', $coupon->start_date->format('Y-m-d\TH:i')) }}" required>
                            @error('start_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror" id="end_date" name="end_date" value="{{ old('end_date', $coupon->end_date->format('Y-m-d\TH:i')) }}" required>
                            @error('end_date')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_unlimited" name="is_unlimited" value="1" {{ old('is_unlimited', $coupon->is_unlimited) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_unlimited">Unlimited Usage</label>
                            </div>
                        </div>

                        <div class="form-group usage-limit-group {{ $coupon->is_unlimited ? 'd-none' : '' }}">
                            <label for="usage_limit">Usage Limit</label>
                            <input type="number" class="form-control @error('usage_limit') is-invalid @enderror" id="usage_limit" name="usage_limit" value="{{ old('usage_limit', $coupon->usage_limit) }}" min="1">
                            @error('usage_limit')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_active">Active</label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="couponable_type">Coupon Type</label>
                            <select class="form-control @error('couponable_type') is-invalid @enderror" id="couponable_type" name="couponable_type" required>
                                <option value="">Select Type</option>
                                <option value="App\Models\Market" {{ old('couponable_type', $coupon->couponable_type) == 'App\Models\Market' ? 'selected' : '' }}>Market</option>
                                <option value="App\Models\Branch" {{ old('couponable_type', $coupon->couponable_type) == 'App\Models\Branch' ? 'selected' : '' }}>Branch</option>
                            </select>
                            @error('couponable_type')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group market-select-group {{ old('couponable_type', $coupon->couponable_type) == 'App\Models\Branch' ? '' : 'd-none' }}">
                            <label for="market_id">Select Market</label>
                            <select class="form-control @error('market_id') is-invalid @enderror" id="market_id" name="market_id">
                                <option value="">Select Market</option>
                            </select>
                            @error('market_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="couponable_id">Select {{ old('couponable_type', $coupon->couponable_type) == 'App\Models\Market' ? 'Market' : 'Branch' }}</label>
                            <select class="form-control @error('couponable_id') is-invalid @enderror" id="couponable_id" name="couponable_id" required>
                                <option value="">Select {{ old('couponable_type', $coupon->couponable_type) == 'App\Models\Market' ? 'Market' : 'Branch' }}</option>
                            </select>
                            @error('couponable_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div id="couponData" 
                             data-markets='{!! json_encode($markets) !!}'
                             data-branches='{!! json_encode($branches) !!}'
                             data-selected-id='{{ old('couponable_id', $coupon->couponable_id) }}'
                             data-selected-market-id='{{ old('market_id', $coupon->couponable_type == "App\Models\Branch" ? $coupon->couponable->market_id : "") }}'
                             style="display: none;">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Coupon</button>
                            <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Get DOM elements
        const isUnlimitedSwitch = document.getElementById('is_unlimited');
        const usageLimitGroup = document.querySelector('.usage-limit-group');
        const couponableTypeSelect = document.getElementById('couponable_type');
        const couponableIdSelect = document.getElementById('couponable_id');
        const marketSelectGroup = document.querySelector('.market-select-group');
        const marketSelect = document.getElementById('market_id');
        const couponData = document.getElementById('couponData');

        // Initialize usage limit visibility
        if (isUnlimitedSwitch && usageLimitGroup) {
            function toggleUsageLimit() {
                usageLimitGroup.style.display = isUnlimitedSwitch.checked ? 'none' : 'block';
            }
            isUnlimitedSwitch.addEventListener('change', toggleUsageLimit);
            toggleUsageLimit(); // Set initial state
        }

        // Initialize market/branch selection
        if (couponableTypeSelect && couponableIdSelect && couponData && marketSelect && marketSelectGroup) {
            function updateMarketOptions() {
                try {
                    const markets = JSON.parse(couponData.dataset.markets);
                    marketSelect.innerHTML = '<option value="">Select Market</option>';
                    
                    markets.forEach(market => {
                        const optionElement = document.createElement('option');
                        optionElement.value = market.id;
                        optionElement.textContent = market.name;
                        if (market.id === parseInt(couponData.dataset.selectedMarketId)) {
                            optionElement.selected = true;
                        }
                        marketSelect.appendChild(optionElement);
                    });
                } catch (error) {
                    console.error('Error parsing markets:', error);
                    marketSelect.innerHTML = '<option value="">Error loading markets</option>';
                }
            }

            function updateBranchOptions(marketId) {
                try {
                    const branches = JSON.parse(couponData.dataset.branches);
                    couponableIdSelect.innerHTML = '<option value="">Select Branch</option>';
                    
                    branches
                        .filter(branch => branch.market_id === parseInt(marketId))
                        .forEach(branch => {
                            const optionElement = document.createElement('option');
                            optionElement.value = branch.id;
                            optionElement.textContent = branch.name;
                            if (branch.id === parseInt(couponData.dataset.selectedId)) {
                                optionElement.selected = true;
                            }
                            couponableIdSelect.appendChild(optionElement);
                        });
                } catch (error) {
                    console.error('Error parsing branches:', error);
                    couponableIdSelect.innerHTML = '<option value="">Error loading branches</option>';
                }
            }

            function updateCouponableOptions() {
                const type = couponableTypeSelect.value;
                if (!type) {
                    couponableIdSelect.innerHTML = '<option value="">Select Market or Branch</option>';
                    marketSelectGroup.style.display = 'none';
                    return;
                }

                if (type === 'App\\Models\\Market') {
                    marketSelectGroup.style.display = 'none';
                    try {
                        const markets = JSON.parse(couponData.dataset.markets);
                        couponableIdSelect.innerHTML = '<option value="">Select Market</option>';
                        
                        markets.forEach(market => {
                            const optionElement = document.createElement('option');
                            optionElement.value = market.id;
                            optionElement.textContent = market.name;
                            if (market.id === parseInt(couponData.dataset.selectedId)) {
                                optionElement.selected = true;
                            }
                            couponableIdSelect.appendChild(optionElement);
                        });
                    } catch (error) {
                        console.error('Error parsing markets:', error);
                        couponableIdSelect.innerHTML = '<option value="">Error loading markets</option>';
                    }
                } else {
                    marketSelectGroup.style.display = 'block';
                    couponableIdSelect.innerHTML = '<option value="">Select Branch</option>';
                    updateMarketOptions();
                    if (couponData.dataset.selectedMarketId) {
                        updateBranchOptions(couponData.dataset.selectedMarketId);
                    }
                }
            }

            function updateLabel() {
                const type = couponableTypeSelect.value;
                const label = document.querySelector('label[for="couponable_id"]');
                if (label) {
                    label.textContent = 'Select ' + (type === 'App\\Models\\Market' ? 'Market' : 'Branch');
                }
            }

            // Add event listeners
            couponableTypeSelect.addEventListener('change', function() {
                updateCouponableOptions();
                updateLabel();
            });

            marketSelect.addEventListener('change', function() {
                if (this.value) {
                    updateBranchOptions(this.value);
                } else {
                    couponableIdSelect.innerHTML = '<option value="">Select Branch</option>';
                }
            });

            // Set initial state
            updateCouponableOptions();
            updateLabel();
        }
    });
</script>
@endpush
@endsection 