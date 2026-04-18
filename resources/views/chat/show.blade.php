<!DOCTYPE html>
<html lang="en">

<head>
    <title>Explore Products</title>
    @include('layouts.head')
    <script>
        window.chatConfig = {
            fetchUrl: "{{ route('chat.fetch', $user->id) }}",
            storeUrl: "{{ route('chat.store', $user->id) }}",
            csrfToken: "{{ csrf_token() }}"
        };
    </script>
    @vite(['resources/js/chat/chat.js'])
</head>

<body>
    @include('layouts.header')
    @include('layouts.notifications')
    <main class="max-w-4xl mx-auto my-10 p-6 bg-white border border-slate-200 rounded-3xl shadow-sm">
        <div class="flex items-center gap-4 border-b border-slate-100 pb-4 mb-6">
            <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center font-bold text-slate-600">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div>
                <h2 class="text-lg font-black text-slate-800">{{ $user->name }}</h2>
                <p class="text-[10px] text-emerald-500 font-bold uppercase tracking-widest">Online</p>
            </div>
        </div>
        @if (isset($product))
            <div class="flex items-center gap-3 p-3 mb-4 bg-blue-50 border border-blue-100 rounded-2xl">
                <img src="{{ $product->primaryImage->image_url }}" class="w-12 h-12 object-cover rounded-lg">
                <div class="flex-grow">
                    <h4 class="text-xs font-bold text-slate-800">{{ $product->name }}</h4>
                    <p class="text-[10px] text-blue-600 font-bold">${{ number_format($product->price, 2) }}</p>
                </div>
                <span class="text-[9px] bg-blue-600 text-white px-2 py-1 rounded-md font-black uppercase">Inquiry</span>
            </div>
        @endif

        <div id="chat-box"
            class="h-[400px] overflow-y-auto mb-6 p-4 flex flex-col gap-4 bg-slate-50 rounded-2xl border border-inner border-slate-100">
            @include('partials.messages', ['messages' => $messages])
        </div>

        <form id="chat-form" class="flex gap-3">
            @csrf
            <input type="hidden" name="receiver_id" value="{{ $user->id }}">
            <input type="text" name="message" id="message-input" required value="{{ $initialMessage ?? '' }}"
                class="flex-grow bg-slate-100 border-none rounded-2xl px-5 py-3 text-sm focus:ring-2 focus:ring-blue-500 transition-all"
                placeholder="Write your message here...">

            <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">

            <button type="submit"
                class="bg-blue-600 text-white px-6 py-3 rounded-2xl font-black text-xs uppercase hover:bg-blue-700 transition-all active:scale-95">
                Send <i class="fa-solid fa-paper-plane ml-2"></i>
            </button>
        </form>
    </main>
    @include('layouts.footer')
</body>

</html>
