<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="icon" href="{{ asset('favicon.ico') }}?v=2" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css2?family=Barlow:wght@400;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        /* Active button styles */
        .tab-button.active {
            background-color: white;
            color: black;
        }

        /* Inactive button styles */
        .tab-button {
            background-color: #9D9D9D;
            color: #555555;
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('components.navigation')

    {{-- TABS FOR ORDER PROCESSING --}}
    <div class="bg-[#1C3D34] relative sticky z-10 h-[110px] bg-center bg-cover top-20">
        <div class="absolute inset-0 flex items-center bg-black bg-opacity-30 px-5 justify-between">
            <!-- Tabs -->
            <div class="tabs flex space-x-5 ml-[60px]">
                <button
                    class="tab-button w-[188px] h-[37px] rounded-[18.5px] bg-white text-black hover:bg-gray-200 focus:ring-2 focus:ring-gray-300"
                    onclick="showTab('new-orders', this)">
                    New Orders
                </button>
                <button
                    class="tab-button w-[188px] h-[37px] rounded-[18.5px] bg-[#9D9D9D] text-[#555555] hover:bg-gray-200 focus:ring-2 focus:ring-gray-300"
                    onclick="showTab('in-progress-orders', this)">
                    In-Progress Orders
                </button>
                <button
                    class="tab-button w-[188px] h-[37px] rounded-[18.5px] bg-[#9D9D9D] text-[#555555] hover:bg-gray-200 focus:ring-2 focus:ring-gray-300"
                    onclick="showTab('completed-orders', this)">
                    Completed Orders
                </button>
            </div>

            <!-- Order Stats -->
            <div class="order-stats flex justify-end items-center space-x-10 mt-2 mr-[60px]">
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        5
                    </div>
                    <!-- Label -->
                    <span class="text-white text-sm">New Orders</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        3
                    </div>
                    <!-- Label -->
                    <span class="text-white text-sm">Processed</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        4
                    </div>
                    <!-- Label -->
                    <span class="text-white text-sm">Ready</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        10
                    </div>
                    <!-- Label -->
                    <span class="text-white text-sm">Served</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabs Content -->
    <div class="tabs-content">
        <!-- New Orders Tab -->
        <div id="new-orders" class="tab-content" style="display: block;">
            <div class="grid grid-cols-5 gap-6 my-6 mx-10">
                @foreach ($orders as $order)
                    {{-- @dd($order) --}}
                    @if ($order->order_status === 'pending')
                        <div class="order-card">
                            <!-- Order Cards Grid -->

                            <!-- Order Card -->
                            <!-- Repeat the order card as needed -->
                            <div class=" ">
                                <div class="bg-red-500 text-white p-2">
                                    <div class="ml-10">
                                        <h3 class="font-bold">{{ $order->order_number }}</h3>
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->date)->format('d M') }}
                                        </p> <!-- Order Date -->
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->time)->format('H:i:s') }}</p>
                                        <!-- Order Time -->
                                    </div>
                                </div>
                                <div class="p-4 bg-white shadow-lg">
                                    <div>
                                        <ul class="space-y-2">
                                            {{-- @dd($order->products) --}}

                                            @foreach ($order->items as $item)
                                                <li class="flex justify-between">
                                                    <div>
                                                        <span>{{ $item->name }}</span>
                                                        <br>
                                                        {{-- @if ($item->has_customization)
                                                            <span class="text-black text-sm block">22oz</span>
                                                        @endif --}}
                                                    </div>
                                                    {{-- <span>{{$order->order_products->quantity}}</span> --}}
                                                    <span>x {{ $item->quantity }}</span>
                                                    <!-- Get the quantity -->
                                                </li>
                                            @endforeach

                                            <li class="flex justify-between">
                                                <div>
                                                    <span>Iced Mocha</span>
                                                    <br>
                                                    <span class="text-black-500 text-sm block">22oz</span>
                                                </div>
                                                <span>x 1</span>
                                            </li>
                                        </ul>
                                        <hr class="my-5">
                                        <div class="mt-4">
                                            <p class="text-black-500 text-sm mb-2"><strong>Note:</strong></p>
                                            {{-- @if ($order->note)
                                                    <p class="text-black-500 text-sm">No sugar</p>
                                                @else
                                                    <p class="text-black-500 text-sm">No Note</p>
                                                @endif --}}

                                            <div class="flex items-center justify-center">
                                                <button id="startButton" data-id="{{ $order->id }}"
                                                    class="w-[177px] h-[41px] rounded-[10px] bg-[#263238] text-white font-bold flex items-center justify-center hover:bg-gray-700 mt-5">
                                                    Start
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- In-Progress Orders Tab -->
        <div id="in-progress-orders" class="tab-content" style="display: none;">
            <div class="grid grid-cols-5 gap-6 my-6 mx-10">
                @foreach ($orders as $order)
                    @if ($order->order_status === 'preparing')
                        <div class="order-card">
                            <div class=" ">
                                <div class="bg-[#EEAA00] text-white p-2">
                                    <div class="ml-10">
                                        <h3 class="font-bold">{{ $order->order_number }}</h3>
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->date)->format('d M') }}
                                        </p> <!-- Order Date -->
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->time)->format('H:i:s') }}</p>
                                        <!-- Order Time -->
                                    </div>
                                </div>
                                <div class="p-4 bg-white shadow-lg">
                                    <div>
                                        <ul class="space-y-2">
                                            {{-- @dd($order->products) --}}

                                            @foreach ($order->items as $item)
                                                <li class="flex justify-between">
                                                    <div>
                                                        <span>{{ $item->name }}</span>
                                                        <br>
                                                        {{-- @if ($item->has_customization)
                                                            <span class="text-black text-sm block">22oz</span>
                                                        @endif --}}
                                                    </div>
                                                    {{-- <span>{{$order->order_products->quantity}}</span> --}}
                                                    <span>x {{ $item->quantity }}</span>
                                                    <!-- Get the quantity -->
                                                </li>
                                            @endforeach

                                            <li class="flex justify-between">
                                                <div>
                                                    <span>Iced Mocha</span>
                                                    <br>
                                                    <span class="text-black-500 text-sm block">22oz</span>
                                                </div>
                                                <span>x 1</span>
                                            </li>
                                        </ul>
                                        <hr class="my-5">
                                        <div class="mt-4">
                                            <p class="text-black-500 text-sm mb-2"><strong>Note:</strong></p>
                                            {{-- @if ($order->note)
                                                    <p class="text-black-500 text-sm">No sugar</p>
                                                @else
                                                    <p class="text-black-500 text-sm">No Note</p>
                                                @endif --}}
                                            <div class="flex items-center justify-center">
                                                <button id="finishButton" data-id="{{ $order->id }}"
                                                    class="w-[177px] h-[41px] rounded-[10px] bg-[#263238] text-white font-bold flex items-center justify-center hover:bg-gray-700 mt-5">
                                                    Finish
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Completed Orders Tab -->
        <div id="completed-orders" class="tab-content" style="display: none;">
            <div class="grid grid-cols-5 gap-6 my-6 mx-10">
                @foreach ($orders as $order)
                    @if ($order->order_status === 'ready')
                        <div class="order-card">
                            <div class=" ">
                                <div class="bg-[#18BD63] text-white p-2">
                                    <div class="ml-10">
                                        <h3 class="font-bold">{{ $order->order_number }}</h3>
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->date)->format('d M') }}
                                        </p> <!-- Order Date -->
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->time)->format('H:i:s') }}</p>
                                        <!-- Order Time -->
                                    </div>
                                </div>
                                <div class="p-4 bg-white shadow-lg">
                                    <div>
                                        <ul class="space-y-2">
                                            {{-- @dd($order->products) --}}

                                            @foreach ($order->items as $item)
                                                <li class="flex justify-between">
                                                    <div>
                                                        <span>{{ $item->name }}</span>
                                                        <br>
                                                        {{-- @if ($item->has_customization)
                                                            <span class="text-black text-sm block">22oz</span>
                                                        @endif --}}
                                                    </div>
                                                    {{-- <span>{{$order->order_products->quantity}}</span> --}}
                                                    <span>x {{ $item->quantity }}</span>
                                                    <!-- Get the quantity -->
                                                </li>
                                            @endforeach

                                            <li class="flex justify-between">
                                                <div>
                                                    <span>Iced Mocha</span>
                                                    <br>
                                                    <span class="text-black-500 text-sm block">22oz</span>
                                                </div>
                                                <span>x 1</span>
                                            </li>
                                        </ul>
                                        <hr class="my-5">
                                        <div class="mt-4">
                                            <p class="text-black-500 text-sm mb-2"><strong>Note:</strong></p>
                                            {{-- @if ($order->note)
                                                    <p class="text-black-500 text-sm">No sugar</p>
                                                @else
                                                    <p class="text-black-500 text-sm">No Note</p>
                                                @endif --}}
                                            <div class="flex items-center justify-center">
                                                <button id="printButton" data-id="{{ $order->id }}"
                                                    class="w-[177px] h-[41px] rounded-[10px] bg-[#263238] text-white font-bold flex items-center justify-center hover:bg-gray-700 mt-5">
                                                    Print
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Add more cards here -->

    {{-- <div>
        <div class="tabs">
            <button wire:click="$set('status', 'new')">New Orders</button>
            <button wire:click="$set('status', 'in_progress')">In-Progress Orders</button>
            <button wire:click="$set('status', 'completed')">Completed Orders</button>
        </div>

        <div class="orders">
            @foreach ($orders as $order)
                <div class="order-card">
                    <h4>Order Number: {{ $order->order_number }}</h4>
                    <p>{{ $order->created_at->format('d M Y H:i:s') }}</p>
                    <ul>
                        @foreach (json_decode($order->items, true) as $item)
                            <li>{{ $item['name'] }} x {{ $item['quantity'] }} ({{ $item['size'] }})</li>
                        @endforeach
                    </ul>
                    <p>Note: {{ $order->note }}</p>
                    <button wire:click="updateStatus({{ $order->id }}, 'in_progress')">Start</button>
                </div>
            @endforeach
        </div>
    </div> --}}
    <script>
        //
        // inactive font - 555555
        // inactive button - 9D9D9D

        // active font - black
        // active button - white

        // document.getElementById('startButton').addEventListener('click', function() {
        //     // Assuming orderId is available or can be retrieved dynamically
        //     const orderId = document.getElementById('startButton').getAttribute('data-id');
        //     // Get CSRF token from meta tag
        //     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        //     fetch('http://127.0.0.1:8002/update-order-status', {
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': csrfToken,
        //                 'Content-Type': 'application/json',
        //             },
        //             body: JSON.stringify({
        //                 orderId: orderId,
        //                 status: 'preparing',
        //             })
        //         })
        //         .then(response => {
        //             if (!response.ok) {
        //                 // Handle HTTP errors
        //                 throw new Error('Server error, status code: ' + response.status);
        //             }
        //             return response.json();
        //         })
        //         .then(data => {
        //             if (data.success) {
        //                 // Optionally update the UI to reflect the new status
        //                 console.log('Order status updated to preparing');
        //             } else {
        //                 console.log('Error updating status:', data.error);
        //             }
        //         })
        //         .catch(error => {
        //             console.log('Error:', error);
        //         });
        // });

        // document.getElementById('finishButton').addEventListener('click', function() {
        //     // Assuming orderId is available or can be retrieved dynamically
        //     const orderId = document.getElementById('finishButton').getAttribute('data-id');
        //     // Get CSRF token from meta tag
        //     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        //     fetch('http://127.0.0.1:8002/update-order-status', {
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': csrfToken,
        //                 'Content-Type': 'application/json',
        //             },
        //             body: JSON.stringify({
        //                 orderId: orderId,
        //                 status: 'ready',
        //             })
        //         })
        //         .then(response => {
        //             if (!response.ok) {
        //                 // Handle HTTP errors
        //                 throw new Error('Server error, status code: ' + response.status);
        //             }
        //             return response.json();
        //         })
        //         .then(data => {
        //             if (data.success) {
        //                 // Optionally update the UI to reflect the new status
        //                 console.log('Order status updated to preparing');
        //             } else {
        //                 console.log('Error updating status:', data.error);
        //             }
        //         })
        //         .catch(error => {
        //             console.log('Error:', error);
        //         });
        // });

        // document.getElementById('printButton').addEventListener('click', function() {
        //     // Assuming orderId is available or can be retrieved dynamically
        //     const orderId = document.getElementById('printButton').getAttribute('data-id');
        //     // Get CSRF token from meta tag
        //     const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        //     fetch('http://127.0.0.1:8002/update-order-status', {
        //             method: 'POST',
        //             headers: {
        //                 'X-CSRF-TOKEN': csrfToken,
        //                 'Content-Type': 'application/json',
        //             },
        //             body: JSON.stringify({
        //                 orderId: orderId,
        //                 status: 'completed',
        //             })
        //         })
        //         .then(response => {
        //             if (!response.ok) {
        //                 // Handle HTTP errors
        //                 throw new Error('Server error, status code: ' + response.status);
        //             }
        //             return response.json();
        //         })
        //         .then(data => {
        //             if (data.success) {
        //                 // Optionally update the UI to reflect the new status
        //                 console.log('Order status updated to preparing');
        //             } else {
        //                 console.log('Error updating status:', data.error);
        //             }
        //         })
        //         .catch(error => {
        //             console.log('Error:', error);
        //         });
        // });

        function showTab(tabId, clickedButton) {
            // Hide all tab content
            document.querySelectorAll('.tab-content').forEach((content) => {
                content.style.display = 'none';
            });

            // Show the selected tab
            document.getElementById(tabId).style.display = 'block';

            // Reset all buttons to inactive state
            document.querySelectorAll('.tab-button').forEach((button) => {
                button.classList.remove('active');
                button.style.backgroundColor = '#9D9D9D'; // Inactive button color
                button.style.color = '#555555'; // Inactive font color
            });

            // Set the clicked button to active state
            clickedButton.classList.add('active');
            clickedButton.style.backgroundColor = 'white'; // Active button color
            clickedButton.style.color = 'black'; // Active font color
        }

        document.querySelectorAll('.tab-button').forEach((button) => {
            button.classList.remove('active');
        });

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('startButton').addEventListener('click', function() {
                const orderId = document.getElementById('startButton').getAttribute('data-id');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('http://127.0.0.1:8002/update-order-status', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            orderId: orderId,
                            status: 'preparing',
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Server error, status code: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            console.log('Order status updated to preparing');
                        } else {
                            console.log('Error updating status:', data.error);
                        }
                    })
                    .catch(error => {
                        console.log('Error:', error);
                    });
            });

            document.getElementById('finishButton').addEventListener('click', function() {
                const orderId = document.getElementById('finishButton').getAttribute('data-id');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('http://127.0.0.1:8002/update-order-status', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            orderId: orderId,
                            status: 'ready',
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Server error, status code: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            console.log('Order status updated to ready');
                        } else {
                            console.log('Error updating status:', data.error);
                        }
                    })
                    .catch(error => {
                        console.log('Error:', error);
                    });
            });

            document.getElementById('printButton').addEventListener('click', function() {
                const orderId = document.getElementById('printButton').getAttribute('data-id');
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                fetch('http://127.0.0.1:8002/update-order-status', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            orderId: orderId,
                            status: 'completed',
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Server error, status code: ' + response.status);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            console.log('Order status updated to completed');
                        } else {
                            console.log('Error updating status:', data.error);
                        }
                    })
                    .catch(error => {
                        console.log('Error:', error);
                    });
            });
        });
    </script>
</body>

</html>
