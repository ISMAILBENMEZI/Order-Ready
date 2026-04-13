<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Store - Order Ready</title>
    @include('layouts.head')

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
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
        <h2
            class="text-xl font-black tracking-tighter text-slate-900 underline decoration-blue-500 decoration-4 underline-offset-4">
            Edit Your <span class="text-blue-600">Store.</span>
        </h2>
    </div>

    <div
        class="w-full max-w-3xl bg-white shadow-[0_20px_50px_rgba(0,0,0,0.05)] rounded-[3rem] border border-slate-100 overflow-hidden">

        <div class="px-10 pt-12 pb-8 border-b border-slate-50">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h1 id="step-title" class="text-2xl font-black text-slate-900 tracking-tight transition-all">
                        Update Information
                    </h1>
                    <p class="text-slate-400 text-sm font-medium mt-1">Keep your workspace professional and up-to-date
                    </p>
                </div>
                <div class="flex gap-1.5">
                    <div id="dot-1" class="h-2 w-8 rounded-full bg-blue-600 transition-all duration-500"></div>
                    <div id="dot-2" class="h-2 w-2 rounded-full bg-slate-100 transition-all duration-500"></div>
                    <div id="dot-3" class="h-2 w-2 rounded-full bg-slate-100 transition-all duration-500"></div>
                </div>
            </div>
        </div>

        <form action="{{ route('seller.store.update') }}" method="POST" enctype="multipart/form-data"
            id="store-setup-form" class="p-10" data-old-step="1">
            @csrf
            @method('PUT')

            <div class="step space-y-6" id="step-1">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Store
                            Name</label>
                        <input type="text" name="name" value="{{ old('name', $store->name) }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700">
                    </div>

                    <div class="md:col-span-2">
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Description</label>
                        <textarea name="description" rows="3"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700">{{ old('description', $store->description) }}</textarea>
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Location</label>
                        <input type="text" name="location" value="{{ old('location', $store->location) }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Contact
                            Email</label>
                        <input type="email" name="contact_email"
                            value="{{ old('contact_email', $store->contact_email) }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Contact
                            Phone</label>
                        <input type="text" name="contact_phone"
                            value="{{ old('contact_phone', $store->contact_phone) }}"
                            class="w-full px-5 py-4 bg-slate-50 border border-slate-100 rounded-2xl focus:bg-white focus:border-blue-500 transition-all outline-none font-semibold text-slate-700">
                    </div>
                </div>
            </div>

            <div class="step hidden space-y-6" id="step-2">
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    @foreach ($categories as $category)
                        <label class="relative cursor-pointer group">
                            <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                class="custom-checkbox sr-only"
                                {{ in_array($category->id, old('categories', $selectedCategories)) ? 'checked' : '' }}>
                            <div
                                class="p-4 border-2 border-slate-50 rounded-2xl bg-slate-50/50 group-hover:border-blue-100 transition-all text-center">
                                <span class="block text-sm font-bold text-slate-700">{{ $category->name }}</span>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="step hidden space-y-10" id="step-3">
                <div class="flex flex-col gap-10">

                    <div class="group w-full md:w-1/3 mx-auto text-center">
                        <label class="block text-xs font-black text-slate-400 uppercase tracking-widest mb-4">Store
                            Logo</label>
                        <div
                            class="relative h-44 w-44 mx-auto border-2 border-dashed border-slate-200 rounded-full flex flex-col items-center justify-center bg-slate-50 group-hover:bg-white group-hover:border-blue-200 transition-all cursor-pointer overflow-hidden">

                            <img id="logo-preview"
                                src="{{ $store->logo_url ? asset('storage/' . $store->logo_url) : '' }}"
                                class="{{ $store->logo_url ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover z-10"
                                alt="Logo Preview">

                            <div id="logo-placeholder"
                                class="{{ $store->logo_url ? 'hidden' : '' }} flex flex-col items-center justify-center p-4">
                                <i class="fa-solid fa-camera text-slate-300 text-2xl mb-2"></i>
                                <span class="text-[9px] font-black text-slate-400 uppercase">Change Logo</span>
                            </div>

                            <input type="file" name="logo" id="logo-input"
                                class="absolute inset-0 opacity-0 cursor-pointer z-20">
                        </div>
                    </div>

                    <div class="group w-full">
                        <div class="flex justify-between items-end mb-4 px-1">
                            <label class="block text-xs font-black text-slate-400 uppercase tracking-widest">Store Cover
                                Banner</label>
                        </div>

                        <div class="relative w-full border-2 border-dashed border-slate-200 rounded-[2rem] bg-slate-50 group-hover:bg-white group-hover:border-blue-200 transition-all cursor-pointer overflow-hidden"
                            style="aspect-ratio: 1500 / 350;">

                            <img id="banner-preview"
                                src="{{ $store->banner_url ? asset('storage/' . $store->banner_url) : '' }}"
                                class="{{ $store->banner_url ? '' : 'hidden' }} absolute inset-0 w-full h-full object-cover z-10"
                                alt="Banner Preview">

                            <div id="banner-placeholder"
                                class="{{ $store->banner_url ? 'hidden' : '' }} absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-xs font-black text-slate-500 uppercase tracking-widest">Update
                                    Banner</span>
                            </div>

                            <input type="file" name="banner" id="banner-input"
                                class="absolute inset-0 opacity-0 cursor-pointer z-20">
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
                        class="px-8 py-4 bg-slate-900 text-white rounded-2xl text-sm font-black hover:bg-blue-600 shadow-xl transition-all active:scale-95">
                        Next Step
                    </button>
                    <button type="submit" id="submit-btn"
                        class="hidden px-8 py-4 bg-blue-600 text-white rounded-2xl text-sm font-black hover:bg-blue-700 shadow-xl transition-all active:scale-95">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</body>

</html>
