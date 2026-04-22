<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Manage Reports — Admin</title>
    @include('layouts.head')
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .report-card {
            transition: all 0.2s ease;
        }

        .report-card:hover {
            border-color: #3b82f6;
        }
    </style>
</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    @include('layouts.header')

    <main class="flex-grow py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">

            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4">
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}"
                        class="flex items-center justify-center w-10 h-10 bg-white border border-slate-200 rounded-xl text-slate-400 hover:text-blue-600 hover:border-blue-200 hover:shadow-sm transition-all">
                        <i class="fa-solid fa-arrow-left"></i>
                    </a>

                    <div>
                        <h1 class="text-2xl font-bold text-slate-900">Product Reports</h1>
                        <p class="text-sm text-slate-500">Review user complaints and take action</p>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <div
                        class="hidden sm:flex items-center gap-2 text-sm font-medium text-slate-600 bg-white px-4 py-2 rounded-lg border border-slate-200 shadow-sm">
                        <i class="fa-solid fa-flag text-red-500"></i>
                        <span>Total: {{ $reports->total() }}</span>
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4 mb-6 border-b border-slate-200">
                <a href="{{ route('admin.reports.index') }}"
                    class="pb-4 text-sm font-bold transition-all {{ !request('status') ? 'text-blue-600 border-b-2 border-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                    All
                </a>
                <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}"
                    class="pb-4 text-sm font-bold transition-all {{ request('status') == 'pending' ? 'text-amber-600 border-b-2 border-amber-600' : 'text-slate-400 hover:text-slate-600' }}">
                    Pending
                </a>
                <a href="{{ route('admin.reports.index', ['status' => 'reviewed']) }}"
                    class="pb-4 text-sm font-bold transition-all {{ request('status') == 'reviewed' ? 'text-blue-600 border-b-2 border-blue-600' : 'text-slate-400 hover:text-slate-600' }}">
                    Reviewed
                </a>
                <a href="{{ route('admin.reports.index', ['status' => 'resolved']) }}"
                    class="pb-4 text-sm font-bold transition-all {{ request('status') == 'resolved' ? 'text-emerald-600 border-b-2 border-emerald-600' : 'text-slate-400 hover:text-slate-600' }}">
                    Resolved
                </a>
                <a href="{{ route('admin.reports.index', ['status' => 'rejected']) }}"
                    class="pb-4 text-sm font-bold transition-all {{ request('status') == 'rejected' ? 'text-red-600 border-b-2 border-red-600' : 'text-slate-400 hover:text-slate-600' }}">
                    Rejected
                </a>
            </div>

            <div class="space-y-4">
                @forelse($reports as $report)
                    <div
                        class="report-card bg-white border-l-4 {{ $report->status == 'pending' ? 'border-l-amber-500 shadow-md' : 'border-l-emerald-500' }} border border-slate-200 rounded-2xl p-5 shadow-sm transition-all">
                        <div class="flex flex-col lg:flex-row gap-6">

                            <div
                                class="lg:w-1/4 border-b lg:border-b-0 lg:border-r border-slate-100 pb-4 lg:pb-0 lg:pr-6">
                                <div class="flex items-center gap-3 mb-3">
                                    <div
                                        class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $report->user->name }}</p>
                                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-wider">
                                            Reporter</p>
                                    </div>
                                </div>
                                <div class="space-y-2">
                                    <p class="text-[11px] text-slate-500">
                                        <i class="fa-regular fa-clock mr-1"></i>
                                        {{ $report->created_at->diffForHumans() }}
                                    </p>
                                    <span
                                        class="inline-block px-2 py-0.5 rounded text-[10px] font-bold uppercase ring-1 {{ $report->status == 'pending' ? 'bg-amber-50 text-amber-600 ring-amber-200' : 'bg-emerald-50 text-emerald-600 ring-emerald-200' }}">
                                        {{ $report->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="lg:w-2/4">
                                <h3 class="text-[10px] font-bold text-slate-400 uppercase mb-2 tracking-widest">Reason
                                    for Report</h3>
                                <p class="text-slate-700 text-sm leading-relaxed italic mb-4">"{{ $report->reason }}"
                                </p>

                                @if ($report->admin_note)
                                    <div class="mb-4 p-3 bg-blue-50 border border-blue-100 rounded-xl">
                                        <p class="text-[10px] font-bold text-blue-600 uppercase mb-1">Last Admin Note:
                                        </p>
                                        <p class="text-xs text-blue-800">{{ $report->admin_note }}</p>
                                    </div>
                                @endif

                                <div
                                    class="p-3 bg-slate-50 rounded-xl border border-dashed border-slate-200 flex items-center justify-between">
                                    <div>
                                        <p class="text-[10px] font-bold text-slate-500 mb-1 uppercase">Target Product:
                                        </p>
                                        <p class="text-sm font-semibold text-slate-800">
                                            {{ $report->product->name ?? 'N/A' }}</p>
                                    </div>
                                    <span
                                        class="text-[10px] font-bold px-2 py-1 rounded {{ $report->product->admin_status == 'banned' ? 'bg-red-100 text-red-600' : 'bg-emerald-100 text-emerald-600' }}">
                                        {{ strtoupper($report->product->admin_status ?? 'UNKNOWN') }}
                                    </span>
                                </div>
                            </div>

                            <div class="lg:w-1/4 flex flex-col justify-center gap-3">
                                <a href="{{ route('shop.products.show', $report->product) }}"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-xs font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                    <i class="fa-solid fa-eye text-slate-400"></i> Inspect
                                </a>

                                @if ($report->status != 'resolved')
                                    <button onclick="openBanModal({{ $report->id }}, '{{ $report->product_id }}')"
                                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-900 rounded-xl text-xs font-bold text-white hover:bg-red-600 shadow-md transition-all">
                                        <i class="fa-solid fa-gavel"></i> Take Action
                                    </button>
                                @else
                                    <button disabled
                                        class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-slate-100 rounded-xl text-xs font-bold text-slate-400 cursor-not-allowed">
                                        <i class="fa-solid fa-check-double text-emerald-500"></i> Completed
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 rounded-2xl p-20 text-center">
                        <i class="fa-solid fa-circle-check text-slate-200 text-6xl mb-4"></i>
                        <p class="text-slate-500 font-medium">No reports found for this category.</p>
                    </div>
                @endforelse
            </div>
    </main>

    @include('layouts.footer')

    <script>
        function openBanModal(reportId, productId) {
            document.getElementById('modal_report_id').value = reportId;
            document.getElementById('modal_product_id').value = productId;

            const modal = document.getElementById('actionModal');
            modal.classList.remove('hidden');

            document.body.style.overflow = 'hidden'; 
        }

        function closeModal() {
            const modal = document.getElementById('actionModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; 
        }

        window.onclick = function(event) {
            const modal = document.getElementById('actionModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>
