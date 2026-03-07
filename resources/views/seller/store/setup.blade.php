<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Setup - Order Ready</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
        }

        .step-pill {
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .active-step {
            width: 2.5rem;
            background-color: #2563eb;
        }

        .custom-checkbox:checked+div {
            border-color: #2563eb;
            background-color: #eff6ff;
        }
    </style>

    <head>
        @vite(['resources/js/store/store-setup.js'])
    </head>
</head>

<body class="min-h-screen flex flex-col items-center py-12 px-4">

    <div class="mb-10 text-center">
        <h2 class="text-xl font-black tracking-tighter text-slate-900">Order<span class="text-blue-600">Ready.</span></h2>
    </div>

    <div
        class="w-full max-w-3xl bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[3rem] border border-slate-100 overflow-hidden">

        <div class="px-10 pt-12 pb-8 border-b border-slate-50">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 id="step-title" class="text-2xl font-black text-slate-900 tracking-tight transition-all">Store
                        Information</h1>
                    <p class="text-slate-400 text-sm font-medium mt-1">Configure your professional workspace</p>
                </div>
                <div class="flex gap-1.5">
                    <div id="dot-1" class="h-2 w-8 rounded-full bg-blue-600 transition-all duration-500"></div>
                    <div id="dot-2" class="h-2 w-2 rounded-full bg-slate-100 transition-all duration-500"></div>
                    <div id="dot-3" class="h-2 w-2 rounded-full bg-slate-100 transition-all duration-500"></div>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="mb-6 rounded-xl bg-red-50 border border-red-200 p-4">
                <h3 class="text-red-700 font-bold mb-2">Please fix the following errors:</h3>
                <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.store.store') }}" method="POST" enctype="multipart/form-data"
            id="store-setup-form" class="p-10">
            @csrf

            <div class="step space-y-6" id="step-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Store
                            Name</label>
                        <input type="text" name="name"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700"
                            placeholder="e.g. Blue Bottle Coffee">
                    </div>

                    <div class="md:col-span-2">
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700"
                            placeholder="Tell us about your story..."></textarea>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Location</label>
                        <input type="text" name="location"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700"
                            placeholder="Casablanca, Morocco">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Contact
                            Email</label>
                        <input type="email" name="contact_email"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700"
                            placeholder="example@gmail.com">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Contact
                            Phone</label>
                        <input type="text" name="contact_phone"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700"
                            placeholder="+212 ...">
                    </div>
                </div>
            </div>

            <div class="step hidden space-y-6" id="step-2">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach ($categories as $category)
                        <label class="relative cursor-pointer group">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                class="custom-checkbox sr-only">
                            <div
                                class="p-4 border-2 border-slate-50 rounded-2xl bg-slate-50/50 group-hover:border-blue-100 transition-all text-center">
                                <span class="block text-sm font-bold text-slate-700">{{ $category->name }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="step hidden space-y-8" id="step-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Store
                            Logo</label>
                        <div
                            class="relative h-40 w-full border-2 border-dashed border-slate-200 rounded-[2rem] flex flex-col items-center justify-center bg-slate-50 group-hover:bg-white group-hover:border-blue-200 transition-all cursor-pointer">
                            <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Upload Logo</span>
                            <input type="file" name="logo" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                    </div>

                    <div class="group">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-4 ml-1">Cover
                            Banner</label>
                        <div
                            class="relative h-40 w-full border-2 border-dashed border-slate-200 rounded-[2rem] flex flex-col items-center justify-center bg-slate-50 group-hover:bg-white group-hover:border-blue-200 transition-all cursor-pointer">
                            <svg class="w-8 h-8 text-slate-300 mb-2" fill="none" stroke="currentColor"
                                stroke-width="2" viewBox="0 0 24 24">
                                <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                            </svg>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-tighter">Upload
                                Banner</span>
                            <input type="file" name="banner" class="absolute inset-0 opacity-0 cursor-pointer">
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-between mt-12 pt-8 border-t border-slate-50">
                <button type="button" id="prev-btn"
                    class="hidden text-sm font-black text-slate-400 uppercase tracking-widest hover:text-slate-900 transition-colors">
                    ← Back
                </button>

                <div class="flex gap-4 ml-auto">
                    <button type="button" id="next-btn"
                        class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-sm font-black hover:bg-blue-600 shadow-xl shadow-slate-200 transition-all active:scale-95">
                        Next Step
                    </button>
                    <button type="submit" id="submit-btn"
                        class="hidden px-8 py-4 bg-emerald-500 text-white rounded-2xl text-sm font-black hover:bg-emerald-600 shadow-xl shadow-emerald-100 transition-all active:scale-95">
                        Launch Store
                    </button>
                </div>
            </div>
        </form>
    </div>

    <p class="mt-8 text-[10px] font-black text-slate-300 uppercase tracking-[0.4em]">Order Ready Ecosystem &copy; 2026
    </p>
</body>

</html>
