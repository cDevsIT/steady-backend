<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::with(['author', 'category', 'tags'])
            ->latest()
            ->paginate(10);

        return response()->json([
            'status' => 'success',
            'data' => $blogs
        ]);
    }

    public function show(Blog $blog)
    {
        $blog->load(['author', 'category', 'tags']);
        
        return response()->json([
            'status' => 'success',
            'data' => $blog
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $blog = Blog::create([
            'title' => $request->title,
            'content' => $request->content,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'addedBy' => auth()->id()
        ]);

        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        }

        $blog->load(['author', 'category', 'tags']);

        return response()->json([
            'status' => 'success',
            'message' => 'Blog created successfully',
            'data' => $blog
        ], 201);
    }

    public function update(Request $request, Blog $blog)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|max:255',
            'content' => 'string',
            'description' => 'string',
            'category_id' => 'exists:categories,id',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $blog->update($request->only(['title', 'content', 'description', 'category_id']));

        if ($request->has('tags')) {
            $blog->tags()->sync($request->tags);
        }

        $blog->load(['author', 'category', 'tags']);

        return response()->json([
            'status' => 'success',
            'message' => 'Blog updated successfully',
            'data' => $blog
        ]);
    }

    public function destroy(Blog $blog)
    {
        $blog->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Blog deleted successfully'
        ]);
    }
} 