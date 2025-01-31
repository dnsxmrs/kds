<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Exception;

class APIController extends Controller
{
    public function check()
    {
        $dbConnection = DB::connection()->getPdo() ? 'UP' : 'DOWN';
        // $cacheStatus = Cache::store('redis')->get('health-check') !== null ? 'UP' : 'DOWN';

        return response()->json([
            'status' => 'UP',
            'checks' => [
                'database' => $dbConnection,
                // 'cache' => $cacheStatus,
            ],
        ]);
    }

    public function index(Request $request)
    {
        Log::info('Received upOrder request', [
            'request_method' => $request->method(),
            'request_data' => $request->all()
        ]);
    }

    public function receiveUpOrder(Request $request)
    {
        // Validate the incoming request
        $validatedData = $request->validate([
            'request_data.order_id' => 'required|integer',
            'request_data.order_status' => 'required|string',
            'request_data.order_number' => 'required|string',
            'request_data.order_date' => 'required|date',
            'request_data.order_time' => 'required|date_format:Y-m-d\TH:i:s.u\Z',
            'request_data.order_items' => 'required|array',
            'request_data.order_items.*.name' => 'required|string',
            'request_data.order_items.*.quantity' => 'required|integer',
            'request_data.order_items.*.price' => 'required|numeric',
        ]);

        // Extract data
        $orderData = $validatedData['request_data'];
        $orderItems = $orderData['order_items'];

        // Create Order
        $order = Order::create([
            'id' => $orderData['order_id'],
            'order_number' => $orderData['order_number'],
            'status' => $orderData['order_status'],
            'order_date' => $orderData['order_date'],
            'order_time' => $orderData['order_time'],
        ]);

        // Create Order Items
        foreach ($orderItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'name' => $item['name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        // Return a response
        return response()->json(['message' => 'Order received and stored successfully'], 201);
    }

    // legit controller
    public function order(Request $request)
    {
        Log::info('Received upOrder request', [
            'request_method' => $request->method(),
            'request_data' => $request->all()
        ]);

        try {
            // Validate the incoming request
            $validatedData = $request->validate([
                'order_id' => 'required',
                'order_status' => 'required',
                'order_number' => 'required',
                'order_date' => 'required',
                'order_time' => 'required',
                'order_items' => 'required|array',
            ]);

            Log::info('Request data validated successfully', [
                'validated_data' => $validatedData
            ]);

            // Extract data
            $orderData = $validatedData;

            $orderItems = $orderData['order_items'];

            Log::info('Extracted order data and items pos', [
                'order_data' => $orderData,
                'order_items' => $orderItems
            ]);

            $formattedOrderDate = \Carbon\Carbon::parse($orderData['order_date'], 'UTC')
                ->setTimezone('Asia/Manila')
                ->format('Y-m-d');
            $formattedOrderTime = \Carbon\Carbon::parse($orderData['order_time'], 'UTC')
                ->setTimezone('Asia/Manila')
                ->format('H:i:s');

            // Create Order
            $order = Order::create([
                'order_id' => $orderData['order_id'],
                'order_number' => $orderData['order_number'],
                'order_status' => $orderData['order_status'],
                'order_date' => $formattedOrderDate,
                'order_time' => $formattedOrderTime,
                'note' => $orderData['note'] ?? 'none',
                'origin' => 'pos'
            ]);

            Log::info('Order created successfully', ['order' => $order]);

            // Create Order Items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    // 'has_customization' => $item['has_customization'],
                ]);
            }

            Log::info('Order items created successfully', ['order_items' => $orderItems]);

            // Return a response
            return response()->json(['message' => 'Order received and stored successfully'], 201);

        } catch (ValidationException $e) {
            Log::error('Validation error occurred', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);

        } catch (Exception $e) {
            Log::error('An error occurred while processing the upOrder request', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'An internal error occurred'], 500);
        }
    }

    public function webToKds(Request $request)
    {
        // log incoming request
        Log::info('Received webToKds request', [
            'request_method' => $request->method(),
            'request_data' => $request->all()
        ]);

        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'order_id' => 'required|integer', // Ensure the order exists
                'order_status' => 'required|string', // Validate order status
                'order_number' => 'required|string', // Order number should not be empty
                'order_date' => 'required', // Order date should be a valid date
                'order_time' => 'required', // Order time should be a valid ISO 8601 timestamp
                'order_items' => 'required|array', // Order items should not be empty
                'notes' => 'required|string', // Order notes should not be empty
            ]);

            Log::info('Received webToKds request', [
                'validated data' => $validatedData,
            ]);

            // Extract data
            $orderData = $validatedData;

            $orderItems = $orderData['order_items'];

            Log::info('Extracted order data and items web', [
                'order_data' => $orderData,
                'order_items' => $orderItems
            ]);

            $formattedOrderDate = \Carbon\Carbon::parse($orderData['order_date'], 'UTC')
                ->setTimezone('Asia/Manila')
                ->format('Y-m-d');
            $formattedOrderTime = \Carbon\Carbon::parse($orderData['order_time'], 'UTC')
                ->setTimezone('Asia/Manila')
                ->format('H:i:s');

            $order = Order::create([
                'order_id' => $orderData['order_id'],
                'order_number' => $orderData['order_number'],
                'order_status' => $orderData['order_status'],
                'order_date' => $formattedOrderDate,
                'order_time' => $formattedOrderTime,
                'note' => $orderData['notes'] ?? 'none',
                'origin' => 'web'
            ]);

            Log::info('Order created successfully', ['order' => $order]);

            // Create Order Items
            foreach ($orderItems as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    // 'has_customization' => $item['has_customization'],
                ]);
            }

            Log::info('Order items created successfully', ['order_items' => $orderItems]);

            // Return a response
            return response()->json(['message' => 'Order received and stored successfully'], 201);

        }
        catch (ValidationException $e) {
            Log::error('Validation error occurred', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);

        } catch (Exception $e) {
            Log::error('An error occurred while processing the webToKds request', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'An internal error occurred'], 500);
        }
    }

    public function cancelOrderFromWeb(Request $request)
    {
        // log incoming request
        Log::info('Received cancelOrderFromWeb request', [
            'request_method' => $request->method(),
            'request_data' => $request->all()
        ]);

        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'id' => 'required|integer',
                'orderNumber' => 'required|string',
                'status' => 'required|string',
            ]);

            Log::info('Received cancelOrderFromWeb request', [
                'validated data' => $validatedData,
            ]);

            $order = Order::where('order_id', $validatedData['id'])
                ->where('order_number', $validatedData['orderNumber'])
                ->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $order->order_status = 'cancelled';
            $order->save();

            Log::info('Order cancelled successfully', ['order' => $order]);

            // Return a response
            return response()->json(['message' => 'Order cancelled successfully'], 200);

        } catch (ValidationException $e) {
            Log::error('Validation error occurred', [
                'errors' => $e->errors(),
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'Validation error', 'errors' => $e->errors()], 422);

        } catch (Exception $e) {
            Log::error('An error occurred while processing the cancelOrderFromWeb request', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'An internal error occurred'], 500);
        }
    }

    public function orderComplete(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'orderId' => 'required|integer|exists:orders,id',
                'status' => 'required|string|in:pending,preparing,ready,delivery,completed,cancelled',
            ]);

            // find order by id
            $order = Order::find($validatedData['orderId']);

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            $order->order_status = $validatedData['status'];
            $order->save();

            return response()->json(['message' => 'Order status updated successfully'], 200);
        }
        catch (Exception $e) {
            Log::error('An error occurred while processing the orderComplete request', [
                'exception' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request_data' => $request->all()
            ]);
            return response()->json(['message' => 'An internal error occurred'], 500);
        }


    }
}
