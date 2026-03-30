<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Order Ready - Your Direct Trading Bridge</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .hero-gradient {
            background: radial-gradient(circle at 10% 20%, rgb(239, 246, 255) 0%, rgb(255, 255, 255) 100%);
        }

        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05);
        }
    </style>
</head>

<body class="bg-white text-slate-900 antialiased">

    @include('layouts.header')
    @include('layouts.notifications')

    <main>
        <section class="hero-gradient pt-12 pb-20 md:pt-20 md:pb-32 border-b border-slate-100">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                    <div class="space-y-8">
                        <div
                            class="inline-flex items-center space-x-2 bg-blue-50 border border-blue-100 px-3 py-1 rounded-full">
                            <span class="w-2 h-2 bg-blue-600 rounded-full animate-pulse"></span>
                            <span class="text-xs font-bold text-blue-700 uppercase tracking-wider">Direct
                                Marketplace</span>
                        </div>

                        <h1 class="text-5xl md:text-6xl font-black tracking-tight text-slate-950 leading-[1.1]">
                            Sell Faster. <br>
                            <span class="text-blue-600">Connect Better.</span>
                        </h1>

                        <p class="text-lg text-slate-600 leading-relaxed max-w-lg">
                            The ultimate P2P bridge where sellers list and buyers discover. No middleman, no transaction
                            fees. Just direct communication and local trading.
                        </p>

                        <div class="flex flex-wrap gap-4">
                            <a href="#discover"
                                class="bg-slate-950 text-white px-8 py-4 rounded-2xl font-bold hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 active:scale-95">
                                Explore Products
                            </a>
                            <a href="{{ route('auth.register') }}"
                                class="bg-white text-slate-900 border border-slate-200 px-8 py-4 rounded-2xl font-bold hover:bg-slate-50 transition-all active:scale-95">
                                Start Selling
                            </a>
                        </div>
                    </div>

                    {{-- تم تغيير الصورة هنا لتكون تعبيرية عن التواصل والبيع والشراء --}}
                    <div class="relative group">
                        <div
                            class="absolute -inset-1 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[2.5rem] blur opacity-20 group-hover:opacity-30 transition duration-1000">
                        </div>
                        <div
                            class="relative bg-white rounded-[2.5rem] overflow-hidden shadow-2xl border border-slate-100">
                            <img src="https://images.unsplash.com/photo-1556742044-3c52d6e88c62?q=80&w=1200&auto=format&fit=crop"
                                alt="Smart Trading"
                                class="w-full h-full object-cover grayscale-[20%] group-hover:grayscale-0 transition-all duration-700">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-24" id="discover">
            <div class="max-w-7xl mx-auto px-6 lg:px-8">
                <div class="mb-16">
                    <h2 class="text-3xl font-black text-slate-950">How it works</h2>
                    <div class="h-1.5 w-20 bg-blue-600 mt-4 rounded-full"></div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
                    <div class="feature-card p-10 bg-slate-50 rounded-[2.5rem] transition-all duration-300">
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">List Instantly</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Upload your product details and images. Once approved by our team, your listing goes live to
                            thousands of potential buyers.
                        </p>
                    </div>

                    <div
                        class="feature-card p-10 bg-slate-50 rounded-[2.5rem] transition-all duration-300 border-2 border-blue-100">
                        <div
                            class="w-14 h-14 bg-blue-600 rounded-2xl shadow-lg shadow-blue-200 flex items-center justify-center mb-6">
                            <i class="fa-solid fa-comments text-2xl text-white"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Direct Chat</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            Buyers contact you directly through our secure internal messaging system to negotiate and
                            finalize details.
                        </p>
                    </div>

                    <div class="feature-card p-10 bg-slate-50 rounded-[2.5rem] transition-all duration-300">
                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center mb-6">
                            <i class="fa-solid fa-shield-halved text-2xl text-blue-600"></i>
                        </div>
                        <h3 class="text-xl font-bold mb-3">Safe Trading</h3>
                        <p class="text-slate-500 text-sm leading-relaxed">
                            We don't handle payments. This gives you the freedom to choose your preferred delivery and
                            payment methods safely.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="py-20 bg-slate-950 text-white overflow-hidden relative">
            <div
                class="absolute top-0 right-0 -translate-y-1/2 translate-x-1/2 w-96 h-96 bg-blue-600/20 rounded-full blur-3xl">
            </div>

            <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
                <div
                    class="bg-blue-600 rounded-[3rem] p-8 md:p-16 flex flex-col md:flex-row items-center justify-between gap-10">
                    <div class="max-w-xl">
                        <h2 class="text-3xl md:text-4xl font-black mb-6">Ready to clear your inventory?</h2>
                        <p class="text-blue-100 text-lg">Join a community of verified sellers. No complex setups, just
                            pure trading.</p>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('auth.register') }}"
                            class="inline-block bg-white text-blue-600 px-10 py-5 rounded-2xl font-black text-lg hover:bg-slate-50 transition-all active:scale-95 shadow-2xl">
                            Get Started Now
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @include('layouts.footer')

</body>

</html>
