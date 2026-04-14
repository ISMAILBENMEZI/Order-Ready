<!DOCTYPE html>
<html lang="en">

<head>
    <title>Contact Support - Order Ready</title>
    @include('layouts.head')
</head>

<body class="bg-white text-slate-900 antialiased">

    @include('layouts.header')
    @include('layouts.notifications')

    <main class="py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">

            <div class="max-w-2xl mb-16">
                <h1 class="text-4xl md:text-6xl font-black text-slate-950 tracking-tight mb-6">
                    How can we <span class="text-blue-600">help you?</span>
                </h1>
                <p class="text-lg text-slate-600 leading-relaxed">
                    Have a question about a listing? Need help with your account? Our team is here to ensure your
                    trading experience is seamless.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-16">

                <div class="lg:col-span-4 space-y-8">
                    <div class="p-8 bg-slate-50 rounded-[2.5rem] border border-slate-100">
                        <h3 class="text-xl font-bold mb-6">Quick Contact</h3>

                        <div class="space-y-6">
                            <a href="mailto:orderreadystore@gmail.com" class="flex items-center gap-4 group">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition-all">
                                    <i class="fa-solid fa-envelope text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Email Us</p>
                                    <p class="font-bold text-slate-900">orderreadystore@gmail.com</p>
                                </div>
                            </a>

                            <div class="flex items-center gap-4 group">
                                <div
                                    class="w-12 h-12 rounded-2xl bg-white shadow-sm flex items-center justify-center text-green-600">
                                    <i class="fa-solid fa-clock text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase">Response Time</p>
                                    <p class="font-bold text-slate-900">Within 48 Hours</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="p-8 bg-blue-600 rounded-[2.5rem] text-white shadow-xl shadow-blue-100 relative overflow-hidden">
                        <i
                            class="fa-solid fa-shield-check absolute -bottom-4 -right-4 text-8xl opacity-10 rotate-12"></i>
                        <h3 class="text-xl font-bold mb-3 relative z-10">Report an Issue?</h3>
                        <p class="text-blue-100 text-sm mb-6 relative z-10">If you encountered a suspicious user or a
                            fake listing, please report it immediately via the product page or this form.</p>
                        <button
                            class="bg-white text-blue-600 px-6 py-3 rounded-xl font-bold text-sm hover:bg-blue-50 transition-colors relative z-10">Safety
                            Center</button>
                    </div>
                </div>

                <div class="lg:col-span-8">
                    <form action="#" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf
                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Full Name</label>
                            <input type="text" name="name" placeholder="John Doe"
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all">
                        </div>

                        <div class="space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Email Address</label>
                            <input type="email" name="email" placeholder="john@example.com"
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all">
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Subject</label>
                            <select name="subject"
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all appearance-none">
                                <option>General Inquiry</option>
                                <option>Account Issue</option>
                                <option>Reporting a User/Listing</option>
                                <option>Technical Support</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 space-y-2">
                            <label class="text-sm font-bold text-slate-700 ml-1">Your Message</label>
                            <textarea name="message" rows="6" placeholder="How can we help?"
                                class="w-full px-6 py-4 bg-slate-50 border border-slate-200 rounded-2xl focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all resize-none"></textarea>
                        </div>

                        <div class="md:col-span-2 pt-4">
                            <button type="submit"
                                class="w-full md:w-auto px-12 py-5 bg-slate-950 text-white font-black rounded-2xl hover:bg-slate-800 shadow-xl shadow-slate-200 transition-all active:scale-95">
                                Send Message <i class="fa-solid fa-paper-plane ml-2 text-sm"></i>
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </main>

    @include('layouts.footer')

</body>

</html>
