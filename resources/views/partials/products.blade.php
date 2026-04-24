@foreach ($products as $product)
    @php
        $primaryImage = $product->images->where('is_primary', true)->first() ?? $product->images->first();
    @endphp

    <div x-data="{ open: false }"
        class="group bg-white rounded-2xl border border-slate-200 flex flex-col shadow-sm hover:-translate-y-1.5 hover:shadow-xl hover:shadow-blue-500/10 hover:border-blue-200 transition-all duration-300 relative"
        :class="open ? 'z-50' : 'z-10'">

        <div
            class="relative h-52 bg-gradient-to-br from-slate-50 to-blue-50/40 flex items-center justify-center rounded-t-2xl">

            <a href="{{ route('shop.products.show', $product) }}"
                class="flex items-center justify-center w-full h-full overflow-hidden rounded-t-2xl">
                <img src="{{ Storage::url($product->primaryImage->image_url)}}" alt="{{ $product->name }}" loading="lazy"
                    class="max-h-44 max-w-[85%] object-contain transition-transform duration-500 group-hover:scale-105">
            </a>

            @if ($product->is_negotiable)
                <span
                    class="absolute bottom-3 left-3 bg-blue-600 text-white text-[10px] font-bold tracking-wide px-2.5 py-1 rounded-full">
                    Negotiable
                </span>
            @endif

            <div class="absolute top-3 right-3">
                <button @click.prevent.stop="open = !open" @click.outside="open = false"
                    class="w-8 h-8 flex items-center justify-center bg-white/90 backdrop-blur-sm border border-slate-200 rounded-full text-slate-500 hover:border-blue-400 hover:text-blue-600 hover:bg-white transition-all duration-150">
                    <i class="fa-solid fa-ellipsis-vertical text-[13px]"></i>
                </button>

                <div x-show="open" x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    style="display: none;"
                    class="absolute top-10 right-0 w-40 bg-white border border-slate-200 rounded-2xl shadow-xl z-[100] overflow-hidden p-1.5">

                    <form method="POST" action="{{ route('products.favorite', $product) }}">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold rounded-xl transition-all duration-200 
                                                {{ Auth::user()?->favorites?->contains($product)
                                                    ? 'bg-indigo-50 text-indigo-700'
                                                    : 'text-slate-600 hover:bg-slate-50' }}">

                            @if (Auth::user()?->favorites?->contains($product->id))
                                <i class="fa-solid fa-bookmark text-indigo-600 w-3.5 text-center"></i>
                                <span>Favorited</span>
                            @else
                                <i class="fa-regular fa-bookmark text-indigo-400 w-3.5 text-center"></i>
                                <span>Add to Favorite</span>
                            @endif
                        </button>
                    </form>
                    <a href="{{ route('shop.products.show', $product) }}#rating"
                        class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                        <i class="fa-solid fa-star text-amber-400 w-3.5 text-center"></i> Rating
                    </a>
                    <a href="{{ route('shop.products.show', $product->slug) }}?report=1"
                        class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                        <i class="fa-solid fa-flag text-red-400 w-3.5 text-center"></i> Report
                    </a>
                    @if (auth()->check() && auth()->user()->hasInterestedIn($product))
                        <div
                            class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-pink-600 bg-pink-50 rounded-xl">
                            <i class="fa-solid fa-heart text-pink-500 w-3.5 text-center"></i>
                            Interested
                        </div>
                    @else
                        <form method="POST" action="{{ route('product.interest', $product) }}">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 rounded-xl">
                                <i class="fa-regular fa-heart text-slate-400 w-3.5 text-center"></i>
                                Interest
                            </button>
                        </form>
                    @endif

                    <a href="{{ $product->store ? route('shop.stores.show', $product->store) : '#' }}"
                        class="flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-colors">
                        <i class="fa-solid fa-shop text-blue-400 w-3.5 text-center"></i> Store
                    </a>

                    <button type="button" x-data="{ copied: false }"
                        @click.stop="navigator.clipboard?.writeText('{{ route('shop.products.show', $product->slug) }}'); copied = true; setTimeout(() => copied = false, 3000)"
                        class="w-full flex items-center gap-2.5 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50 rounded-xl transition-all duration-200 active:scale-95">

                        <i class="fa-solid fa-share-nodes text-emerald-400 w-3.5 text-center" x-show="!copied"></i>
                        <i class="fa-solid fa-check text-emerald-500 w-3.5 text-center" x-show="copied"
                            style="display:none;"></i>
                        <span x-text="copied ? 'Copied!' : 'Share'">Share</span>
                    </button>
                </div>
            </div>
        </div>

        <div class="p-5 flex flex-col flex-grow">
            <a href="{{ route('shop.products.show', $product) }}"
                class="block text-base font-bold text-slate-900 truncate mb-1.5 group-hover:text-blue-600 transition-colors duration-150">
                {{ $product->name }}
            </a>

            <p class="text-[13px] text-slate-400 font-normal leading-relaxed line-clamp-2 flex-grow mb-4">
                {{ $product->description }}
            </p>

            <div class="flex items-center gap-2 mb-4">
                @if ($product->discount_price)
                    <span class="text-xl font-extrabold text-blue-600 tracking-tight">
                        ${{ number_format($product->discount_price, 2) }}
                    </span>
                    <span class="text-sm font-semibold text-slate-300 line-through">
                        ${{ number_format($product->price, 2) }}
                    </span>
                @else
                    <span class="text-xl font-extrabold text-slate-900 tracking-tight">
                        ${{ number_format($product->price, 2) }}
                    </span>
                @endif
            </div>

            <div class="flex items-center gap-2 mt-auto">
                <a href="{{ route('chat.index', ['user' => $product->store->seller_id, 'product' => $product->id]) }}"
                    class="flex-1 flex items-center justify-center gap-2 h-11 bg-slate-900 text-white text-xs font-bold rounded-xl hover:bg-blue-600 transition-colors duration-200 active:scale-95">
                    <i class="fa-solid fa-paper-plane text-[11px]"></i> Message
                </a>
                @php
                    $isInterested = auth()->check() && auth()->user()->hasInterestedIn($product);
                @endphp

                @if (!$isInterested)
                    <form method="POST" action="{{ route('product.interest', $product) }}">
                        @csrf
                        <button type="submit"
                            class="w-11 h-11 flex items-center justify-center border border-slate-200 text-slate-300 rounded-xl hover:bg-pink-50 hover:text-pink-500 hover:border-pink-200 transition-all duration-200 active:scale-90">
                            <i class="fa-solid fa-heart text-[14px]"></i>
                        </button>
                    </form>
                @else
                    <div title="Already interested"
                        class="w-11 h-11 flex items-center justify-center border border-pink-200 bg-pink-50 text-pink-500 rounded-xl cursor-default shadow-sm">
                        <i class="fa-solid fa-heart text-[14px]"></i>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endforeach
