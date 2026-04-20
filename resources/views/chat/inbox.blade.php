<!DOCTYPE html>
<html lang="en">
<head>
    <title>Messages | Dashboard</title>
    @include('layouts.head')
</head>
<body class="bg-[#f8fafc] antialiased text-slate-900 font-sans">
    @include('layouts.header')
    @include('layouts.notifications')
    
    <main class="max-w-3xl mx-auto py-12 px-6">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-slate-900 tracking-tight">
                    Messages
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    You have {{ count($conversations) }} active discussions
                </p>
            </div>
            <a href="{{ route('shop.products.index') }}" 
               class="inline-flex items-center text-sm font-semibold text-blue-600 hover:text-blue-700 transition-colors group">
                <svg class="w-4 h-4 mr-1.5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Shop
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
            <div class="divide-y divide-slate-100">
                @forelse($conversations as $contact)
                    <a href="{{ route('chat.index', $contact->id) }}" 
                       class="flex items-center gap-4 p-5 hover:bg-slate-50 transition-all duration-200 group">
                        
                        <div class="relative flex-shrink-0">
                            <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-slate-100 to-slate-200 border border-slate-200 flex items-center justify-center text-slate-700 font-bold text-lg shadow-sm group-hover:scale-105 transition-transform">
                                {{ strtoupper(substr($contact->name, 0, 1)) }}
                            </div>
                            <span class="absolute -bottom-0.5 -right-0.5 w-3.5 h-3.5 bg-green-500 border-2 border-white rounded-full shadow-sm"></span>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-center mb-1">
                                <h3 class="text-[15px] font-bold text-slate-800 group-hover:text-blue-600 transition-colors">
                                    {{ $contact->name }}
                                </h3>
                                <span class="text-[11px] font-medium text-slate-400 uppercase tracking-wider">2h ago</span>
                            </div>
                            <p class="text-sm text-slate-500 truncate leading-relaxed">
                                Click to resume your conversation...
                            </p>
                        </div>

                        <div class="text-slate-300 group-hover:text-slate-400 group-hover:translate-x-1 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    </a>
                @empty
                    <div class="py-24 text-center">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-slate-50 text-slate-300 mb-4">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-slate-900 font-semibold">No messages yet</h3>
                        <p class="text-slate-500 text-sm mt-1">When you contact sellers, your chats will appear here.</p>
                        <a href="{{ route('shop.products.index') }}" 
                           class="mt-6 inline-flex items-center px-5 py-2.5 text-sm font-medium text-white bg-slate-900 rounded-xl hover:bg-slate-800 transition-colors">
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