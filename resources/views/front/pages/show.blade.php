@extends('layouts.public')

@section('title', $page->meta_title ?? $page->title)
@section('meta_description', $page->meta_description ?? '')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="page-content">
                {!! $page->content !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .page-content {
        line-height: 1.8;
        font-size: 1.1rem;
    }

    .page-content h2 {
        margin-top: 2rem;
        margin-bottom: 1rem;
    }

    .page-content p {
        margin-bottom: 1.5rem;
    }

    .page-content ul,
    .page-content ol {
        margin-bottom: 1.5rem;
        padding-left: 1.5rem;
    }

    .page-content img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 1.5rem 0;
    }

.faq { max-width: 800px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif; } .faq h2 { text-align: center; margin-bottom: 30px; } .faq-item { margin-bottom: 20px; border-bottom: 1px solid #ccc; padding-bottom: 10px; } .faq-question { font-weight: bold; cursor: pointer; display: flex; align-items: center; font-size: 18px; } .faq-question i { margin-right: 10px; color: #7c3aed; /* Use your brand color */ } .faq-answer { margin-top: 10px; font-size: 16px; color: #333; }
</style>
@endsection