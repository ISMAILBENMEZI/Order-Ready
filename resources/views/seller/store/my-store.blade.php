<div class="max-w-7xl mx-auto p-6">

    <h1 class="text-3xl font-bold mb-6">My Store</h1>

    <div class="mb-4">
        <a href="{{ route('seller.store.create-product') }}" class="px-4 py-2 bg-green-600 text-white rounded">Add New
            Product</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @foreach ($products as $product)
            <div class="border p-4 rounded shadow hover:shadow-lg transition duration-200">
                <img src="{{ $product->primaryImage->image_url ?? 'placeholder.jpg' }}"
                    class="w-full h-48 object-cover mb-2 rounded">
                <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                <p class="text-blue-600 font-bold">${{ $product->price }}</p>
                <p class="text-sm text-gray-500">Status: {{ ucfirst($product->status) }}</p>

                <div class="mt-2 flex flex-wrap gap-2">
                    <a href="{{ route('seller.store.edit-product', $product->id) }}"
                        class="px-2 py-1 bg-yellow-400 text-white rounded text-xs">Edit</a>
                </div>
            </div>
        @endforeach

    </div>

</div>
