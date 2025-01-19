<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    </style>
</head>

<body class="bg-gray-100">
    <!-- Navbar -->
    <header class="sticky top-0 z-10 bg-white" style="height: 80px; box-shadow: 0 4px 6px rgba(139, 69, 19, 0.3);">
        <div class="flex items-center justify-between h-full px-2 mx-auto max-w-[95vw]">
            <!-- Logo and Text -->
            <div class="flex items-center space-x-3">
                <img src="assets/Caffeinated Logo.png" alt="Caffeinated Logo" class="w-12 h-12">
                <div class="flex items-center">
                    <div>
                        <span class="text-2xl font-bold leading-none text-black">CAFFEINATED</span>
                        <p class="text-sm font-medium text-gray-500">Kitchen Display System</p>
                    </div>
                </div>
            </div>
            <!-- Search Bar, Basket Icon, and Buttons -->
            <div class="flex items-center space-x-2">
                <!-- Admin Button -->
                <button
                    class="flex items-center justify-center w-40 h-10 px-6 py-3 text-lg text-white bg-black rounded-full hover:bg-brown-600">
                    <img src="assets/Default User.png" alt="User" class="w-5 h-5 mr-2">Admin
                </button>
            </div>
        </div>
    </header>

    {{-- 1C3D34 --}}

    {{-- TABS FOR ORDER PROCESSING --}}
    <div class="bg-[#1C3D34] relative sticky z-10 h-[200px] bg-center bg-cover top-20">
        <div class="absolute inset-0 flex items-center justify-between px-5 bg-black bg-opacity-30">
            <!-- Tabs -->
            <div class="tabs flex space-x-5 ml-[60px]">
                <button
                    class="w-[188px] h-[37px] rounded-[18.5px] bg-white hover:bg-gray-200 focus:ring-2 focus:ring-gray-300"
                    onclick="">
                    New Orders
                </button>
                <button
                    class="w-[188px] h-[37px] rounded-[18.5px] bg-white hover:bg-gray-200 focus:ring-2 focus:ring-gray-300"
                    onclick="">
                    In-Progress Orders
                </button>
                <button
                    class="w-[188px] h-[37px] rounded-[18.5px] bg-white hover:bg-gray-200 focus:ring-2 focus:ring-gray-300"
                    onclick="">
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
                    <span class="text-sm text-white">New Orders</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        3
                    </div>
                    <!-- Label -->
                    <span class="text-sm text-white">Processed</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        4
                    </div>
                    <!-- Label -->
                    <span class="text-sm text-white">Ready</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        10
                    </div>
                    <!-- Label -->
                    <span class="text-sm text-white">Served</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Order Cards Grid -->
    <div class="grid grid-cols-4 gap-4 mx-10 my-6">
        <!-- Order Card -->

        <div class="">
            <div class="p-2 text-white bg-red-500">
                <div class="ml-10">
                    <h3 class="font-bold">Order Number</h3>
                    <p class="font-bold">25 Dec</p>
                    <p class="text-sm font-bold">07:09:26</p>
                </div>
            </div>
            <div class="p-4 bg-white shadow-lg">
                <div>
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Americano</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 2</span>
                        </li>
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Mocha</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 1</span>
                        </li>
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Americano</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 2</span>
                        </li>
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Americano</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 2</span>
                        </li>
                    </ul>
                    <hr class="my-5">
                    <div class="mt-4">
                        <p class="text-sm text-black-500"><strong>Note:</strong></p>
                        <p class="text-sm text-black-500">No sugar</p>
                        <div class="flex items-center justify-center">
                            <button
                                class="w-[177px] h-[41px] rounded-[10px] bg-[#263238] text-white font-bold flex items-center justify-center hover:bg-gray-700 mt-5">
                                Start
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- order card for in progress orders --}}
        <div class="">
            <div class="bg-[#EEAA00] text-white p-2">
                <div class="ml-10">
                    <h3 class="font-bold">Order Number</h3>
                    <p class="font-bold">25 Dec</p>
                    <p class="text-sm font-bold">07:09:26</p>
                </div>
            </div>
            <div class="p-4 bg-white shadow-lg">
                <div>
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Americano</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 2</span>
                        </li>
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Mocha</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 1</span>
                        </li>
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Americano</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 2</span>
                        </li>
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Americano</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 2</span>
                        </li>
                    </ul>
                    <hr class="my-5">
                    <div class="mt-4">
                        <p class="text-sm text-black-500"><strong>Note:</strong></p>
                        <p class="text-sm text-black-500">No sugar</p>
                        <div class="flex items-center justify-center">
                            <button
                                class="w-[177px] h-[41px] rounded-[10px] bg-[#263238] text-white font-bold flex items-center justify-center hover:bg-gray-700 mt-5">
                                Finish
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- order card for completed orders --}}
        <div class="">
            <div class="bg-[#18BD63] text-white p-2">
                <div class="ml-10">
                    <h3 class="font-bold">Order Number</h3>
                    <p class="font-bold">25 Dec</p>
                    <p class="text-sm font-bold">07:09:26</p>
                </div>
            </div>
            <div class="p-4 bg-white shadow-lg">
                <div>
                    <ul class="space-y-2">
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Americano</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 2</span>
                        </li>
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Mocha</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 1</span>
                        </li>
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Americano</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 2</span>
                        </li>
                        <li class="flex justify-between">
                            <div>
                                <span>Iced Americano</span>
                                <br>
                                <span class="block text-sm text-black-500">22oz</span>
                            </div>
                            <span>x 2</span>
                        </li>
                    </ul>
                    <hr class="my-5">
                    <div class="mt-4">
                        <p class="text-sm text-black-500"><strong>Note:</strong></p>
                        <p class="text-sm text-black-500">No sugar</p>
                        <div class="flex items-center justify-center">
                            <button
                                class="w-[177px] h-[41px] rounded-[10px] bg-[#263238] text-white font-bold flex items-center justify-center hover:bg-gray-700 mt-5">
                                Print
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Repeat the order card as needed -->




        @for ($count = 1; $count <= 5; $count++)
            <div class="">
                <div class="p-2 text-white bg-red-500">
                    <div class="ml-10">
                        <h3 class="font-bold">Order Number</h3>
                        <p class="font-bold">25 Dec</p>
                        <p class="text-sm font-bold">07:09:26</p>
                    </div>
                </div>
                <div class="p-4 bg-white shadow-lg">
                    <div>
                        <ul class="space-y-2">
                            <li class="flex justify-between">
                                <div>
                                    <span>Iced Americano</span>
                                    <br>
                                    <span class="block text-sm text-black-500">22oz</span>
                                </div>
                                <span>x 2</span>
                            </li>
                            <li class="flex justify-between">
                                <div>
                                    <span>Iced Mocha</span>
                                    <br>
                                    <span class="block text-sm text-black-500">22oz</span>
                                </div>
                                <span>x 1</span>
                            </li>
                        </ul>
                        <hr class="my-5">
                        <div class="mt-4">
                            <p class="text-sm text-black-500"><strong>Note:</strong></p>
                            <p class="text-sm text-black-500">No sugar</p>
                            <div class="flex items-center justify-center">
                                <button
                                    class="w-[177px] h-[41px] rounded-[10px] bg-[#263238] text-white font-bold flex items-center justify-center hover:bg-gray-700 mt-5">
                                    Start
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endfor




        <!-- Add more cards here -->
    </div>


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

</body>

</html>
