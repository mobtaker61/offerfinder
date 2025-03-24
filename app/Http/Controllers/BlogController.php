<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('front.blog.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $relatedPosts = Post::where('is_active', true)
            ->where('id', '!=', $post->id)
            ->inRandomOrder()
            ->take(3)
            ->get();

        return view('front.blog.show', compact('post', 'relatedPosts'));
    }
} 