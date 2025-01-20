<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function showOrder()
    {
        $orders = Order::with('orderItems')->get();

        return view('orders.new-orders', compact('orders'));
    }

    public function updateStatus(Request $request)
    {
        try {
            // Validate the input
            $validated = $request->validate([
                'orderId' => 'required|integer|exists:orders,id', // Ensure the order exists
                'status' => 'required|string|in:preparing,ready,completed,canceled', // Ensure valid status
            ]);

            // Find the order
            $order = Order::find($validated['orderId']);

            if (!$order) {
                return response()->json(['error' => 'Order not found'], 404);
            }

            // Update the order status
            $order->order_status = $validated['status'];
            $order->save();

            // Return a success response
            return response()->json(['success' => true]);

        } catch (\Exception $e) {
            // Log the exception if needed
            Log::error("Error updating order status: " . $e->getMessage());
            return response()->json(['error' => 'Something went wrong on the server'], 500);
        }
    }

    public function updateOrderStatus(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'status' => 'required|string|in:preparing,ready,completed,canceled',
        ]);

        $order = Order::find($validatedData['order_id']);
        $order->order_status = $validatedData['status'];
        $order->save();

        return response()->json([
            'success' => true,
            'message' => "Order status updated to {$validatedData['status']}",
        ]);
        // return response()->json(['success' => false, 'message' => 'Order not found']);
    }

    public function headerFetch()
    {
        // Use count() to get the count for each status
        $newOrdersCount = Order::where('order_status', 'pending')->count();
        $processedCount = Order::where('order_status', 'preparing')->count();
        $readyCount = Order::where('order_status', 'ready')->count();
        $servedCount = Order::where('order_status', 'completed')->count();

        return response()->json([
            'newOrders' => $newOrdersCount,
            'processed' => $processedCount,
            'ready' => $readyCount,
            'served' => $servedCount,
        ]);
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}
