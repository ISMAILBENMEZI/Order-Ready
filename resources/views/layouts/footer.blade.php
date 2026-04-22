<footer class="bg-slate-900 text-gray-300 pt-16 pb-8 mt-auto" id="footer">
    <div class="max-w-7xl mx-auto px-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">

        <div class="space-y-6">
            <h3 class="text-white text-2xl font-black tracking-tighter flex items-center gap-2">
                Order <span class="text-blue-500">Ready</span>
            </h3>
            <p class="text-sm leading-relaxed text-gray-400">
                The most reliable intermediary platform connecting sellers and buyers in real-time. Fast, secure, and
                ready for your orders.
            </p>
            <div class="flex gap-3">
                <a href="#"
                    class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-blue-600 transition-all text-white"><i
                        class="fa-brands fa-facebook-f text-sm"></i></a>
                <a href="#"
                    class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-blue-400 transition-all text-white"><i
                        class="fa-brands fa-twitter text-sm"></i></a>
                <a href="#"
                    class="w-9 h-9 bg-slate-800 rounded-lg flex items-center justify-center hover:bg-pink-600 transition-all text-white"><i
                        class="fa-brands fa-instagram text-sm"></i></a>
                <a href="#"
                    class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-[#000000] transition-all text-white border border-transparent hover:border-gray-600">
                    <i class="fa-brands fa-tiktok text-sm"></i>
                </a>
            </div>
        </div>

        <div>
            <h4 class="text-white font-bold mb-6 text-lg">Navigation</h4>
            <ul class="space-y-4 text-sm font-medium">
                <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i
                            class="fa-solid fa-chevron-right text-[10px]"></i> Browse Products</a></li>
                <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i
                            class="fa-solid fa-chevron-right text-[10px]"></i> Sell Items</a></li>
                <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i
                            class="fa-solid fa-chevron-right text-[10px]"></i> How it works?</a></li>
                <li><a href="#" class="hover:text-blue-400 transition-colors flex items-center gap-2"><i
                            class="fa-solid fa-chevron-right text-[10px]"></i> Membership</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-white font-bold mb-6 text-lg">Legal Info</h4>
            <ul class="space-y-4 text-sm font-medium">
                <li><a href="{{ route('about') }}#privacy" class="hover:text-blue-400 transition-colors">Privacy
                        Policy</a></li>
                <li><a href="{{ route('about') }}#terms" class="hover:text-blue-400 transition-colors">Terms of
                        Service</a></li>
                <li><a href="{{ route('about') }}#safety" class="hover:text-blue-400 transition-colors">Safety Tips</a>
                </li>
                <li><a href="{{ route('contact') }}" class="hover:text-blue-400 transition-colors">Contact Support</a></li>
            </ul>
        </div>

        <div class="bg-slate-800/50 p-6 rounded-2xl border border-slate-700">
            <h4 class="text-white font-bold mb-4 text-lg">Need Help?</h4>
            <p class="text-xs text-gray-400 mb-4">Our support team is available 24/7 for your questions.</p>
            <a href="{{ route('contact') }}"
                class="block w-full bg-blue-600 hover:bg-blue-700 text-white text-center py-3 rounded-xl font-bold text-sm transition-all shadow-lg shadow-blue-900/20">
                Email Support
            </a>
        </div>
    </div>

    <div
        class="max-w-7xl mx-auto px-4 mt-16 pt-8 border-t border-slate-800 flex flex-col md:flex-row justify-between items-center gap-6">
        <p class="text-xs text-gray-500 font-medium italic">
            &copy; {{ date('Y') }} <span class="text-gray-300 font-bold">Order Ready</span>. All rights reserved.
        </p>
        <div class="flex gap-4 grayscale opacity-50 hover:grayscale-0 hover:opacity-100 transition-all">
            <img src="https://cdn-icons-png.flaticon.com/512/196/196578.png" class="h-5" alt="Visa">
            <img src="https://cdn-icons-png.flaticon.com/512/196/196561.png" class="h-5" alt="Mastercard">
        </div>
    </div>
</footer>
