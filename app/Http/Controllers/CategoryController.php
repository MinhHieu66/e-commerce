<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Import lớp Str để tạo slug

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->paginate(10); // Lấy tất cả danh mục, phân trang
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:categories',
                'description' => 'nullable|string',
            ],
            [
                'name.required' => 'Tên danh mục là bắt buộc.',
                'name.unique' => 'Tên danh mục đã tồn tại.',
            ]
        );

        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), // Tự động tạo slug từ tên
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        // Tùy chọn: Nếu bạn muốn xem chi tiết một danh mục
        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255|unique:categories,name,' . $category->id, // Loại trừ chính nó khi kiểm tra unique
                'description' => 'nullable|string',
            ],
            [
                'name.required' => 'Tên danh mục là bắt buộc.',
                'name.unique' => 'Tên danh mục đã tồn tại.',
            ]
        );

        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
        ]);

        return redirect()->route('categories.index')->with('success', 'Danh mục đã được cập nhật thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Danh mục đã được xóa thành công!');
    }
}