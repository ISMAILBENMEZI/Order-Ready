<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Store - Product Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .shine-effect {
            position: relative;
            overflow: hidden;
        }

        .shine-effect::after {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.4), transparent);
            transform: skewX(-25deg);
            transition: 0.7s;
        }

        .group:hover .shine-effect::after {
            left: 125%;
        }

        .product-card {
            transition: all 0.2s ease-out;
        }

        .product-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px -10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    @include('layouts.header')
    @include('layouts.notifications')

    <main class="flex-grow pb-16">
        <div class="relative mb-16 md:mb-24">
            <div class="h-48 md:h-80 w-full overflow-hidden bg-slate-200 shadow-inner">
                @if ($store->banner_url)
                    <img src="{{ asset('storage/' . $store->banner_url) }}" class="w-full h-full object-cover"
                        alt="Store Banner">
                @else
                    <div
                        class="w-full h-full flex items-center justify-center bg-gradient-to-r from-slate-200 to-slate-300">
                        <i class="fa-regular fa-image text-slate-400 text-5xl"></i>
                    </div>
                @endif
            </div>

            <div class="max-w-7xl mx-auto px-4 md:px-8">
                <div class="relative -mt-16 md:-mt-24 flex flex-col md:flex-row items-end md:items-center gap-6">
                    <div class="relative group">
                        <div
                            class="w-32 h-32 md:w-48 md:h-48 bg-white p-1.5 rounded-3xl shadow-2xl border-4 border-white overflow-hidden">
                            @if ($store->logo_url)
                                <img src="{{ asset('storage/' . $store->logo_url) }}"
                                    class="w-full h-full object-cover rounded-2xl" alt="Logo">
                            @else
                                <div class="w-full h-full flex items-center justify-center bg-slate-50 rounded-2xl">
                                    <i class="fa-solid fa-store text-slate-200 text-5xl"></i>
                                </div>
                            @endif
                        </div>
                        <a href="{{ route('seller.store.edit') }}"
                            class="absolute -top-2 -right-2 bg-blue-600 text-white w-10 h-10 rounded-xl shadow-lg flex items-center justify-center border-4 border-white"><i
                                class="fa-solid fa-pen text-sm"></i></a>
                    </div>

                    <div class="flex-grow pb-2">
                        <h1 class="text-3xl md:text-5xl font-black text-gray-900 tracking-tight">{{ $store->name }}
                        </h1>
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full bg-blue-50 text-blue-700 text-sm font-bold mt-3">
                            <i class="fa-solid fa-box mr-2"></i> {{ $products->total() }} Products
                        </span>
                    </div>

                    <div class="pb-2 w-full md:w-auto">
                        <a href="{{ route('seller.store.create-product') }}"
                            class="flex items-center justify-center px-8 py-4 bg-blue-600 text-white font-bold rounded-2xl hover:bg-blue-700 shadow-xl">
                            <i class="fa-solid fa-plus mr-2"></i> Add New Product
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 md:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($products as $product)
                    <div id="product-{{ $product->id }}"
                        class="group product-card bg-white border border-gray-100 rounded-3xl overflow-hidden shadow-sm flex flex-col relative">

                 <div class="absolute top-4 right-4 z-30" x-data="{ open: false }">
    <button @click.prevent.stop="open = !open" type="button" 
        class="flex items-center gap-2 px-3 py-1.5 rounded-full text-[10px] uppercase font-black shadow-md border-2 border-white transition-all
        {{ $product->status == 'available' ? 'bg-green-500 text-white' : '' }}
        {{ $product->status == 'negotiating' ? 'bg-blue-600 text-white' : '' }}
        {{ $product->status == 'sold_out' ? 'bg-red-500 text-white' : '' }}">
        
        <span class="w-1.5 h-1.5 rounded-full bg-white {{ $product->status == 'negotiating' ? 'animate-pulse' : '' }}"></span>
        {{ str_replace('_', ' ', $product->status) }}
        <i class="fa-solid fa-chevron-down text-[8px] ml-1"></i>
    </button>

    <div x-show="open" @click.away="open = false" x-transition 
        class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-2xl border border-gray-100 py-2 z-50">
        
        @php
            $statuses = [
                'available' => ['label' => 'Available in stock', 'color' => 'bg-green-500'],
                'negotiating' => ['label' => 'Negotiating', 'color' => 'bg-blue-600'],
                'sold_out' => ['label' => 'Sold out', 'color' => 'bg-red-500'],
            ];
        @endphp

        @foreach($statuses as $key => $value)
            <form action="{{ route('seller.store.product.update-status', $product->id) }}" method="POST">
                @csrf 
                @method('PATCH')
                <input type="hidden" name="status" value="{{ $key }}">
                <button type="submit" 
                    class="w-full text-left px-4 py-2 text-[10px] font-bold text-gray-700 hover:bg-slate-50 flex items-center gap-3 transition-colors">
                    <div class="w-2.5 h-2.5 rounded-full {{ $value['color'] }}"></div>
                    {{ $value['label'] }}
                </button>
            </form>
        @endforeach
    </div>
</div>

                        <a href="{{ route('seller.store.show-product', $product->id) }}"
                            class="shine-effect block bg-gray-50 aspect-square">
                            <img src="{{ $product->primaryImage->image_url ?? asset('images/placeholder.jpg') }}"
                                class="w-full h-full object-contain p-2 group-hover:scale-105 transition-transform duration-500">
                        </a>

                        <div class="p-6 flex flex-col flex-grow">
                            <h2 class="text-lg font-bold text-gray-800 mb-2 truncate">{{ $product->name }}</h2>

                            <div class="mb-5">
                                @if ($product->discount_price && $product->discount_price < $product->price)
                                    <span
                                        class="text-2xl font-black text-blue-600">${{ number_format($product->discount_price, 2) }}</span>
                                    <span
                                        class="text-sm text-gray-400 line-through ml-2">${{ number_format($product->price, 2) }}</span>
                                @else
                                    <span
                                        class="text-2xl font-black text-gray-900">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>

                            <div class="mt-auto grid grid-cols-2 gap-3 pt-5 border-t border-gray-50">
                                <a href="{{ route('seller.store.edit-product', $product->id) }}"
                                    class="flex items-center justify-center px-4 py-2.5 bg-slate-50 text-slate-700 rounded-xl text-xs font-bold hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-pen mr-2"></i> Edit
                                </a>
                                <button onclick="deleteProduct({{ $product->id }})"
                                    class="flex items-center justify-center px-4 py-2.5 bg-slate-50 text-red-500 rounded-xl text-xs font-bold hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash mr-2"></i> Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-16">
                {{ $products->links() }}
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>
