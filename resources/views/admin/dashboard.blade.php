@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-4">
        <div class="card text-white bg-primary shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Markets</h5>
                <p class="card-text">{{ \App\Models\Market::count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-success shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Branches</h5>
                <p class="card-text">{{ \App\Models\Branch::count() }}</p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card text-white bg-danger shadow-sm">
            <div class="card-body">
                <h5 class="card-title">Total Offers</h5>
                <p class="card-text">{{ \App\Models\Offer::count() }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
