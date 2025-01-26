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

    {{-- <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('assets/js/script.js') }}" defer></script> --}}

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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

    {{-- @livewireStyles --}}
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
                    onclick="showTab('new-orders', this)" wire:click="setActiveTab('new-orders')">
                    New Orders
                </button>
                <button
                    class="tab-button w-[188px] h-[37px] rounded-[18.5px] bg-[#9D9D9D] text-[#555555] hover:bg-gray-200 focus:ring-2 focus:ring-gray-300"
                    onclick="showTab('in-progress-orders', this)" wire:click="setActiveTab('in-progress-orders')">
                    In-Progress Orders
                </button>
                <button
                    class="tab-button w-[188px] h-[37px] rounded-[18.5px] bg-[#9D9D9D] text-[#555555] hover:bg-gray-200 focus:ring-2 focus:ring-gray-300"
                    onclick="showTab('completed-orders', this)" wire:click="setActiveTab('completed-orders')">
                    Completed Orders
                </button>
            </div>

            <!-- Order Stats -->
            <div class="order-stats flex justify-end items-center space-x-10 mt-2 mr-[60px]">
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="newOrders flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        0
                    </div>
                    <!-- Label -->
                    <span class="text-white text-sm">New Orders</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="processed flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        0
                    </div>
                    <!-- Label -->
                    <span class="text-white text-sm">Processed</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="ready flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        0
                    </div>
                    <!-- Label -->
                    <span class="text-white text-sm">Ready</span>
                </div>
                <div class="flex flex-col items-center space-y-2">
                    <!-- Circle with Number -->
                    <div
                        class="served flex items-center justify-center bg-white text-[#1C3D34] font-bold text-3xl w-[50px] h-[50px] rounded-full">
                        0
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
        <div id="new-orders" class="tab-content" style="display: block;" wire:show="activeTab === 'new-orders'"
            data-tab="new-orders">
            <div class="grid grid-cols-5 gap-6 my-6 mx-10">
                @foreach ($orders as $order)
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
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d-M') }}</p>
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->order_time)->format('H:i A') }}</p>
                                    </div>
                                </div>
                                <div class="p-4 bg-white shadow-lg">
                                    <div>
                                        <ul class="space-y-2">

                                            @foreach ($order->orderItems as $item)
                                                <li class="flex justify-between">
                                                    <div>
                                                        <span>{{ $item->name }}</span>
                                                        <br>
                                                        @if ($item->has_customization)
                                                            <span class="text-black text-sm block">22oz</span>
                                                        @endif
                                                    </div>
                                                    <span>x {{ $item->quantity }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <hr class="my-5">
                                        <div class="mt-4">
                                            <p class="text-black-500 text-sm mb-2"><strong>Note:</strong></p>
                                            <p class="text-black-500 text-sm">{{ $order->note }}</p>
                                            <div class="flex items-center justify-center">
                                                <button id="startButton-{{ $order->id }}"
                                                    data-id="{{ $order->id }}"
                                                    onclick="updateOrderStatus({{ $order->id }}, this, 'preparing')"
                                                    class="startButton w-[177px] h-[41px] rounded-[10px] bg-[#263238] text-white font-bold flex items-center justify-center hover:bg-gray-700 mt-5">
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
        <div id="in-progress-orders" class="tab-content" style="display: none;"
            wire:show="activeTab === 'in-progress-orders'" data-tab="in-progress-orders">
            <div class="grid grid-cols-5 gap-6 my-6 mx-10">
                @foreach ($orders as $order)
                    @if ($order->order_status === 'preparing')
                        <div class="order-card">
                            <div class=" ">
                                <div class="bg-[#EEAA00] text-white p-2">
                                    <div class="ml-10">
                                        <h3 class="font-bold">{{ $order->order_number }}</h3>
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d-M') }}</p>
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->order_time)->format('H:i A') }}</p>
                                    </div>
                                </div>
                                <div class="p-4 bg-white shadow-lg">
                                    <div>
                                        <ul class="space-y-2">

                                            @foreach ($order->orderItems as $item)
                                                <li class="flex justify-between">
                                                    <div>
                                                        <span>{{ $item->name }}</span>
                                                        <br>
                                                        @if ($item->has_customization)
                                                            <span class="text-black text-sm block">22oz</span>
                                                        @endif
                                                    </div>
                                                    <span>x {{ $item->quantity }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <hr class="my-5">
                                        <div class="mt-4">
                                            <p class="text-black-500 text-sm mb-2"><strong>Note:</strong></p>
                                            <p class="text-black-500 text-sm">{{ $order->note }}</p>
                                            <div class="flex items-center justify-center">
                                                <button id="finishButton" data-id="{{ $order->id }}"
                                                    onclick="updateOrderStatus({{ $order->id }}, this, 'ready')"
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
        <div id="completed-orders" class="tab-content" style="display: none;" data-tab="completed-orders">
            <div class="grid grid-cols-5 gap-6 my-6 mx-10">
                @foreach ($orders as $order)
                    @if ($order->order_status === 'ready')
                        <div class="order-card">
                            <div class=" ">
                                <div class="bg-[#18BD63] text-white p-2">
                                    <div class="ml-10">
                                        <h3 class="font-bold">{{ $order->order_number }}</h3>
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->order_date)->format('d-M') }}</p>
                                        <p class="text-sm font-bold">
                                            {{ \Carbon\Carbon::parse($order->order_time)->format('H:i A') }}</p>
                                    </div>
                                </div>
                                <div class="p-4 bg-white shadow-lg">
                                    <div>
                                        <ul class="space-y-2">

                                            @foreach ($order->orderItems as $item)
                                                <li class="flex justify-between">
                                                    <div>
                                                        <span>{{ $item->name }}</span>
                                                        <br>
                                                        @if ($item->has_customization)
                                                            <span class="text-black text-sm block">22oz</span>
                                                        @endif
                                                    </div>
                                                    <span>x {{ $item->quantity }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                        <hr class="my-5">
                                        <div class="mt-4">
                                            <p class="text-black-500 text-sm mb-2"><strong>Note:</strong></p>
                                            <p class="text-black-500 text-sm">{{ $order->note }}</p>
                                            <div class="flex items-center justify-center">
                                                <button id="printButton" data-id="{{ $order->id }}"
                                                    onclick="updateOrderStatus({{ $order->id }}, this, 'completed')"
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
    <script>
        // const startButtons = document.querySelectorAll(".startButton");
        // const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // window.addEventListener("load", () => {
        //     console.log('Loading...');

        //     updateHeader();
        // });

        // function updateHeader() {
        //     // pending, preparing, ready, completed
        //     // newOrders, processed, ready, served

        //     // get the div that has a class of newOrders, processed, ready, served
        //     const newOrders = document.querySelector('.newOrders');
        //     const processed = document.querySelector('.processed');
        //     const ready = document.querySelector('.ready');
        //     const served = document.querySelector('.served');

        //     fetch('/header', {
        //             method: 'GET',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'Accept': 'application/json',
        //                 'X-CSRF-TOKEN': csrfToken,
        //             },
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             newOrders.textContent = data.newOrders;
        //             processed.textContent = data.processed;
        //             ready.textContent = data.ready;
        //             served.textContent = data.served;
        //         })
        //         .catch(error => {
        //             console.error(error);
        //             alert('An error occurred. Please try again.');
        //         });
        // }

        // window.showTab = function(tab, clickedButton) {
        //     const allDivs = document.querySelectorAll(".tab-content");

        //     const bgActive = 'bg-white';
        //     const textActive = 'text-black';
        //     const bgInactive = 'bg-[#9D9D9D]';
        //     const textInactive = 'text-[#555555]';

        //     console.log("filter tab is clicked " + tab);

        //     allDivs.forEach((div) => {
        //         if (div.getAttribute("data-tab") === tab) {
        //             div.style.display = "block";
        //         } else {
        //             div.style.display = "none";
        //         }
        //     });

        //     // Reset all buttons to inactive style
        //     const allButtons = document.querySelectorAll('.tab-button');
        //     allButtons.forEach((button) => {
        //         button.classList.remove(bgActive, textActive);
        //         button.classList.add(bgInactive, textInactive);
        //     });

        //     // Set the clicked button as active
        //     clickedButton.classList.remove(bgInactive, textInactive);
        //     clickedButton.classList.add(bgActive, textActive);
        // };

        // window.updateOrderStatus = function(orderId, button, status) {
        //     fetch('/orders/update-status', {
        //             method: 'POST',
        //             headers: {
        //                 'Content-Type': 'application/json',
        //                 'Accept': 'application/json',
        //                 'X-CSRF-TOKEN': csrfToken,
        //             },
        //             body: JSON.stringify({
        //                 order_id: orderId,
        //                 status: status,
        //             }),
        //         })
        //         .then(response => response.json())
        //         .then(data => {
        //             if (status === 'preparing') {
        //                 button.textContent = 'Preparing...';
        //             } else if (status === 'ready') {
        //                 button.textContent = 'Ready...';
        //             } else if (status === 'completed') {
        //                 button.textContent = 'Completed...';
        //             }
        //             button.disabled = true;
        //             button.classList.add('bg-gray-500', 'cursor-not-allowed');

        //             location.reload();
        //         })
        //         .catch(error => {
        //             console.error(error);
        //             alert('An error occurred. Please try again.');
        //         });
        // }
    </script>
</body>

</html>
