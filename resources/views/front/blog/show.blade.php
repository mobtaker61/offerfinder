@extends('layouts.public')

@section('title', $post->title)

@section('meta_description', $post->meta_description)

@section('content')
<div class="container py-5">
    <div class="row">
        <!-- Post Title -->
        <h1 class="post-title text-center mb-4">{{ $post->title }}</h1>
        <!-- Main Content -->
        <div class="col-lg-8">
            <article class="blog-post">
                <!-- Post Image -->
                <div class="post-image mb-4">
                    <img src="{{ $post->image_url }}" alt="{{ $post->title }}" class="img-fluid w-100">
                </div>

                <!-- Post Meta -->
                <div class="post-meta mb-4">
                    <div class="d-flex align-items-center text-muted">
                        <span class="me-3">
                            <i class="fas fa-calendar"></i> {{ $post->created_at->format('M d, Y') }}
                        </span>
                        @if($post->author)
                        <span class="me-3">
                            <i class="fas fa-user"></i> {{ $post->author->name }}
                        </span>
                        @endif
                    </div>
                </div>

                <!-- Post Content -->
                <div class="post-content">
                    {!! $post->content !!}
                </div>
            </article>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="sidebar">
                <!-- Latest Posts Widget -->
                <div class="widget mb-4">
                    <h3 class="widget-title">Latest Posts</h3>
                    <div class="widget-content">
                        <ul class="list-unstyled">
                            @foreach(\App\Models\Post::latest()->take(5)->get() as $latestPost)
                            <li class="mb-3">
                                <a href="{{ route('blog.show', $latestPost->slug) }}" class="d-flex align-items-center">
                                    <img src="{{ $latestPost->image_url }}" alt="{{ $latestPost->title }}" class="me-3" style="width: 80px; height: 60px; object-fit: cover;">
                                    <div>
                                        <h6 class="mb-0">{{ $latestPost->title }}</h6>
                                        <small class="text-muted">{{ $latestPost->created_at->format('M d, Y') }}</small>
                                    </div>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <!-- Branch Widget -->
                @if($post->branch)
                <div class="widget mb-4">
                    <h3 class="widget-title">Related Branch</h3>
                    <div class="widget-content">
                        <div class="branch-info d-flex align-items-center">
                            <a href="{{ route('front.market.show', $post->market) }}" class="text-decoration-none">
                                <h5 class="mb-0">{{ $post->branch->name }}</h5>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Market Widget -->
                @if($post->market)
                <div class="widget mb-4">
                    <h3 class="widget-title">Related Market</h3>
                    <div class="widget-content">
                        <div class="market-info d-flex align-items-center">
                            <img src="{{ asset('storage/' . $post->market->avatar) }}" alt="{{ $post->market->name }}" class="me-3" style="width: 48px; height: 48px; object-fit: cover; border-radius: 50%;">
                            <a href="{{ route('front.market.show', $post->market) }}" class="text-decoration-none">
                                <h5 class="mb-0">{{ $post->market->name }}</h5>
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Advertisement Widget -->
                <div class="widget mb-4">
                    <h3 class="widget-title">Advertisement</h3>
                    <div class="widget-content">
                        <div class="advertisement">
                            <img src="/images/advertisement-placeholder.jpg" alt="Advertisement" class="img-fluid rounded">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .blog-post {
        background: #fff;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .post-image {
        border-radius: 10px;
        overflow: hidden;
    }

    .post-title {
        font-size: 2rem;
        font-weight: 700;
        color: #333;
    }

    .post-content {
        font-size: 1.1rem;
        line-height: 1.8;
        color: #666;
    }

    .sidebar .widget {
        background: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    .widget-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #eee;
    }

    .widget-content {
        color: #666;
    }

    .widget-content ul li {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }

    .widget-content ul li:last-child {
        border-bottom: none;
    }

    .widget-content a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s;
    }

    .widget-content a:hover {
        color: #007bff;
    }

    .market-info img,
    .branch-info img {
        transition: transform 0.3s;
    }

    .market-info img:hover,
    .branch-info img:hover {
        transform: scale(1.05);
    }

    .advertisement img {
        transition: transform 0.3s;
    }

    .advertisement img:hover {
        transform: scale(1.05);
    }
</style>
@endsection