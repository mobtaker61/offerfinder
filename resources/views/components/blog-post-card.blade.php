@props(['post'])

<div class="card h-100 shadow-sm">
    @if($post->image_url)
        <img src="{{ $post->image_url }}" class="card-img-top" alt="{{ $post->title }}">
    @endif
    <div class="card-body">
        <div class="mb-2">
            <small class="text-muted">{{ $post->created_at->format('M d, Y') }}</small>
        </div>
        <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
            <h5 class="card-title text-dark">{{ $post->title }}</h5>
        </a>
        <p class="card-text">{{ Str::limit($post->excerpt, 100) }}</p>
    </div>
</div> 