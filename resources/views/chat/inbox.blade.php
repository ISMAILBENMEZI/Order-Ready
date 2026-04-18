<!DOCTYPE html>
<html lang="en">

<head>
    <title>Explore Products</title>
    @include('layouts.head')
    @vite(['resources/js/shop/products-loader.js'])

</head>

<body>
    @include('layouts.header')
    @include('layouts.notifications')
    <main class="max-w-4xl mx-auto my-10 px-6">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Messages</h1>
            <p class="text-slate-400 text-sm font-medium">Manage your conversations with buyers and sellers.</p>
        </div>

        <div class="bg-white border border-slate-200 rounded-[32px] overflow-hidden shadow-sm">
            <div class="divide-y divide-slate-50">
                @forelse($conversations as $contact)
                    <a href="{{ route('chat.index', $contact->id) }}"
                        class="flex items-center gap-4 p-5 hover:bg-slate-50 transition-all group">

                        <div class="relative flex-shrink-0">
                            <div
                                class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 font-black text-xl border border-blue-100 group-hover:scale-105 transition-transform">
                                {{ substr($contact->name, 0, 1) }}
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-500 border-4 border-white rounded-full">
                            </div>
                        </div>

                        <div class="flex-grow min-w-0">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="font-extrabold text-slate-800 truncate">{{ $contact->name }}</h3>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">
                                    Active Now
                                </span>
                            </div>
                            <p class="text-sm text-slate-500 truncate group-hover:text-slate-900 transition-colors">
                                Click to view your conversation history...
                            </p>
                        </div>

                        <div class="text-slate-300 group-hover:text-blue-600 transition-colors pl-4">
                            <i class="fa-solid fa-chevron-right text-sm"></i>
                        </div>
                    </a>
                @empty
                    <div class="py-20 text-center">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-comments text-slate-200 text-3xl"></i>
                        </div>
                        <p class="text-slate-400 font-bold uppercase tracking-widest text-xs">No conversations yet</p>
                        <a href="{{ route('shop.products.index') }}"
                            class="mt-4 inline-block text-blue-600 font-black text-xs uppercase hover:underline">
                            Start Shopping
                        </a>
                    </div>
                @endforelse
            </div>
        </div>
    </main>
    @include('layouts.footer')
</body>

</html>
