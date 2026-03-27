<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>My Store - Order Ready</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/js/store/myStore.js' , 'resources/js/globalUtils/notifications.js'])
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

    <main class="flex-grow p-4 md:p-8">

        <div class="max-w-7xl mx-auto">

            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">My <span
                            class="text-blue-600">Store</span></h1>
                    <p class="text-gray-500 mt-1">Manage your products and listings</p>
                </div>

                <a href="{{ route('seller.store.create-product') }}"
                    class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all active:scale-95 text-sm md:text-base group">
                    <i class="fa-solid fa-plus mr-2 group-hover:rotate-90 transition-transform"></i> Add New Product
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div id="product-{{ $product->id }}"
                        class="group product-card bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm flex flex-col">

                        <a href="#" class="shine-effect relative block overflow-hidden bg-gray-100 aspect-square">
                            <img src="{{ $product->primaryImage->image_url ?? asset('images/placeholder.jpg') }}"
                                alt="{{ $product->name }}"
                                class="w-full h-full object-cover group-hover:scale-[1.02] transition-transform duration-500">

                            <div class="absolute top-3 right-3 z-10">
                                <span
                                    class="px-3 py-1 rounded-full text-[10px] uppercase font-bold shadow-sm 
                                {{ $product->status == 'active' ? 'bg-green-500 text-white' : 'bg-amber-500 text-white' }}">
                                    {{ $product->status }}
                                </span>
                            </div>
                        </a>

                        <div class="p-5 flex flex-col flex-grow">
                            <h2
                                class="text-base font-bold text-gray-800 mb-2 truncate group-hover:text-blue-600 transition-colors">
                                {{ $product->name }}</h2>

                            <div class="flex flex-col mb-4">
                                @if ($product->discount_price && $product->discount_price < $product->price)
                                    <div class="flex items-center gap-2">
                                        <span
                                            class="text-xl font-black text-blue-600">${{ number_format($product->discount_price, 2) }}</span>
                                        <span
                                            class="text-sm text-gray-400 line-through">${{ number_format($product->price, 2) }}</span>
                                        <span
                                            class="text-[10px] bg-red-50 text-red-500 px-1.5 py-0.5 rounded font-bold">SALE</span>
                                    </div>
                                @else
                                    <span
                                        class="text-xl font-black text-gray-900">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>

                            <div class="mt-auto grid grid-cols-2 gap-2 pt-4 border-t border-gray-50">
                                <a href="{{ route('seller.store.edit-product', $product->id) }}"
                                    class="flex items-center justify-center px-3 py-2 bg-slate-50 text-slate-700 rounded-lg text-xs font-bold hover:bg-blue-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-pen mr-2 text-[10px]"></i> Edit
                                </a>

                                <button onclick="deleteProduct({{ $product->id }})"
                                    class="w-full flex items-center justify-center px-3 py-2 bg-slate-50 text-red-500 rounded-lg text-xs font-bold hover:bg-red-600 hover:text-white transition-all">
                                    <i class="fa-solid fa-trash mr-2 text-[10px]"></i>
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-12">
                {{ $products->links() }}
            </div>

            @if ($products->isEmpty())
                <div class="text-center py-20 bg-white rounded-3xl border border-dashed border-gray-200">
                    <i class="fa-solid fa-box-open text-4xl text-gray-200 mb-4"></i>
                    <h3 class="text-lg font-bold text-gray-900">No products found</h3>
                    <p class="text-gray-500 text-sm">You haven't added any products yet.</p>
                </div>
            @endif

        </div>
    </main>

    @include('layouts.footer')

    {{-- Route place holders --}}
    {{-- SHOW: {{ route('seller.store.show-product', $product->id) }} --}}
</body>

</html>
