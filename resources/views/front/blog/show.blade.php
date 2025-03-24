@extends('layouts.public')

@section('title', $post->title)

@section('meta_description', $post->meta_description)

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            @if($post->image_url)
                <img src="{{ $post->image_url }}" class="img-fluid rounded mb-4" alt="{{ $post->title }}">
            @endif

            <article class="blog-post">
                <h1 class="mb-4">{{ $post->title }}</h1>
                
                <div class="mb-4">
                    <small class="text-muted">
                        Published on {{ $post->created_at->format('M d, Y') }} by {{ $post->author->name }}
                    </small>
                </div>

                <div class="blog-content">
                    {!! $post->content !!}
                </div>
            </article>

            <!-- Share Buttons -->
            <div class="mt-5">
                <h5>Share this post:</h5>
                <div class="sharethis-inline-share-buttons"></div>
            </div>
        </div>
    </div>

    <!-- Related Posts -->
    @if($relatedPosts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Related Posts</h3>
        </div>
        @foreach($relatedPosts as $relatedPost)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm">
                @if($relatedPost->image_url)
                    <img src="{{ $relatedPost->image_url }}" class="card-img-top" alt="{{ $relatedPost->title }}">
                @endif
                <div class="card-body">
                    <div class="mb-2">
                        <small class="text-muted">{{ $relatedPost->created_at->format('M d, Y') }}</small>
                    </div>
                    <h5 class="card-title">{{ $relatedPost->title }}</h5>
                    <p class="card-text">{{ Str::limit($relatedPost->excerpt, 100) }}</p>
                    <a href="{{ route('blog.show', $relatedPost->slug) }}" class="btn btn-outline-primary btn-sm">Read More</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection

@section('styles')
<style>
    .blog-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .blog-content p {
        margin-bottom: 1.5rem;
    }

    .blog-content img {
        max-width: 100%;
        height: auto;
        margin: 2rem 0;
    }

    .blog-content h2, .blog-content h3 {
        margin: 2rem 0 1rem;
    }
</style>
@endsection 