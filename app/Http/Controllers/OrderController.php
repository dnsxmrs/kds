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
