

@section('content')
    <div class="max-w-7xl mx-auto p-6">

        <h1 class="text-3xl font-bold mb-6">Products</h1>

        <div id="products-container" class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @include('shop.products.partials.products', ['products' => $products])
        </div>

        @if ($products->hasMorePages())
            <div class="text-center mt-6">
                <button id="load-more-btn" class="px-6 py-2 bg-blue-600 text-white rounded">
                    Show More
                </button>
            </div>
        @endif

    </div>
@endsection

@section('scripts')
    <script>
        let page = 2;

        document.getElementById('load-more-btn')?.addEventListener('click', function() {
            let btn = this;
            btn.disabled = true;
            btn.innerText = 'Loading...';

            fetch(`{{ route('shop.products.index') }}?page=` + page, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(res => res.text())
                .then(data => {
                    const container = document.getElementById('products-container');
                    container.insertAdjacentHTML('beforeend', data);

                    page++;

                    btn.disabled = false;
                    btn.innerText = 'Show More';

                    if (!data.trim()) {
                        btn.style.display = 'none';
                    }
                })
                .catch(err => {
                    console.error(err);
                    btn.disabled = false;
                    btn.innerText = 'Show More';
                });
        });
    </script>
