@extends('layouts.public')

@section('title', 'Blog')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-center mb-5">Latest Blog Posts</h1>
        </div>
    </div>

    <div class="row g-4">
        @forelse($posts as $post)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    @if($post->image_url)
                        <img src="{{ $post->image_url }}" class="card-img-top" alt="{{ $post->title }}">
                    @endif
                    <div class="card-body">
                        <div class="mb-2">
                            <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
                        </div>
                        <h5 class="card-title">{{ $post->title }}</h5>
                        <p class="card-text">{{ $post->excerpt }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-primary">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">No blog posts available.</p>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $posts->links() }}
    </div>
</div>
@endsection 