<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - Order Ready</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/js/store/create-product.js', 'resources/js/globalUtils/notifications.js'])
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    @include('layouts.header')
    @include('layouts.notifications')

    <main class="flex-grow flex items-center justify-center p-2 sm:p-4 md:my-10">
        <div class="w-full max-w-4xl bg-white shadow-xl md:shadow-2xl rounded-xl md:rounded-2xl overflow-hidden">

            <div class="w-full p-5 sm:p-8 md:p-10">
                <div class="mb-6">
                    <a href="{{ route('seller.store.index') }}"
                        class="inline-flex items-center text-sm font-bold text-gray-500 hover:text-blue-600 transition-colors group">
                        <i class="fa-solid fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                        Back to My Store
                    </a>
                </div>

                <div class="text-center mb-6 md:mb-8">
                    <div
                        class="inline-flex items-center justify-center w-12 h-12 md:w-16 md:h-16 bg-blue-50 text-blue-600 rounded-full mb-3 md:mb-4">
                        <i class="fa-solid fa-cart-plus text-xl md:text-2xl"></i>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Add New Product</h2>
                    <p class="text-sm md:text-base text-gray-500 mt-1 md:mt-2">Create a new listing for your store</p>
                </div>

                <form id="product-form" action="{{ route('seller.store.store-product') }}" method="POST"
                    enctype="multipart/form-data" class="space-y-5 md:space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="md:col-span-2">
                            <label
                                class="block text-gray-700 mb-1.5 md:mb-2 font-semibold px-1 text-sm md:text-base">Product
                                Name</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="fa-solid fa-tag text-sm"></i>
                                </span>
                                <input type="text" name="name" value="{{ old('name') }}"
                                    placeholder="Enter product name"
                                    class="w-full pl-11 pr-4 py-2.5 md:py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white text-sm md:text-base"
                                    required>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label
                                class="block text-gray-700 mb-1.5 md:mb-2 font-semibold px-1 text-sm md:text-base">Description</label>
                            <textarea name="description" rows="4" placeholder="Describe your product..."
                                class="w-full px-4 py-2.5 md:py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white text-sm md:text-base"
                                required>{{ old('description') }}</textarea>
                        </div>

                        <div class="col-span-1">
                            <label
                                class="block text-gray-700 mb-1.5 md:mb-2 font-semibold px-1 text-sm md:text-base">Price
                                ($)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="fa-solid fa-dollar-sign text-sm"></i>
                                </span>
                                <input type="number" name="price" value="{{ old('price') }}" step="0.01"
                                    placeholder="0.00"
                                    class="w-full pl-11 pr-4 py-2.5 md:py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white text-sm md:text-base"
                                    required>
                            </div>
                        </div>

                        <div class="col-span-1">
                            <label
                                class="block text-gray-700 mb-1.5 md:mb-2 font-semibold px-1 text-sm md:text-base">Discount
                                (Optional)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="fa-solid fa-arrow-down-long text-sm"></i>
                                </span>
                                <input type="number" name="discount_price" value="{{ old('discount_price') }}"
                                    step="0.01" placeholder="0.00"
                                    class="w-full pl-11 pr-4 py-2.5 md:py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white text-sm md:text-base">
                            </div>
                        </div>

                        <div class="col-span-1">
                            <label
                                class="block text-gray-700 mb-1.5 md:mb-2 font-semibold px-1 text-sm md:text-base">Category</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="fa-solid fa-layer-group text-sm"></i>
                                </span>
                                <select name="category_id"
                                    class="w-full pl-11 pr-4 py-2.5 md:py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white appearance-none text-sm md:text-base"
                                    required>
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-span-1 flex items-center">
                            <label class="flex items-center cursor-pointer group mt-2 md:mt-6">
                                <input type="checkbox" name="is_negotiable" value="1"
                                    {{ old('is_negotiable') ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 border-gray-300 rounded-lg focus:ring-blue-500 transition-all">
                                <span
                                    class="ml-3 text-gray-700 font-semibold group-hover:text-gray-900 transition-colors text-sm md:text-base">Negotiable</span>
                            </label>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-6 md:my-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">
                        <div class="space-y-3">
                            <label class="block text-gray-700 font-semibold px-1 text-sm md:text-base">Primary
                                Image</label>
                            <div
                                class="relative border-2 border-dashed border-gray-200 rounded-2xl h-64 hover:border-blue-400 transition-colors bg-slate-50 flex items-center justify-center group">
                                <input type="file" name="primary_image" accept="image/*"
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                                <div class="space-y-2 text-center">
                                    <i
                                        class="fa-solid fa-cloud-arrow-up text-3xl text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                    <p class="text-xs md:text-sm text-gray-500 font-medium">Click to upload main photo
                                    </p>
                                </div>

                                <div class="absolute inset-0 hidden bg-slate-50 rounded-2xl overflow-hidden"
                                    id="primary-preview-container">
                                    <img src="" id="primary-preview" class="w-full h-full object-contain p-2">
                                    <button type="button"
                                        class="absolute top-2 right-2 bg-red-500 text-white w-8 h-8 rounded-full shadow-lg z-20 flex items-center justify-center hover:bg-red-700 transition-colors">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <label class="block text-gray-700 font-semibold px-1 text-sm md:text-base">Gallery
                                Images</label>
                            <div
                                class="relative border-2 border-dashed border-gray-200 rounded-2xl p-6 hover:border-blue-400 transition-colors bg-slate-50 text-center group h-32 flex items-center justify-center">
                                <input type="file" name="gallery_temp" accept="image/*" multiple
                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="space-y-1">
                                    <i
                                        class="fa-solid fa-images text-2xl text-gray-400 group-hover:text-blue-500 transition-colors"></i>
                                    <p class="text-[10px] md:text-xs text-gray-500 font-medium">Upload gallery photos
                                    </p>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 sm:grid-cols-4 gap-2 mt-4" id="gallery-preview"></div>
                        </div>
                    </div>

                    <div class="pt-4 md:pt-6">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3.5 md:py-4 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all active:scale-[0.98] text-sm md:text-base">
                            <i class="fa-solid fa-plus mr-2"></i> Create Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>
