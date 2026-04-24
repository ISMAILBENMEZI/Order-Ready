<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Product - {{ $product->name }}</title>
    @include('layouts.head')
    @vite(['resources/js/store/edit-product.js', 'resources/js/globalUtils/notifications.js'])
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
                        <i class="fa-solid fa-pen-to-square text-xl md:text-2xl"></i>
                    </div>
                    <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Edit Product</h2>
                    <p class="text-sm md:text-base text-gray-500 mt-1 md:mt-2">Update information for:
                        <strong>{{ $product->name }}</strong>
                    </p>
                </div>

                <form id="edit-product-form" action="{{ route('seller.store.update-product', $product->id) }}"
                    method="POST" enctype="multipart/form-data" class="space-y-5 md:space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                        <div class="md:col-span-2">
                            <label
                                class="block text-gray-700 mb-1.5 md:mb-2 font-semibold px-1 text-sm md:text-base">Product
                                Name</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="fa-solid fa-tag text-sm"></i>
                                </span>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                    class="w-full pl-11 pr-4 py-2.5 md:py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white text-sm md:text-base"
                                    required>
                            </div>
                        </div>

                        <div class="md:col-span-2">
                            <label
                                class="block text-gray-700 mb-1.5 md:mb-2 font-semibold px-1 text-sm md:text-base">Description</label>
                            <textarea name="description" rows="4"
                                class="w-full px-4 py-2.5 md:py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white text-sm md:text-base"
                                required>{{ old('description', $product->description) }}</textarea>
                        </div>

                        <div class="col-span-1">
                            <label
                                class="block text-gray-700 mb-1.5 md:mb-2 font-semibold px-1 text-sm md:text-base">Price
                                ($)</label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                    <i class="fa-solid fa-dollar-sign text-sm"></i>
                                </span>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                    step="0.01"
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
                                <input type="number" name="discount_price"
                                    value="{{ old('discount_price', $product->discount_price) }}" step="0.01"
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
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-span-1 flex items-center">
                            <label class="flex items-center cursor-pointer group mt-2 md:mt-6">
                                <input type="checkbox" name="is_negotiable" value="1"
                                    {{ $product->is_negotiable ? 'checked' : '' }}
                                    class="w-5 h-5 text-blue-600 border-gray-300 rounded-lg focus:ring-blue-500 transition-all">
                                <span
                                    class="ml-3 text-gray-700 font-semibold group-hover:text-gray-900 transition-colors text-sm md:text-base">Negotiable</span>
                            </label>
                        </div>
                    </div>

                    <hr class="border-gray-100 my-6 md:my-8">

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 md:gap-8">

                        <div class="space-y-3">
                            <label class="block text-gray-700 font-bold px-1 text-sm md:text-base">Primary Image</label>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div
                                    class="relative w-full h-48 md:h-64 bg-slate-100 rounded-2xl border border-gray-200 overflow-hidden flex items-center justify-center">
                                    @php $primary = $product->images->where('is_primary', true)->first(); @endphp

                                    <img id="primary-preview" src="{{ $primary ? Storage::url($primary->image_url) : '' }}"
                                        class="max-w-full max-h-full object-contain p-2 {{ $primary ? '' : 'hidden' }}">

                                    @if (!$primary)
                                        <div id="no-image-text"
                                            class="text-gray-400 text-sm flex flex-col items-center">
                                            <i class="fa-solid fa-image text-3xl mb-2"></i>
                                            <span>No image selected</span>
                                        </div>
                                    @endif

                                    <div
                                        class="absolute top-2 right-2 bg-blue-600 text-white text-[10px] px-2 py-1 rounded-full uppercase font-bold shadow-sm">
                                        Current View
                                    </div>
                                </div>

                                <div
                                    class="relative h-48 md:h-64 border-2 border-dashed border-gray-200 rounded-2xl hover:border-blue-400 transition-all bg-white flex flex-col items-center justify-center group cursor-pointer">
                                    <input type="file" name="primary_image" id="primary-input" accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-20">
                                    <div class="text-center p-4">
                                        <i
                                            class="fa-solid fa-cloud-arrow-up text-3xl text-gray-300 group-hover:text-blue-500 transition-colors mb-2"></i>
                                        <p class="text-sm text-gray-500 font-medium">Click to replace photo</p>
                                        <p class="text-[11px] text-gray-400 mt-1">Recommended: Square or 4:3 ratio</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 mt-8">
                            <label class="block text-gray-700 font-bold px-1 text-sm md:text-base">Gallery
                                Images</label>
                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-3" id="gallery-wrapper">

                                @foreach ($product->images->where('is_primary', false) as $image)
                                    <div
                                        class="relative aspect-square bg-white rounded-xl border border-gray-100 overflow-hidden shadow-sm group">
                                        <img src="{{ Storage::url($image->image_url) }}" class="w-full h-full object-contain p-1">
                                        <button type="button"
                                            class="delete-image-btn absolute top-1 right-1 bg-red-500 text-white w-6 h-6 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg"
                                            data-id="{{ $image->id }}">
                                            <i class="fa-solid fa-times text-xs"></i>
                                        </button>
                                    </div>
                                @endforeach

                                <div
                                    class="relative aspect-square border-2 border-dashed border-gray-200 rounded-xl flex items-center justify-center hover:bg-blue-50 hover:border-blue-300 transition-all group cursor-pointer">
                                    <input type="file" name="imagesinternal[]" multiple accept="image/*"
                                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                    <i class="fa-solid fa-plus text-gray-300 group-hover:text-blue-500 text-xl"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="deleted_images" id="deleted-images">

                    <div class="pt-4 md:pt-6">
                        <button type="submit"
                            class="w-full bg-blue-600 text-white py-3.5 md:py-4 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all active:scale-[0.98] text-sm md:text-base">
                            <i class="fa-solid fa-rotate mr-2"></i> Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>
