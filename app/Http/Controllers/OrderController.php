<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;


class OrderController extends Controller
{
    public function showOrder()
    {
        $orders = Order::with('orderItems')->get();

        Log::info($orders);

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

    //used in updatin sstatus from js
    public function updateOrderStatus(Request $request)
    {
        $validatedData = $request->validate([
            'order_id' => 'required|integer|exists:orders,id',
            'status' => 'required|string|in:preparing,ready,completed,canceled',
        ]);

        $this->syncStatusToPos($validatedData['order_id'], $validatedData['status']);

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

    public function syncStatusToPos($order_id, $status)
    {
        try {
            // Find the order using order_id
            $order = Order::find($order_id);

            if (!$order) {
                Log::error('Order not found', [
                    'order_id' => $order_id,
                ]);
                return response()->json(['message' => 'Order not found'], 404);
            }

            $order_number = $order->order_number;

            $payload = [
                'order_id' => $order_id,
                'order_number' => $order_number,
                'status' => $status,
            ];

            // Log the payload as JSON for better readability
            Log::info("Sending status to POS:", $payload);

            // Send the request to the POS system
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('KDS_API_KEY'), // Include the Authorization Bearer token
            ])->post(env('STATUS_UPDATE_POS'), $payload);

            // Check the response status
            if ($response->successful()) {
                Log::info("Status successfully synced to POS", [
                    'response_data' => $response->json(),
                ]);
                return response()->json([
                    'message' => 'Status successfully synced to POS',
                    'response' => $response->json(),
                ], 200);
            } elseif ($response->clientError()) {
                Log::error("Client error while syncing status to POS", [
                    'response_code' => $response->status(),
                    'response_body' => $response->body(),
                ]);
                return response()->json([
                    'message' => 'Client error occurred while syncing to POS',
                    'error' => $response->json(),
                ], $response->status());
            } elseif ($response->serverError()) {
                Log::error("Server error while syncing status to POS", [
                    'response_code' => $response->status(),
                    'response_body' => $response->body(),
                ]);
                return response()->json([
                    'message' => 'Server error occurred while syncing to POS',
                    'error' => $response->json(),
                ], $response->status());
            }

            // Catch-all for unexpected issues
            Log::error("Unexpected response from POS", [
                'response_code' => $response->status(),
                'response_body' => $response->body(),
            ]);
            return response()->json([
                'message' => 'Unexpected response from POS',
                'response' => $response->json(),
            ], $response->status());
        } catch (\Exception $e) {
            // Catch exceptions and log them
            Log::error("Error while syncing status to POS", [
                'error_message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return response()->json([
                'message' => 'An error occurred while syncing to POS',
                'error' => $e->getMessage(),
            ], 500);
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
