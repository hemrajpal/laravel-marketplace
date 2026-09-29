<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Product;
use App\Models\City;

class HomeController extends Controller
{
    /**
     * Display products.
     */
    public function index(Request $request)
    {
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $query = Product::query()
            ->with([
                'images',
                'category',
                'city',
                'state',
            ])
            ->where('status', 'published');

        if ($request->filled('search')) {
            $search = trim($request->search);

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('detail', 'like', "%{$search}%");
            });
        }

        $products = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('home', compact(
            'categories',
            'products'
        ));
    }

    /**
     * Display a single product.
     */
    public function show($slug)
    {
        $product = Product::query()
            ->with([
                'category',
                'user',
                'images',
                'state',
                'city',
            ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        return view('products.show', compact('product'));
    }

    /**
     * City autocomplete.
     */
    public function cities(Request $request)
    {
        $search = trim($request->get('q', ''));

        if ($search === '') {
            return response()->json([]);
        }

        $cities = City::query()
            ->where('name', 'like', "%{$search}%")
            ->orderBy('name')
            ->limit(10)
            ->get([
                'id',
                'name',
                'slug',
            ]);

        return response()->json($cities);
    }

    public function category(Request $request, $category, $categoryId)
    {
        $categoryModel = Category::query()
            ->where('id', $categoryId)
            ->where('slug', $category)
            ->firstOrFail();

        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        // Parent category + all direct child categories
        $categoryIds = collect([$categoryModel->id])
            ->merge(
                $categoryModel->children()->pluck('id')
            );

        $query = Product::query()
            ->with([
                'images',
                'category',
                'city',
                'state',
            ])
            ->whereIn('category_id', $categoryIds)
            ->where('status', 'published');

            if ($request->filled('search')) {
                $search = trim($request->search);
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('detail', 'like', "%{$search}%");
                });
            }

            $products = $query->latest()->paginate(12);

        return view('home', compact(
            'categories',
            'products',
            'categoryModel'
        ));
    }

    /**
     * Display products by city.
     */
    public function city(Request $request, $city, $cityId)
    {
        $cityModel = City::query()
            ->where('id', $cityId)
            //->where('slug', $city)
            ->firstOrFail();

        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $query = Product::query()
            ->with([
                'images',
                'category',
                'city',
                'state',
            ])
            ->where('city_id', $cityModel->id)
            ->where('status', 'published');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('detail', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(12);

        return view('home', compact(
            'categories',
            'products',
            'cityModel'
        ));
    }

    /**
     * Display products by city and category.
     */
    public function cityCategory(
        Request $request,
        $city,
        $cityId,
        $category,
        $categoryId
    ) {

        $cityModel = City::query()
            ->where('id', $cityId)
            //->where('slug', $city)
            ->firstOrFail();

        $categoryModel = Category::query()
            ->where('id', $categoryId)
            //->where('slug', $category)
            ->firstOrFail();

        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->withCount('products')
            ->orderBy('name')
            ->get();

        $categoryIds = collect([$categoryModel->id])
            ->merge(
                $categoryModel->children()->pluck('id')
            );

        $query = Product::query()
            ->with([
                'images',
                'category',
                'city',
                'state',
            ])
            ->where('city_id', $cityModel->id)
            ->whereIn('category_id', $categoryIds)
            ->where('status', 'published');

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('detail', 'like', "%{$search}%");
            });
        }

        $products = $query
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('home', compact(
            'categories',
            'products',
            'cityModel',
            'categoryModel'
        ));
    }
}