<!DOCTYPE html>
<html lang="en">

<head>
    <title>Chat with {{ $user->name }}</title>
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

<body class="bg-[#f4f7f9] antialiased">
    @include('layouts.header')
    @include('layouts.notifications')

    <main class="max-w-5xl mx-auto my-12 px-4 flex flex-col md:flex-row gap-6 items-start">

        @if (isset($product))
            <div class="w-full md:w-72 flex-shrink-0 space-y-4 sticky top-6">
                <div class="bg-white p-5 rounded-3xl border border-slate-200 shadow-sm flex items-center gap-3">
                    <div
                        class="w-10 h-10 bg-slate-900 rounded-full flex items-center justify-center text-white font-bold text-xs">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <h2 class="text-sm font-bold text-slate-800 truncate">{{ $user->name }}</h2>
                        <div class="flex items-center gap-1.5">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span>
                            <span class="text-[10px] text-slate-400 font-bold uppercase">Online</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm overflow-hidden">
                    <img src="{{ $product->primaryImage->image_url }}" class="w-full h-40 object-cover">
                    <div class="p-4">
                        <span
                            class="text-[9px] bg-blue-50 text-blue-600 px-2 py-0.5 rounded font-black uppercase mb-2 inline-block">Item
                            Inquiry</span>
                        <h4 class="text-sm font-bold text-slate-800 leading-tight mb-1">{{ $product->name }}</h4>
                        <p class="text-lg font-black text-blue-600">${{ number_format($product->price, 2) }}</p>
                    </div>
                </div>
            </div>
        @endif

        <div
            class="flex-grow bg-white border border-slate-200 rounded-[2.5rem] shadow-xl shadow-slate-200/50 flex flex-col h-[700px] overflow-hidden">

            <div class="px-8 py-5 border-b border-slate-100 flex justify-between items-center bg-white">
                <h3 class="font-black text-slate-800 uppercase tracking-tighter text-sm">Message History</h3>
                <span class="text-[10px] bg-slate-100 px-3 py-1 rounded-full font-bold text-slate-500">Encryption
                    Active</span>
            </div>

            <div id="chat-box" class="flex-grow overflow-y-auto p-8 flex flex-col gap-5 bg-slate-50/30">
                @include('partials.messages', ['messages' => $messages])
            </div>

            <div class="p-6 bg-white border-t border-slate-100">
                <form id="chat-form" class="flex gap-3">
                    @csrf
                    <input type="hidden" name="receiver_id" value="{{ $user->id }}">
                    <input type="hidden" name="product_id" value="{{ $product->id ?? '' }}">

                    <input type="text" name="message" id="message-input" required
                        value="{{ $initialMessage ?? '' }}"
                        class="flex-grow bg-slate-100 border-none rounded-2xl px-6 py-4 text-sm focus:ring-2 focus:ring-blue-500 transition-all outline-none"
                        placeholder="Write something to {{ $user->name }}...">

                    <button type="submit"
                        class="bg-blue-600 text-white px-8 rounded-2xl font-black text-[11px] uppercase tracking-widest hover:bg-blue-700 transition-all active:scale-95 shadow-lg shadow-blue-100">
                        Send <i class="fa-solid fa-paper-plane ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>
