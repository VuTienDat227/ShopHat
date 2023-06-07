<?php

namespace App\Http\Controllers;

use App\Mail\OrderEmail;
use App\Models\Category;
use App\Models\OrdersDetails;
use App\Models\OrdersProduct;
use App\Models\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    //
    public function sendEmail(Request $request)
    {
        $toEmail = $request->input('email');
        $subject = $request->input('subject');
        $content = $request->input('content');

        Mail::raw($content, function ($message) use ($toEmail, $subject) {
            $message->to($toEmail)
                ->subject($subject);
        });
        return response()->json(['message' => 'Đã gửi mail thành công']);
    }
    public function sendEmailByAdmin(Request $request)
    {
        $email = $request->input('email');
        $orderId = $request->input('id');
        $order = OrdersProduct::find($orderId);
        $orderItems = OrdersDetails::with(['product', 'order'])
            ->where('OrderId', $orderId)
            ->get();

        foreach ($orderItems as $key => $product) {
            if (!empty($product->product->image)) {
                $product->product->image = asset('storage/images/' . $product->product->image);
            }
        }
        // Gửi email
        Mail::to($email)->send(new OrderEmail($orderItems,$order));

        return response()->json(['message' => 'Email sent successfully']);
    }
    public function index()
    {
        $products = Products::all();

        foreach ($products as $product) {
            if (!empty($product->image)) {
                $product->image = asset('storage/images/' . $product->image);
            }
            $category = Category::find($product->CateId);
            if ($category) {
                $product->CateName = $category->CateName;
            } else {
                $product->CateName = null;
            }
        }
        return response()->json(['data' => $products], 200);
    }
    public function countIndex()
    {
        $products = Products::all();
        $totalProducts = count($products);

        $categoryCounts = Category::withCount('products')
            ->has('products')
            ->get(['CateName', 'products_count']);

        $totalCategories = $categoryCounts->count();
        foreach ($products as $product) {
            if (!empty($product->image)) {
                // Xây dựng đường dẫn hoàn chỉnh từ URL API và trường "image"
                $product->image = asset('storage/images/' . $product->image);
            }
            $category = Category::find($product->CateId);
            if ($category) {
                $product->CateName = $category->CateName;
            } else {
                $product->CateName = null;
            }
        }

        return response()->json(['totalProducts' => $totalProducts, 'categoryCounts' => $totalCategories], 200);
    }


    public function getNewindex()
    {
        $products = Products::orderBy('created_at', 'desc')->take(5)->get();

        foreach ($products as $product) {
            if (!empty($product->image)) {
                $product->image = asset('storage/images/' . $product->image);
            }
            $category = Category::find($product->CateId);
            if ($category) {
                $product->CateName = $category->CateName;
            } else {
                $product->CateName = null;
            }
        }

        return response()->json(['data' => $products], 200);
    }
    public function hotHit()
    {
        $products = Products::where('isSeller', 1)->get();

        foreach ($products as $product) {
            if (!empty($product->image)) {
                $product->image = asset('storage/images/' . $product->image);
            }
        }

        return response()->json(['data' => $products], 200);
    }

    public function getProductById($id)
    {
        $products = Products::find($id);

        if (!$products) {
            return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);
        }
            // Kiểm tra nếu trường "image" không rỗng
        $products->image = asset('storage/images/' . $products->image);
        $category = Category::find($products->CateId);
        if ($category) {
            $products->CateName = $category->CateName;
        } else {
            $products->CateName = null;
        }
        return response()->json(['data' => $products], 200);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'NameProducts' => 'required|string',
            'Details' => 'required|string',
            'Price' => 'required|numeric',
            'Stock' => 'required|integer',
            'isSeller' => 'nullable|numeric',
            'CateId' => 'required|integer',
            'image' => 'required',
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        }
        // Create the product
        $product = Products::create($validatedData);

        return response()->json(['message' => 'Tạo thành công', 'data' => $product], 201);
    }

    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'NameProducts' => 'required|string',
            'Details' => 'required|string',
            'Price' => 'required|string',
            'Stock' => 'required|integer',
            'isSeller' => 'nullable|numeric',
            'CateId' => 'required|integer',

        ]);
        // Find the product
        $product = Products::findOrFail($id);

        $product->update($validatedData);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);

            // Delete the old image if it exists
            if ($product->image && Storage::exists('public/images/' . $product->image)) {
                Storage::delete('public/images/' . $product->image);
            }

            $product->image = $imageName;
            $product->save();
        }

        return response()->json(['message' => 'Sửa thành công', 'data' => $product], 200);
    }

    public function getProductsByCategoryId($categoryId)
    {
        $category = Category::find($categoryId);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $products = $category->products()->paginate(6);
        foreach ($products as $product) {
            if (!empty($product->image)) {
                $product->image = asset('storage/images/' . $product->image);
            }
        }
        return response()->json(['data' => $products], 200);
    }

    public function searchProducts(Request $request)
    {
        $keywords = $request->input('keywords');

        $products = Products::where('NameProducts', 'like', "%$keywords%")->get();

        return response()->json(['data' => $products], 200);
    }

    public function destroy($id)
    {
        // Find the product
        $product = Products::find($id);

        if (!$product) {
            return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);
        }

        // Delete the product
        $product->delete();

        // Delete the associated image if it exists
        if ($product->image && Storage::exists('public/images/' . $product->image)) {
            Storage::delete('public/images/' . $product->image);
        }

        return response()->json(['message' => 'Xóa sản phẩm thành công'], 200);
    }
}
