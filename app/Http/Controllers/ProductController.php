<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\City;
use App\Models\State;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{

    /**
     * Show create product form.
     */
    public function create()
    {
        $categories = Category::with('children')
            ->orderBy('name')
            ->get();

        $states = State::with('cities')
            ->orderBy('name')
            ->get();

        return view('products.create', compact(
            'categories',
            'states'
        ));
    }

    /**
     * Store a new product.
     */
    public function store(ProductRequest $request)
    {

        $city = City::query()
            ->where('id', $request->city_id)
            ->where('state_id', $request->state_id)
            ->first();

        if (! $city) {
            return back()
                ->withErrors([
                    'city_id' => 'Invalid city selected for the selected state.',
                ])
                ->withInput();
        }

        $category = Category::query()
            ->where('id', $request->category_id)
            ->first();

        if (! $category) {
            return back()
                ->withErrors([
                    'category_id' => 'Invalid category selected.',
                ])
                ->withInput();
        }


        $slug = Str::slug($request->name);

        $originalSlug = $slug;
        $counter = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        DB::beginTransaction();

        try {
            $product = Product::create([
                'user_id' => auth()->id(),
                'category_id' => $request->category_id,
                'type' => $request->type,
                'name' => $request->name,
                'slug' => $slug,
                'detail' => $request->detail,
                'country' => $request->country,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,
                'area' => $request->area,
                'price' => $request->price,
                'status' => 'published',
                'published_at' => now(),
            ]);

            foreach ($request->file('images') as $index => $image) {
                $path = $image->store(
                    'products',
                    'public'
                );

                $product->images()->create([
                    'image' => $path,
                    'is_primary' => $index === 0,
                ]);
            }

            DB::commit();

            return redirect()
                ->route('products.show', $product->slug)
                ->with('success', 'Product created successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while creating the product.');
        }
    }

    /**
     * Show form for editing a product.
     */
    public function edit($id)
    {
        $product = Product::query()
            ->with([
                'images',
                'category.parent',
                'city',
                'state',
            ])
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $categories = Category::with('children')
            ->orderBy('name')
            ->get();

        $states = State::with('cities')
            ->orderBy('name')
            ->get();

        return view('products.edit', compact(
            'product',
            'categories',
            'states'
        ));
    }

    /**
     * Update product.
     */
    public function update(ProductRequest $request, $id)
    {
        $product = Product::query()
            ->with('images')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        $city = City::query()
            ->where('id', $request->city_id)
            ->where('state_id', $request->state_id)
            ->first();

        if (! $city) {
            return back()
                ->withErrors([
                    'city_id' => 'Invalid city selected for the selected state.',
                ])
                ->withInput();
        }

        $category = Category::query()
            ->where('id', $request->category_id)
            ->first();

        if (! $category) {
            return back()
                ->withErrors([
                    'category_id' => 'Invalid category selected.',
                ])
                ->withInput();
        }

        $slug = Str::slug($request->name);

        $originalSlug = $slug;
        $counter = 1;

        while (
            Product::where('slug', $slug)
                ->where('id', '!=', $product->id)
                ->exists()
        ) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        $existingImageCount = $product->images()->count();

        $newImages = $request->file('images', []);

        $newImageCount = count($newImages);

        if (($existingImageCount + $newImageCount) > 10) {
            return back()
                ->withErrors([
                    'images' => 'A product can have a maximum of 10 images.',
                ])
                ->withInput();
        }

        DB::beginTransaction();

        try {
            $product->update([
                'category_id' => $request->category_id,

                'type' => $request->type,
                'name' => $request->name,
                'slug' => $slug,
                'detail' => $request->detail,

                'country' => $request->country,
                'state_id' => $request->state_id,
                'city_id' => $request->city_id,

                'area' => $request->area,
                'price' => $request->price,
            ]);

            if ($request->hasFile('images')) {
                $hasPrimaryImage = $product->images()
                    ->where('is_primary', true)
                    ->exists();

                foreach ($request->file('images') as $image) {
                    $path = $image->store(
                        'products',
                        'public'
                    );

                    $product->images()->create([
                        'image' => $path,
                        'is_primary' => ! $hasPrimaryImage,
                    ]);

                    $hasPrimaryImage = true;
                }
            }

            DB::commit();

            return redirect()
                ->route('products.show', $product->slug)
                ->with('success', 'Product updated successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', 'Something went wrong while updating the product.');
        }
    }

    /**
     * Display user's products.
     */
    public function myProducts()
    {
        $products = Product::query()
            ->with([
                'category',
                'images',
                'city',
                'state',
            ])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);

        return view('products.my-products', compact('products'));
    }

    /**
     * Delete a product image.
     */
    public function destroyImage(ProductImage $image)
    {
        $product = $image->product;

        DB::beginTransaction();

        try {
            $wasPrimary = $image->is_primary;

            if ($image->image) {
                Storage::disk('public')->delete($image->image);
            }

            $image->delete();


            if ($wasPrimary) {
                $nextImage = $product->images()
                    ->orderBy('id')
                    ->first();

                if ($nextImage) {
                    $nextImage->update([
                        'is_primary' => true,
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Image removed successfully.',
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();

            return response()->json([
                'success' => false,
                'message' => 'Unable to remove image.',
            ], 500);
        }
    }

    /**
     * Delete product.
     */
    public function destroy($id)
    {
        $product = Product::query()
            ->with('images')
            ->where('id', $id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        DB::beginTransaction();

        try {

            foreach ($product->images as $image) {
                if ($image->image) {
                    Storage::disk('public')->delete($image->image);
                }

                $image->delete();
            }

            $product->delete();

            DB::commit();

            return redirect()
                ->route('products.my')
                ->with('success', 'Product deleted successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->with('error', 'Something went wrong while deleting the product.');
        }
    }
}