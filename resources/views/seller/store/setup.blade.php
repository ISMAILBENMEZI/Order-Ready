<!DOCTYPE html>
<html lang="en">

<head>
    <title>Store Setup - Order Ready</title>
    @include('layouts.head')

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

    @vite(['resources/js/store/store-setup.js', 'resources/js/globalUtils/notifications.js'])
</head>

<body class="min-h-screen flex flex-col items-center py-12 px-4">
    @include('layouts.notifications')

    <div class="mb-10 text-center">
        <h2 class="text-xl font-black tracking-tighter text-slate-900">Order<span class="text-blue-600">Ready.</span>
        </h2>
    </div>

    <div
        class="w-full max-w-3xl bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[3rem] border border-slate-100 overflow-hidden">

        <div class="px-10 pt-12 pb-8 border-b border-slate-50">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 id="step-title" class="text-2xl font-black text-slate-900 tracking-tight transition-all">
                        Store Information
                    </h1>
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
            <div class="mx-10 mt-8 rounded-2xl bg-red-50 border border-red-200 p-5">
                <h3 class="text-red-700 font-bold mb-2">Please fix the following errors:</h3>
                <ul class="list-disc list-inside text-red-600 text-sm space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('seller.store.store') }}" method="POST" enctype="multipart/form-data"
            id="store-setup-form" class="p-10"
            data-old-step="@if ($errors->has('categories') || $errors->has('categories.*')) 2 @elseif($errors->has('logo') || $errors->has('banner')) 3 @else 1 @endif">
            @csrf

            <div class="step space-y-6" id="step-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Store
                            Name</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700"
                            placeholder="e.g. Blue Bottle Coffee">
                        @error('name')
                            <p class="text-red-500 text-xs font-bold mt-2 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700"
                            placeholder="Tell us about your story...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs font-bold mt-2 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700"
                            placeholder="Casablanca, Morocco">
                        @error('location')
                            <p class="text-red-500 text-xs font-bold mt-2 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Contact
                            Email</label>
                        <input type="email" name="contact_email" value="{{ old('contact_email') }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700"
                            placeholder="example@gmail.com">
                        @error('contact_email')
                            <p class="text-red-500 text-xs font-bold mt-2 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Contact
                            Phone</label>
                        <input type="text" name="contact_phone" value="{{ old('contact_phone') }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700"
                            placeholder="+212 ...">
                        @error('contact_phone')
                            <p class="text-red-500 text-xs font-bold mt-2 px-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="step hidden space-y-6" id="step-2">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach ($categories as $category)
                        <label class="relative cursor-pointer group">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                class="custom-checkbox sr-only"
                                {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                            <div
                                class="p-4 border-2 border-slate-50 rounded-2xl bg-slate-50/50 group-hover:border-blue-100 transition-all text-center">
                                <span class="block text-sm font-bold text-slate-700">{{ $category->name }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
                @error('categories')
                    <p class="text-red-500 text-xs font-bold mt-2 px-1">{{ $message }}</p>
                @enderror
                @error('categories.*')
                    <p class="text-red-500 text-xs font-bold mt-2 px-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="step hidden space-y-10" id="step-3">
                <div class="flex flex-col gap-10">

                    <div class="group w-full md:w-1/3 mx-auto">
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-4 text-center">Store
                            Logo</label>
                        <div
                            class="relative h-44 w-44 mx-auto border-2 border-dashed border-slate-200 rounded-full flex flex-col items-center justify-center bg-slate-50 group-hover:bg-white group-hover:border-blue-200 transition-all cursor-pointer overflow-hidden">

                            <img id="logo-preview" class="hidden absolute inset-0 w-full h-full object-cover z-10"
                                alt="Logo Preview">

                            <div id="logo-placeholder"
                                class="flex flex-col items-center justify-center p-4 text-center">
                                <svg class="w-6 h-6 text-slate-300 mb-1" fill="none" stroke="currentColor"
                                    stroke-width="2" viewBox="0 0 24 24">
                                    <path
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                <span class="text-[9px] font-black text-slate-400 uppercase tracking-tighter">Upload
                                    Logo</span>
                            </div>

                            <input type="file" name="logo" id="logo-input"
                                class="absolute inset-0 opacity-0 cursor-pointer z-20">
                        </div>
                        @error('logo')
                            <p class="text-red-500 text-[10px] font-bold mt-2 text-center uppercase">{{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="group w-full">
                        <div class="flex justify-between items-end mb-4 px-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Store
                                Cover Banner</label>
                            <span class="text-[10px] font-bold text-blue-600 uppercase tracking-widest">Recommended:
                                1500x350px</span>
                        </div>

                        <div class="relative w-full border-2 border-dashed border-slate-200 rounded-[2rem] bg-slate-50 group-hover:bg-white group-hover:border-blue-200 transition-all cursor-pointer overflow-hidden"
                            style="aspect-ratio: 1500 / 350;">

                            <img id="banner-preview" class="hidden absolute inset-0 w-full h-full object-cover z-10"
                                alt="Banner Preview">

                            <div id="banner-placeholder"
                                class="absolute inset-0 flex flex-col items-center justify-center">
                                <div class="flex items-center gap-3">
                                    <svg class="w-8 h-8 text-slate-300" fill="none" stroke="currentColor"
                                        stroke-width="2" viewBox="0 0 24 24">
                                        <path d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    <div class="text-left">
                                        <span
                                            class="block text-xs font-black text-slate-500 uppercase tracking-widest">Upload
                                            Panoramic Banner</span>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">
                                            Maximum file size: 4MB</p>
                                    </div>
                                </div>
                            </div>

                            <input type="file" name="banner" id="banner-input"
                                class="absolute inset-0 opacity-0 cursor-pointer z-20">
                        </div>

                        @error('banner')
                            <p class="text-red-500 text-xs font-bold mt-3 px-1">{{ $message }}</p>
                        @enderror
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
