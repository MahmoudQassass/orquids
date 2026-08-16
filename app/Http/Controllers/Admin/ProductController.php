<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Country;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['images', 'category']);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query
            ->latest()
            ->paginate(12);

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('admin.products.index', compact(
            'products',
            'categories'
        ));
    }

    public function create()
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        $countries = Country::where('active', true)
        ->orderBy('name')
        ->get();

        return view(
            'admin.products.create',
            compact('categories','countries')
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'boolean'],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'images' => ['nullable', 'array'],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'countries.*' => [
                'exists:countries,id',
            ],
        ]);

        $countryIds = $validated['countries'] ?? [];

        unset($validated['countries']);

        $product = Product::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']) . '-' . Str::random(5),
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'discount_price' => $validated['discount_price'] ?? null,
            'status' => $request->boolean('status'),
        ]);

        $product->countries()->sync($countryIds);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'media');

                $product->images()->create([
                    'image' => $path,
                    'sort_order' => $index,
                ]);
            }
        }

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'تم إنشاء المنتج بنجاح.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('status', true)
            ->orderBy('name')
            ->get();

        $countries = Country::where('active', true)
        ->orderBy('name')
        ->get();

        $product->load('images');

        return view(
            'admin.products.edit',
            compact(
                'product',
                'categories',
                'countries'
            )
        );
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount_price' => ['nullable', 'numeric', 'min:0'],
            'status' => ['nullable', 'boolean'],
            'category_id' => [
                'required',
                'exists:categories,id',
            ],
            'images' => ['nullable', 'array'],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],

            'countries.*' => [
                'exists:countries,id',
            ],
        ]);

        $countryIds = $validated['countries'] ?? [];

        unset($validated['countries']);

        $product->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'category_id' => $validated['category_id'],
            'discount_price' => $validated['discount_price'] ?? null,
            'status' => $request->boolean('status'),
        ]);

        $product->countries()->sync($countryIds);

        if ($request->hasFile('images')) {
            $lastOrder = $product->images()->max('sort_order') ?? -1;

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('products', 'media');

                $product->images()->create([
                    'image' => $path,
                    'sort_order' => $lastOrder + $index + 1,
                ]);
            }
        }

        return redirect()
            ->route('admin.products.edit', $product)
            ->with('success', 'تم تحديث المنتج بنجاح.');
    }

    public function destroy(Product $product)
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $product->delete();

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'تم حذف المنتج بنجاح.');
    }
}
