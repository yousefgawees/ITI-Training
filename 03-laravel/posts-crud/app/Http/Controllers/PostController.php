<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::with('user')
            ->latest()
            ->paginate(10);

        return view('posts.index', compact('posts'));
    }


    public function create()
    {
        return view('posts.create');
    }


    public function store(StorePostRequest $request)
    {
        $data = $request->validated();

        // المستخدم الحالي اللي عامل Login
        $data['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')
                ->store('posts', 'public');
        }

        Post::create($data);

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post created successfully.');
    }


    public function show(Post $post)
    {
        $post->load([
            'user',
            'comments.user',
        ]);

        return view('posts.show', compact('post'));
    }


   public function edit(Post $post)
{
    return view('posts.edit', compact('post'));
}


public function update(
    UpdatePostRequest $request,
    Post $post
) {
    $data = $request->validated();

    unset($data['user_id']);

    if ($request->hasFile('image')) {

        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $data['image'] = $request->file('image')
            ->store('posts', 'public');
    }

    $post->update($data);

    return redirect()
        ->route('posts.show', $post)
        ->with('success', 'Post updated successfully.');
}


public function destroy(Post $post)
{
    if ($post->image) {
        Storage::disk('public')->delete($post->image);
    }

    $post->delete();

    return redirect()
        ->route('posts.index')
        ->with('success', 'Post deleted successfully.');
}

    public function restore($id)
    {
        $post = Post::withTrashed()
            ->findOrFail($id);

        // لازم يكون الـ Post بتاع المستخدم الحالي
        if ($post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->restore();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Post restored successfully.');
    }
}