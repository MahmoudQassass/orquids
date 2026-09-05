<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display categories.
     */
   public function index(Request $request)
    {
        $query = Category::query()
            ->withCount('products');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->status === 'active') {
            $query->where('status', true);
        }

        if ($request->status === 'inactive') {
            $query->where('status', false);
        }

        $categories = $query
            ->latest()
            ->paginate(15);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        return view(
            'admin.categories.create'
        );
    }

    /**
     * Store category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:categories,slug',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ], [

            'name.required' =>
                'يرجى إدخال اسم التصنيف.',

            'slug.unique' =>
                'هذا الرابط مستخدم بالفعل.',

        ]);

        $validated['slug'] =
            !empty($validated['slug'])
                ? Str::slug($validated['slug'])
                : Str::slug($validated['name']);

        $validated['status'] =
            $request->boolean('status');

        Category::create($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'تم إنشاء التصنيف بنجاح.'
            );
    }

    /**
     * Show edit form.
     */
    public function edit(Category $category)
    {
        return view(
            'admin.categories.edit',
            compact('category')
        );
    }

    /**
     * Update category.
     */
    public function update(
        Request $request,
        Category $category
    ) {

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:categories,slug,' . $category->id,
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'nullable',
                'boolean',
            ],
        ]);

        $validated['slug'] =
            !empty($validated['slug'])
                ? Str::slug($validated['slug'])
                : Str::slug($validated['name']);

        $validated['status'] =
            $request->boolean('status');

        $category->update($validated);

        return redirect()
            ->route('admin.categories.index')
            ->with(
                'success',
                'تم تحديث التصنيف بنجاح.'
            );
    }

    /**
     * Delete category.
     */
    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {

            return back()->with(
                'error',
                'لا يمكن حذف هذا التصنيف لأنه مرتبط بمنتجات.'
            );
        }

        $category->delete();

        return back()->with(
            'success',
            'تم حذف التصنيف بنجاح.'
        );
    }
}
