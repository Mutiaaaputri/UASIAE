<?php

namespace App\Http\Controllers;

use App\Models\user;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Http\Resources\OrderResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{


//     public function store(Request $request)
// {
//     // 1. Validasi user dari user-service
//     $userResponse = Http::get('http://localhost:8001/api/users/' . $request->user_id);
//     if ($userResponse->failed()) {
//         return response()->json(['error' => 'User not found'], 404);
//     }

//     $totalPrice = 0;

//     // 2. Validasi setiap produk dari product-service
//     foreach ($request->items as $item) {
//         $productResponse = Http::get('http://localhost:8002/api/products/' . $item['product_id']);
//         if ($productResponse->failed()) {
//             return response()->json(['error' => 'Product not found'], 404);
//         }

//         $product = $productResponse->json();
//         $totalPrice += $product['price'] * $item['quantity'];
//     }

//     // 3. Buat order
//     $order = Order::create([
//         'user_id' => $request->user_id,
//         'total_price' => $totalPrice,
//         'status' => 'pending',
//     ]);

//     // 4. Buat order item
//     foreach ($request->items as $item) {
//         $productResponse = Http::get('http://localhost:8002/api/products/' . $item['product_id']);
//         $product = $productResponse->json();

//         OrderItem::create([
//             'order_id' => $order->id,
//             'product_id' => $item['product_id'],
//             'quantity' => $item['quantity'],
//             'price' => $product['price'],
//         ]);
//     }

//     return new OrderResource($order->load('items'));
// }

// gate





public function index()
{
    $orders = Order::with('items')->get();
    return OrderResource::collection($orders);
}


public function store(Request $request)
{
    $order = Order::create([
        'user_id' => $request->user_id,
        'total_price' => $request->total_price,
        'status' => 'pending',
    ]);

    foreach ($request->items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    }
//gate
    try {
        $response = Http::post('http://localhost:8004/api/payments', [ // ganti URL jika beda
            'user_id' => $request->user_id,
            'amount' => $request->total_price,
            'currency' => 'IDR',
            'method' => 'transfer', // atau ganti dengan pilihanmu
            'status' => 'pending',
            'transaction_id' => 'TRX-' . uniqid(),
        ]);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'Order created, but payment failed to register.',
                'order' => new OrderResource($order->load('items')),
                'payment_error' => $response->body()
            ], 202);
        }
    } catch (\Exception $e) {
        return response()->json([
            'message' => 'Order created, but payment service is unreachable.',
            'order' => new OrderResource($order->load('items')),
            'error' => $e->getMessage()
        ], 202);
    }


    //gate
    return new OrderResource($order->load('items'));
}
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return new OrderResource($order);
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        $order->update($request->only('status'));
        return new OrderResource($order);
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->items()->delete();
        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }

    //beda

    public function getOrderWithUserAndProduct()
    {
        $orders = Order::with(['user', 'items.product'])->get();

        return response()->json($orders);
    }

    // Ambil order berdasarkan ID, lengkap dengan user dan product
    public function getOrderDetail($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);

        return response()->json($order);
    }

    public function getUser($orderId)
{
    // Ambil order berdasarkan ID
    $order = Order::findOrFail($orderId);

    // Ambil data user berdasarkan ID yang ada di order
    $user = User::find($order->user_id);

    // Kembalikan data user dalam bentuk JSON
    return response()->json($user);
}

public function getProduct($orderId)
{
    // Ambil order berdasarkan ID
    $order = Order::findOrFail($orderId);

    // Ambil data produk berdasarkan order items
    $products = $order->items->map(function ($orderItem) {
        return $orderItem->product; // Asumsi ada relasi antara OrderItem dan Product
    });

    // Kembalikan data produk dalam bentuk JSON
    return response()->json($products);
}


//ambil data all user dan product
public function getAllUsers()
    {
        $users = User::all();  // Fetch all users from the database
        return response()->json($users);  // Return the users as a JSON response
    }

    // Fetch all products
    public function getAllProducts()
    {
        $products = Product::all();  // Fetch all products from the database
        return response()->json($products);  // Return the products as a JSON response
    }



}
