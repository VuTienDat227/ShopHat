<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //
    public function index()
    {
        $category = Category::all();
        foreach ($category as $product) {
            if (!empty($product->image)) {
                $product->image = asset('storage/images/' . $product->image);
            }
        }
        return response()->json(['data' => $category], 200);
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'CateName' => 'required|string',
            'Details' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:1000000',

        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        }
        // Create the product
        $category = Category::create($validatedData);

        return response()->json(['message' => 'Tạo thành công', 'data' => $category], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'CateName' => 'required|string',
            'Details' => 'required',

        ]);

        // Find the product
        $category = Category::findOrFail($id);

        // Update the product
        $category->update($validatedData);

        // Handle image upload if a new image is provided
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);

            // Delete the old image if it exists
            if ($category->image && Storage::exists('public/images/' . $category->image)) {
                Storage::delete('public/images/' . $category->image);
            }

            // Update the image path in the product
            $category->image = $imageName;
            $category->save();
        }
        return response()->json(['message' => 'Sửa thành công', 'data' => $category], 200);
    }
    public function getCateById($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);
        }
        // Kiểm tra nếu trường "image" không rỗng
        $category->image = asset('storage/images/' . $category->image);

        return response()->json(['data' => $category], 200);
    }
    public function destroy($id)
    {
        // Find the category
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['error' => 'Danh mục không tồn tại'], 404);
        }

        // Delete the category
        $category->delete();

        // Delete the associated image if it exists
        if ($category->image && Storage::exists('public/images/' . $category->image)) {
            Storage::delete('public/images/' . $category->image);
        }

        return response()->json(['message' => 'Xóa danh mục thành công'], 200);
    }
}
