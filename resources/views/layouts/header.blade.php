<nav class="bg-white shadow-sm border-b border-gray-100 py-4" x-data="{ mobileMenu: false, profileMenu: false }">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex justify-between items-center relative">

            <div class="flex items-center gap-8">
                <a href="/" class="flex items-center gap-3 group">
                    <div
                        class="relative w-12 h-12 bg-blue-600 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-200 rotate-[-5deg] group-hover:rotate-0 transition-transform">
                        <i class="fa-solid fa-box-open text-white text-xl"></i>
                        <div
                            class="absolute -top-1.5 -right-1.5 w-6 h-6 bg-blue-800 rounded-full flex items-center justify-center border-2 border-white text-white">
                            <i class="fa-solid fa-check text-[10px]"></i>
                        </div>
                    </div>
                    <div class="flex flex-col leading-none">
                        <span class="text-xl font-black text-slate-900 tracking-tighter">ORDER</span>
                        <span class="text-[10px] font-bold text-blue-600 tracking-[0.2em] uppercase">Ready</span>
                    </div>
                </a>
            </div>

            <div
                class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 items-center gap-6 text-sm font-semibold text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-blue-600 transition">Home</a>
                <a href="{{ route('about') }}" class="hover:text-blue-600 transition">About</a>
                <a href="{{ route('shop.products.index') }}" class="hover:text-blue-600 transition">Shop</a>
                <a href="{{ route('contact') }}" class="hover:text-blue-600 transition">Contact</a>
            </div>

            <div class="flex items-center gap-4">
                @guest
                    <div class="hidden sm:flex items-center gap-4">
                        <a href="{{ route('auth.login') }}"
                            class="text-sm font-bold text-gray-700 hover:text-blue-600">Login</a>
                        <a href="{{ route('auth.register') }}"
                            class="bg-blue-600 text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-blue-700 shadow-lg shadow-blue-100">Join</a>
                    </div>
                @endguest

                @auth
                    <div class="relative">
                        <button @click="profileMenu = !profileMenu" @click.away="profileMenu = false"
                            class="flex items-center gap-2 focus:outline-none">
                            <div
                                class="w-10 h-10 bg-blue-600 text-white rounded-full flex items-center justify-center font-bold shadow-md uppercase">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 transition-transform"
                                :class="profileMenu ? 'rotate-180' : ''"></i>
                        </button>

                        <div x-show="profileMenu" x-transition
                            class="absolute right-0 mt-3 w-48 bg-white rounded-2xl shadow-2xl border border-gray-100 py-2 z-50">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50"><i
                                    class="fa-regular fa-user mr-2"></i> Profile</a>
                            @if (Auth::user()->role->name === 'seller')
                                <a href="{{ route('seller.store.index') }}"
                                    class="block px-4 py-2 text-sm text-blue-600 font-bold hover:bg-blue-50"><i
                                        class="fa-solid fa-store mr-2"></i> My Store</a>
                            @endif
                            <hr class="my-2 border-gray-100">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50"><i
                                        class="fa-solid fa-arrow-right-from-bracket mr-2"></i> Logout</button>
                            </form>
                        </div>
                    </div>
                @endauth

                <button @click="mobileMenu = !mobileMenu" class="md:hidden p-2 text-gray-600 focus:outline-none">
                    <i class="fa-solid text-2xl" :class="mobileMenu ? 'fa-xmark' : 'fa-bars'"></i>
                </button>
            </div>
        </div>

        <div x-show="mobileMenu" x-transition class="md:hidden mt-4 pb-4 border-t border-gray-100 space-y-2">
            <a href="{{ route('home') }}"
                class="block py-3 px-2 text-gray-700 font-semibold hover:text-blue-600 border-b border-gray-50">Home</a>
            <a href="{{ route('about') }}"
                class="block py-3 px-2 text-gray-700 font-semibold hover:text-blue-600 border-b border-gray-50">About</a>
            <a href="{{ route('shop.products.index') }}"
                class="block py-3 px-2 text-gray-700 font-semibold hover:text-blue-600 border-b border-gray-50">Shop</a>
            <a href="{{ route('contact') }}"
                class="block py-3 px-2 text-gray-700 font-semibold hover:text-blue-600 border-b border-gray-50">Contact</a>

            @guest
                <div class="grid grid-cols-2 gap-4 pt-4">
                    <a href="{{ route('auth.login') }}"
                        class="text-center py-3 text-gray-700 font-bold border rounded-xl">Login</a>
                    <a href="{{ route('auth.register') }}"
                        class="text-center py-3 bg-blue-600 text-white font-bold rounded-xl shadow-md">Join</a>
                </div>
            @endguest
        </div>
    </div>
</nav>
