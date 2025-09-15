<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        menuSubmenu('blogs','categories');
        $paginate = 50;
        
        $categories = Category::latest()->where(function ($query) use ($request) {
            // Add search functionality
            if ($request->q) {
                $query->where('title', 'like', '%' . $request->q . '%')
                      ->orWhere('meta_title', 'like', '%' . $request->q . '%')
                      ->orWhere('meta_description', 'like', '%' . $request->q . '%');
            }
        })->paginate($paginate);
        
        return view('admin/blog/categories/index', compact('categories'))->with('i', ($request->input('page', 1) - 1) * $paginate);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,title',
            'meta_title'=>"nullable",
            'meta_description'=>"nullable",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('error',$errorMessage);
        }

        $category = new Category;
        $category->title = $request->name;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->save();
        return redirect()->back()->with('success','Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:categories,title,'.$category->id,
            'meta_title'=>"nullable",
            'meta_description'=>"nullable",
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->all();
            $errorMessage = implode(' ', $errors);
            return redirect()->back()->with('error',$errorMessage);
        }

        $category->title = $request->name;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        $category->save();
        return redirect()->back()->with('success','Category created successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

    }
}
