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
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Product Reports</h1>
                    <p class="text-sm text-slate-500">Review user complaints and take action on products</p>
                </div>
                <div
                    class="flex items-center gap-2 text-sm font-medium text-slate-600 bg-white px-4 py-2 rounded-lg border border-slate-200">
                    <i class="fa-solid fa-flag text-red-500"></i>
                    <span>Total Reports: {{ $reports->total() }}</span>
                </div>
            </div>

            <div class="space-y-4">
                @forelse($reports as $report)
                    <div class="report-card bg-white border border-slate-200 rounded-2xl p-5 shadow-sm">
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
                                        <p class="text-[11px] text-slate-400 uppercase font-semibold">Reporter</p>
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <p class="text-xs text-slate-500">
                                        <i class="fa-regular fa-clock mr-1"></i>
                                        {{ $report->created_at->diffForHumans() }}
                                    </p>
                                    <span
                                        class="inline-block px-2 py-1 rounded text-[10px] font-bold uppercase {{ $report->status == 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-emerald-100 text-emerald-700' }}">
                                        {{ $report->status }}
                                    </span>
                                </div>
                            </div>

                            <div class="lg:w-2/4">
                                <h3 class="text-sm font-bold text-slate-400 uppercase mb-2 tracking-tight">Reason for
                                    Report</h3>
                                <p class="text-slate-700 text-sm leading-relaxed italic">
                                    "{{ $report->reason }}"
                                </p>
                                <div class="mt-4 p-3 bg-slate-50 rounded-xl border border-dashed border-slate-200">
                                    <p class="text-[11px] font-bold text-slate-500 mb-1 uppercase">Target Product:</p>
                                    <p class="text-sm font-semibold text-blue-600">{{ $report->product->name ?? 'N/A' }}
                                    </p>
                                </div>
                            </div>

                            <div class="lg:w-1/4 flex flex-col justify-center gap-3">
                                <a href="{{ route('shop.products.show', $report->product) }}"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-white border border-slate-300 rounded-xl text-sm font-bold text-slate-700 hover:bg-slate-50 transition-all">
                                    <i class="fa-solid fa-eye text-slate-400"></i>
                                    Inspect Product
                                </a>

                                <button onclick="openBanModal({{ $report->id }}, '{{ $report->product_id }}')"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-red-600 rounded-xl text-sm font-bold text-white hover:bg-red-700 shadow-md transition-all">
                                    <i class="fa-solid fa-ban"></i>
                                    Take Action
                                </button>
                            </div>
                        </div>
                    </div>

                    <div id="actionModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
                        <div class="flex items-center justify-center min-h-screen px-4">
                            <div class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal()"></div>

                            <div class="relative bg-white rounded-2xl shadow-xl max-w-md w-full p-6 overflow-hidden">
                                <div class="mb-6">
                                    <h3 class="text-xl font-bold text-slate-900">Resolve This Report</h3>
                                    <p class="text-sm text-slate-500">Decide if this product should be banned or kept
                                        active.</p>
                                </div>

                                <form action="{{ route('admin.reports.update') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="report_id" id="modal_report_id">
                                    <input type="hidden" name="product_id" id="modal_product_id">

                                    <div class="space-y-4">
                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Update
                                                Report Status</label>
                                            <select name="report_status"
                                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm outline-none">
                                                <option value="pending">Pending</option>
                                                <option value="reviewed">Reviewed</option>
                                                <option value="resolved">Resolved</option>
                                                <option value="rejected">Rejected</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-slate-500 uppercase mb-1">Product
                                                Admin Status</label>
                                            <select name="product_admin_status"
                                                class="w-full px-3 py-2 bg-slate-50 border border-slate-200 rounded-lg text-sm outline-none">
                                                <option value="active">Active</option>
                                                <option value="banned">Banned</option>
                                            </select>
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 uppercase mb-2">Message
                                                to Seller (Ban Reason)</label>
                                            <textarea name="seller_message" rows="2" required
                                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Why is this product being restricted?"></textarea>
                                        </div>

                                        <div>
                                            <label
                                                class="block text-xs font-bold text-slate-700 uppercase mb-2">Feedback
                                                to Reporter</label>
                                            <textarea name="reporter_message" rows="2" required
                                                class="w-full px-4 py-2 bg-slate-50 border border-slate-200 rounded-xl text-sm outline-none focus:ring-2 focus:ring-blue-500"
                                                placeholder="Thank you for your report, we have..."></textarea>
                                        </div>
                                    </div>

                                    <div class="mt-6 flex justify-end gap-3">
                                        <button type="button" onclick="closeModal()"
                                            class="px-4 py-2 text-sm font-semibold text-slate-500">Cancel</button>
                                        <button type="submit"
                                            class="px-6 py-2 bg-blue-600 text-white rounded-lg text-sm font-bold hover:bg-blue-700 transition-colors">
                                            Save Changes
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="bg-white border border-slate-200 rounded-2xl p-20 text-center">
                        <i class="fa-solid fa-circle-check text-slate-200 text-6xl mb-4"></i>
                        <p class="text-slate-500 font-medium">All clear! No reports found.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-10">
                {{ $reports->links() }}
            </div>
        </div>
    </main>

    @include('layouts.footer')

    <script>
        function openBanModal(reportId, productId) {
            // Set the hidden input values
            document.getElementById('modal_report_id').value = reportId;
            document.getElementById('modal_product_id').value = productId;

            // Show the modal by removing 'hidden'
            const modal = document.getElementById('actionModal');
            modal.classList.remove('hidden');

            // Add a small delay then fade in (if you want to add transitions later)
            document.body.style.overflow = 'hidden'; // Stop background scrolling
        }

        function closeModal() {
            const modal = document.getElementById('actionModal');
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto'; // Re-enable scrolling
        }

        // Close modal if user clicks outside the white box
        window.onclick = function(event) {
            const modal = document.getElementById('actionModal');
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>
