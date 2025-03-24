<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Market;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with(['author', 'market', 'branch'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.blog.index', compact('posts'));
    }

    public function create()
    {
        $markets = Market::orderBy('name')->get();
        return view('admin.blog.create', compact('markets'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'image' => 'nullable|image|max:2048',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'is_active' => 'boolean',
            'scope' => ['required', Rule::in(['global', 'market', 'branch'])],
            'market_id' => [
                Rule::requiredIf(fn() => in_array($request->scope, ['market', 'branch'])),
                'nullable',
                'exists:markets,id'
            ],
            'branch_id' => [
                Rule::requiredIf(fn() => $request->scope === 'branch'),
                'nullable',
                'exists:branches,id'
            ],
        ]);

        $validated['slug'] = Str::slug($request->title);
        $validated['author_id'] = Auth::id();

        // Handle image upload
        if ($request->hasFile('image')) {
            // Store the image file
            $imagePath = $request->file('image')->store('blog_images', 'public');
            
            // Set the image URL in the validated array
            $validated['image_url'] = asset('storage/' . $imagePath);
        }

        // Clear market_id and branch_id if scope is global
        if ($validated['scope'] === 'global') {
            $validated['market_id'] = null;
            $validated['branch_id'] = null;
        }
        // Clear branch_id if scope is market
        elseif ($validated['scope'] === 'market') {
            $validated['branch_id'] = null;
        }

        Post::create($validated);

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post created successfully.');
    }

    public function edit(Post $blog)
    {
        $markets = Market::orderBy('name')->get();
        return view('admin.blog.edit', compact('blog', 'markets'));
    }

    public function show(Post $blog)
    {
        // Log the show method is being called
        Log::info('Show method called for blog ID: ' . $blog->id);
        
        // Redirect to edit page since we don't have a dedicated show page in admin
        return redirect()->route('admin.blog.edit', $blog);
    }

    public function update(Request $request, Post $blog)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'excerpt' => 'nullable|max:500',
            'image' => 'nullable|image|max:2048',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:500',
            'is_active' => 'boolean',
            'scope' => ['required', Rule::in(['global', 'market', 'branch'])],
            'market_id' => [
                Rule::requiredIf(fn() => in_array($request->scope, ['market', 'branch'])),
                'nullable',
                'exists:markets,id'
            ],
            'branch_id' => [
                Rule::requiredIf(fn() => $request->scope === 'branch'),
                'nullable',
                'exists:branches,id'
            ],
        ]);

        if ($request->title !== $blog->title) {
            $validated['slug'] = Str::slug($request->title);
        }

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog_images', 'public');
            $validated['image_url'] = asset('storage/' . $imagePath);
        }

        if ($validated['scope'] === 'global') {
            $validated['market_id'] = null;
            $validated['branch_id'] = null;
        } elseif ($validated['scope'] === 'market') {
            $validated['branch_id'] = null;
        }

        $blog->update($validated);
        
        return redirect('/admin/blog')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return redirect()->route('admin.blog.index')
            ->with('success', 'Post deleted successfully.');
    }
} 