@foreach ($products as $product)
    <div class="border p-4 rounded shadow hover:shadow-lg transition duration-200">
        <img src="{{ $product->primaryImage->image_url ?? 'placeholder.jpg' }}" alt="{{ $product->name }}"
            class="w-full h-48 object-cover mb-2 rounded">
        <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
        <p class="text-blue-600 font-bold">${{ $product->price }}</p>
        <p class="text-sm text-gray-500">Status: {{ ucfirst($product->status) }}</p>
        <p class="text-sm text-gray-500">Store: {{ $product->store->name }}</p>
        <p class="text-sm text-gray-500">Category: {{ $product->category->name }}</p>

        <div class="mt-2 flex flex-wrap gap-2">
            <button class="px-2 py-1 bg-yellow-400 text-white rounded text-xs">⭐ Rating</button>
            <button class="px-2 py-1 bg-green-500 text-white rounded text-xs">💬 Message</button>
            <button class="px-2 py-1 bg-red-500 text-white rounded text-xs">🚩 Report</button>
            <button class="px-2 py-1 bg-blue-500 text-white rounded text-xs">❤️ Interest</button>
            <button class="px-2 py-1 bg-gray-600 text-white rounded text-xs">🏪 Store</button>
        </div>
    </div>
@endforeach
