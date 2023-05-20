<?php

namespace App\Http\Controllers;

use App\Models\OrdersDetails;
use App\Models\OrdersProduct;
use App\Models\Products;
use App\Models\UserLogin;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Tymon\JWTAuth\Facades\JWTAuth;
class OrdersProductController extends Controller
{
    //
    public function index($id)
    {
        try {
            $orderIds = OrdersProduct::where('user_id', $id)
                ->where('Status', true)
                ->pluck('id')
            ->toArray();

            $orderItems = OrdersDetails::with(['product', 'order.user'])
                ->whereIn('OrderId', $orderIds)
                ->groupBy('ProductId')
                ->selectRaw('ProductId, SUM(Quantity) as TotalQuantity')
                ->get();

            foreach ($orderItems as $product) {
                // Kiểm tra nếu trường "image" không rỗng
                if (!empty($product->product->image)) {
                    // Xây dựng đường dẫn hoàn chỉnh từ URL API và trường "image"
                    $product->product->image = asset('storage/images/' . $product->product->image);
                }
            }

            return response()->json(['orderItems' => $orderItems, 'orderIds' => $orderIds], 200);
        } catch (\Throwable $e) {
            // Xử lý lỗi nếu không thể xác thực token hoặc không có người dùng
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function countStatusOrders()
    {
        try {
            $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
            $endOfWeek = Carbon::now()->endOfWeek()->toDateString();

            $count = OrdersProduct::where('status', false)
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->count();

            $startOfPreviousWeek = Carbon::now()->subWeek()->startOfWeek()->toDateString();
            $endOfPreviousWeek = Carbon::now()->subWeek()->endOfWeek()->toDateString();

            $previousWeekCount = OrdersProduct::where('status', false)
                ->whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek])
                ->count();


            $percentageChange = $count - $previousWeekCount;


            return response()->json(['count' => $count, 'percentageChange' => $percentageChange], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function calculateTotalPayToday()
    {
        try {
            $today = Carbon::now()->toDateString();
            $totalPay = OrdersProduct::whereDate('created_at', $today)
                ->where('status', false)
                ->get()
                ->sum(function ($order) {
                    return (float) $order->TotalPay;
                });
            $yesterday = Carbon::yesterday()->toDateString();
            $totalPayYesterday = OrdersProduct::whereDate('created_at', $yesterday)
                ->where('status', false)
                ->get()
                ->sum(function ($order) {
                    return (float) $order->TotalPay;
                });

            if ($totalPayYesterday != 0) {
                $percentageChange = (($totalPay - $totalPayYesterday) / $totalPayYesterday) * 100;
            }
            elseif ($totalPayYesterday === 0 && $totalPay === 0 ){
                $percentageChange = 0;

            }
            else{
                $percentageChange = 100;

            }
            return response()->json([
                'totalPayToday' => $totalPay,
                'percentageChange' => $percentageChange
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function calculateTotalPayThisWeek()
    {
        try {
            $startOfWeek = Carbon::now()->startOfWeek()->toDateString();
            $endOfWeek = Carbon::now()->endOfWeek()->toDateString();

            $totalPay = OrdersProduct::whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->where('status', false)
                ->get()
                ->sum(function ($order) {
                    return (float) $order->TotalPay;
                });
            $startOfPreviousWeek = Carbon::now()->subWeek()->startOfWeek()->toDateString();
            $endOfPreviousWeek = Carbon::now()->subWeek()->endOfWeek()->toDateString();
            $totalPayPreviousWeek = OrdersProduct::whereBetween('created_at', [$startOfPreviousWeek, $endOfPreviousWeek])
                ->where('status', false)
                ->get()
                ->sum(function ($order) {
                    return (float) $order->TotalPay;
                });
            $percentageChange = 0;
            if ($totalPayPreviousWeek != 0) {
                $percentageChange = (($totalPay - $totalPayPreviousWeek) / $totalPayPreviousWeek) * 100;
            }
            else{
                $percentageChange = 100;
            }


            return response()->json([
                'totalPayThisWeek' => $totalPay,
                'percentageChange' => $percentageChange
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }
    public function calculateTotalPayThisMonth()
    {
        try {
            $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
            $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

            $totalPay = OrdersProduct::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->where('status', false)
                ->get()
                ->sum(function ($order) {
                    return (float) $order->TotalPay;
                });

            $startOfPreviousMonth = Carbon::now()->subMonth()->startOfMonth()->toDateString();
            $endOfPreviousMonth = Carbon::now()->subMonth()->endOfMonth()->toDateString();

            $totalPayPreviousMonth = OrdersProduct::whereBetween('created_at', [$startOfPreviousMonth, $endOfPreviousMonth])
                ->where('status', false)
                ->get()
                ->sum(function ($order) {
                    return (float) $order->TotalPay;
                });

            $percentageChange = $this->percentageChange($totalPay,$totalPayPreviousMonth );

            return response()->json(['totalPay' => $totalPay, 'percentageChange' => $percentageChange], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    private function percentageChange($currentValue, $previousValue)
    {
        if ($previousValue != 0) {
            return (($currentValue - $previousValue) / $previousValue) * 100;
        }

        return 100;
    }


    public function getAllOrdersAndUsers()
    {
        try {
            $orderProducts = OrdersProduct::with('order', 'user')->get();
$orderDetails = OrdersDetails::with('order','product')->get();
            return response()->json(['order' => $orderProducts, 'details' =>  $orderDetails]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function createOrder(Request $request)
    {
        $data = $request->validate([
            'ProductId' => 'required|array',
            'ProductId.*' => 'required',
            'Quantity' => 'required|array',
            'Quantity.*' => 'required',
            'TotalPay' => 'required',
            'Status' => 'boolean',
            'user_id' => 'required'
        ]);
        $now = Carbon::now();

        // Insert data into orders table
        $order = [
            'user_id' => $data['user_id'],
            'TotalPay' => $data['TotalPay'],
            'Status' => $data['Status'],
            'created_at' => $now,
            'updated_at' => $now
        ];

        $orderId = OrdersProduct::insertGetId($order);

        $products = [];
        for ($i = 0; $i < count($data['ProductId']); $i++) {
            $product = [
                'ProductId' => $data['ProductId'][$i],
                'Quantity' => $data['Quantity'][$i],
                'OrderId' => $orderId,
                'created_at' => $now,
                'updated_at' => $now
            ];

            $products[] = $product;
        }

        // Insert data into order_details table
        $orderDetails = OrdersDetails::insert($products);

        return response()->json(['message' => 'Thêm mới đơn hàng thành công', 'data' => $orderDetails], 201);
    }
    public function addToCart(Request $request)
    {
        $productId = $request->input('ProductId');

        // tìm sản phẩm trong bảng
        $product = Products::find($productId);

        if (!$product) {
            return response()->json(['error' => 'Sản phẩm không tồn tại'], 404);
        }

        $productName = $product->NameProducts;
        $productPrice = $product->Price;

        // cập nhật
        $order = OrdersProduct::where('ProductId', $productId)->first();

        if (!$order) {
            return response()->json(['error' => 'Đơn hàng không tồn tại'], 404);
        }

        $order->Status = true;
        $order->save();

        return response()->json([
            'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
            'productName' => $productName,
            'productPrice' => $productPrice,
            'order' => $order
        ], 200);
    }
    public function confirmOrder($userId, Request $request)
    {
        try {
            $orderIds = $request->input('orderIds');
            $orderQuantity = $request->input('orderQuantity');
            $orderIdsArray = explode(',', $orderIds);
            $orderIdsArray = array_map('intval', $orderIdsArray);

            $orders = OrdersProduct::where('user_id', $userId)
                ->whereIn('id', $orderIdsArray)
                ->where('Status', true)
                ->get();

            if ($orders->isEmpty()) {
                return response()->json(['error' => 'Không tìm thấy order', '$orderIdsArray' => $orderIdsArray,'$orderIds'=>$orderIds], 404);
            }

            // Cập nhật trạng thái 'Status' thành false cho từng đơn hàng
            foreach ($orders as $order) {
                $order->Status = false;
                $order->save();
            }

            return response()->json(['message' => 'Orders xác nhận'], 200);
        } catch (\Throwable $e) {
            // Xử lý lỗi nếu có lỗi xảy ra

            return response()->json(['error' => 'lỗi'], 500);
        }
    }

}
