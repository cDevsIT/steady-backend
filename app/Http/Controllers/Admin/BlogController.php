<?php

namespace App\Http\Controllers\Admin;

use App\Custom\BlogSeo;
use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Category;
use App\Models\Tag;
use App\Services\SeoService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        menuSubmenu('blogs', 'blogs');
        $paginate = 50;

        $tags = Tag::orderBy('title')->get();

        $blogs = Blog::latest()->where(function ($query) use ($request) {
            if ($request->from_date && $request->to_date) {
                $startDate = Carbon::parse($request->from_date)->startOfDay();
                $endDate = Carbon::parse($request->to_date)->startOfDay();
                $query->whereBetween('created_at', [$startDate, $endDate]);
            } elseif ($request->from_date) {
                $startDate = Carbon::parse($request->from_date)->startOfDay();
                $query->whereDate('created_at', $startDate);
            }

            // Add search functionality
            if ($request->q) {
                $query->where('title', 'like', '%' . $request->q . '%')
                      ->orWhere('description', 'like', '%' . $request->q . '%');
            }

        })->paginate($paginate);

        return view('admin.blog.index', compact('tags', 'blogs'))
            ->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::orderBy('title')->get();
        $categories = Category::orderBy('title')->get();
        return view('admin.blog.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|unique:blogs,title',
            'category' => 'required',
            'description' => 'required',
            'post_body' => 'required',
            'tags' => 'required|array',
            "feature_image" => 'required|image'
        ]);
        $post = new Blog;
        $post->title = $request->title;
        $post->category_id = $request->category;
        $post->description = $request->description;
        $post->content = $request->post_body;
        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->addedBy = auth()->id();

//        $existingFilePath = 'uploads/posts/' . $order->en_file;
//        if (Storage::disk('public')->exists($existingFilePath)) {
//            Storage::disk('public')->delete($existingFilePath);
//        }

        if ($request->file('feature_image')) {
            $file = $request->file('feature_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/blog', $fileName, 'public');
            $post->feature_image = $fileName;
        }
        $post->save();

        // Handle tags
        $tags = [];
        foreach ($request->tags as $tag) {
            if (is_numeric($tag)) {
                $tags[] = $tag;
            } else {
                $newTag = Tag::firstOrCreate(['title' => $tag]);
                $tags[] = $newTag->id;
            }
        }
        $post->tags()->sync($tags);
        return redirect()->route('blogs.index')->with('success', 'Blog post created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        $tags = Tag::orderBy('title')->get();
        $categories = Category::orderBy('title')->get();
        return view('admin.blog.edit', compact('blog', 'tags', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|unique:blogs,title,' . $blog->id,
            'category' => 'required',
            'description' => 'required',
            'post_body' => 'required',
            'tags' => 'required|array',
            "feature_image" => 'nullable|image'
        ]);
        $post = $blog;
        $post->title = $request->title;
        $post->category_id = $request->category;
        $post->description = $request->description;
        $post->content = $request->post_body;
        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->addedBy = auth()->id();


        if ($request->file('feature_image')) {
            $existingFilePath = 'uploads/posts/' . $post->feature_image;
            if (Storage::disk('public')->exists($existingFilePath)) {
                Storage::disk('public')->delete($existingFilePath);
            }

            $file = $request->file('feature_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('uploads/blog', $fileName, 'public');
            $post->feature_image = $fileName;
        }
        $post->save();

        // Handle tags
        $tags = [];
        foreach ($request->tags as $tag) {
            if (is_numeric($tag)) {
                $tags[] = $tag;
            } else {
                $newTag = Tag::firstOrCreate(['title' => $tag]);
                $tags[] = $newTag->id;
            }
        }
        $post->tags()->sync($tags);
        return redirect()->route('blogs.index')->with('success', 'Blog post Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        //
    }
}
