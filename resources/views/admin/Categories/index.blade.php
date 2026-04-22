<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <title>Manage Categories</title>
    @include('layouts.head')
    @vite(['resources/js/admin/categories.js'])
</head>

<body class="bg-[#f8fafc] min-h-screen flex flex-col font-sans antialiased text-slate-900">
    @include('layouts.header')
    @include('layouts.notifications')

    <main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 w-full flex-grow">

        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10">
            <div class="flex-grow">
                <div class="flex items-center gap-4 mb-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center justify-center w-9 h-9 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-indigo-600 hover:border-indigo-200 hover:shadow-md transition-all active:scale-90">
                        <i class="fa-solid fa-arrow-left text-sm"></i>
                    </a>
                    <span class="text-xs font-bold uppercase tracking-widest text-slate-400">Back to Dashboard</span>
                </div>

                <div class="space-y-1 text-center sm:text-left">
                    <h1 class="text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">
                        Categories
                    </h1>
                    <p class="text-slate-500 text-sm sm:text-base max-w-xl">
                        Manage your product organization, taxonomy, and display settings.
                    </p>
                </div>

                <div class="relative mt-8 max-w-md group mx-auto sm:mx-0">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i
                            class="fa-solid fa-magnifying-glass text-slate-400 group-focus-within:text-indigo-500 transition-colors"></i>
                    </div>
                    <input type="text" id="table-search" placeholder="Search categories..."
                        class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-[1.25rem] text-sm outline-none focus:ring-4 focus:ring-indigo-500/10 focus:border-indigo-500 transition-all shadow-sm group-hover:border-slate-300"
                        onkeyup="filterTable()">

                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none hidden sm:flex">
                        <kbd
                            class="px-2 py-1 text-[10px] font-semibold text-slate-400 bg-slate-50 border border-slate-200 rounded-lg">/</kbd>
                    </div>
                </div>
            </div>

            <button onclick="toggleModal('category-modal')"
                class="inline-flex items-center justify-center px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-bold rounded-2xl shadow-lg shadow-indigo-100 transition-all active:scale-95 whitespace-nowrap h-fit">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                Add Category
            </button>
        </div>

        <div class="bg-white border border-slate-200 rounded-[2rem] shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full border-collapse min-w-[600px]" id="categories-table">
                    <thead>
                        <tr class="bg-slate-50/50 border-b border-slate-100">
                            <th class="px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">
                                Category</th>
                            <th
                                class="hidden md:table-cell px-6 py-4 text-left text-xs font-bold text-slate-400 uppercase tracking-widest">
                                Description</th>
                            <th
                                class="px-6 py-4 text-center text-xs font-bold text-slate-400 uppercase tracking-widest">
                                Status</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-slate-400 uppercase tracking-widest">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($categories as $category)
                            <tr class="group hover:bg-slate-50/80 transition-all">
                                <td class="px-6 py-5">
                                    <div class="flex flex-col">
                                        <span
                                            class="category-name font-bold text-slate-800 group-hover:text-indigo-600 transition-colors">{{ $category->name }}</span>
                                        <span
                                            class="text-[11px] text-slate-400 font-mono mt-0.5">{{ $category->slug }}</span>
                                    </div>
                                </td>
                                <td class="hidden md:table-cell px-6 py-5">
                                    <p class="text-sm text-slate-500 max-w-xs line-clamp-1 italic italic-description">
                                        {{ $category->description ?: '---' }}
                                    </p>
                                </td>
                                <td class="px-6 py-5 text-center">
                                    <form action="{{ route('admin.categories.toggle', $category) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1 rounded-lg text-[11px] font-black uppercase tracking-tighter transition-all
                                            {{ $category->status == 'active' ? 'bg-emerald-50 text-emerald-600 ring-1 ring-emerald-200' : 'bg-slate-100 text-slate-500 ring-1 ring-slate-200' }}">
                                            <span
                                                class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $category->status == 'active' ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                            {{ $category->status }}
                                        </button>
                                    </form>
                                </td>
                                <td class="px-6 py-5">
                                    <div class="flex items-center justify-end gap-2">
                                        <button onclick="openEditModal(@js($category))"
                                            class="p-2 text-slate-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-xl transition-all">
                                            <i class="fa-solid fa-pen-to-square"></i>
                                        </button>
                                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                            onsubmit="return confirm('Are you sure?')">
                                            @csrf @method('DELETE')
                                            <button
                                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 rounded-xl transition-all">
                                                <i class="fa-solid fa-trash-can"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="no-results" class="hidden">
                                <td colspan="4" class="px-6 py-20 text-center text-slate-400">No categories match
                                    your search.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="category-modal"
            class="hidden fixed inset-0 bg-slate-900/40 backdrop-blur-[2px] z-50 flex items-center justify-center p-4 transition-all">
            <div class="bg-white rounded-[2rem] w-full max-w-md shadow-2xl border border-slate-100 shadow-slate-200/50">
                <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center">
                    <h3 id="modal-title" class="font-black text-slate-900 text-xl tracking-tight">Add New Category</h3>
                    <button onclick="toggleModal('category-modal')"
                        class="w-8 h-8 flex items-center justify-center rounded-full bg-slate-50 text-slate-400 hover:text-slate-600 transition-colors">&times;</button>
                </div>

                <form id="category-form" method="POST" action="{{ route('admin.categories.store') }}" class="p-8">
                    @csrf
                    <div id="method-field"></div>
                    <div class="space-y-5">
                        <div>
                            <label
                                class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Category
                                Name</label>
                            <input type="text" name="name" id="category-name-input" required
                                placeholder="e.g. Electronics"
                                class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 outline-none transition-all border">
                        </div>

                        <div>
                            <label
                                class="block text-[11px] font-black text-slate-400 uppercase tracking-widest mb-2 ml-1">Description</label>
                            <textarea name="description" id="category-desc-input" rows="3" placeholder="Describe this category..."
                                class="w-full px-5 py-3.5 bg-slate-50 border-transparent rounded-2xl focus:bg-white focus:ring-4 focus:ring-indigo-500/5 focus:border-indigo-500 outline-none transition-all border resize-none"></textarea>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full mt-8 py-4 bg-indigo-600 hover:bg-indigo-700 text-white rounded-2xl font-bold shadow-lg shadow-indigo-100 transition-all active:scale-[0.98]">
                        Confirm & Save
                    </button>
                </form>
            </div>
        </div>
    </main>

    @include('layouts.footer')
</body>

</html>
