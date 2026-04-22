<!DOCTYPE html>
<html lang="en">

<head>
    <title>Information Hub - Order Ready</title>
    @include('layouts.head')
</head>

<body class="bg-white text-slate-900 antialiased">

    @include('layouts.header')
    @include('layouts.notifications')
    <main class="max-w-7xl mx-auto px-6 lg:px-8 py-20" x-data="{ tab: 'legal' }" x-init="if (window.location.hash) tab = window.location.hash.replace('#', '')">

        <div class="flex flex-col md:flex-row gap-12">

            <aside class="w-full md:w-1/4 space-y-2">
                <h1 class="text-2xl font-black mb-8 px-4 text-blue-600 tracking-tight">Information Hub</h1>

                <button @click="tab = 'legal'"
                    :class="tab === 'legal' ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-600'"
                    class="w-full text-left px-6 py-4 rounded-2xl font-bold transition-all flex items-center gap-3">
                    <i class="fa-solid fa-scale-balanced"></i> Legal Information
                </button>

                <button @click="tab = 'privacy'"
                    :class="tab === 'privacy' ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-600'"
                    class="w-full text-left px-6 py-4 rounded-2xl font-bold transition-all flex items-center gap-3">
                    <i class="fa-solid fa-user-shield"></i> Privacy Policy
                </button>

                <button @click="tab = 'terms'"
                    :class="tab === 'terms' ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-600'"
                    class="w-full text-left px-6 py-4 rounded-2xl font-bold transition-all flex items-center gap-3">
                    <i class="fa-solid fa-file-contract"></i> Terms of Service
                </button>

                <button @click="tab = 'safety'"
                    :class="tab === 'safety' ? 'bg-blue-600 text-white shadow-lg' : 'hover:bg-slate-50 text-slate-600'"
                    class="w-full text-left px-6 py-4 rounded-2xl font-bold transition-all flex items-center gap-3">
                    <i class="fa-solid fa-shield-heart"></i> Safety Tips
                </button>
            </aside>

            <div class="w-full md:w-3/4 bg-slate-50 rounded-[2.5rem] p-8 md:p-12 border border-slate-100">

                <div x-show="tab === 'legal'" x-transition class="space-y-6" id="legal">
                    <h2 class="text-3xl font-black text-slate-950 mb-6">Legal Information</h2>
                    <p class="text-slate-600 leading-relaxed">Order Ready is a peer-to-peer connection platform. We act
                        strictly as a technical intermediary between sellers and buyers.</p>
                    <div class="p-6 bg-white rounded-2xl border border-slate-200">
                        <h3 class="font-bold text-blue-600 mb-2">Platform Role</h3>
                        <p class="text-sm text-slate-500">We do not own, sell, or ship any products listed on this site.
                            We do not process payments or take commissions on sales.</p>
                    </div>
                </div>

                <div x-show="tab === 'privacy'" x-transition x-cloak class="space-y-6" id="privacy">
                    <h2 class="text-3xl font-black text-slate-950 mb-6">Privacy Policy</h2>
                    <p class="text-slate-600 leading-relaxed">Your data security is our priority. We only collect
                        essential information required to create a safe communication bridge.</p>
                    <ul class="space-y-4 text-slate-600 text-sm">
                        <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-blue-500 mt-1"></i>
                            No selling of personal data.</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-blue-500 mt-1"></i>
                            Messages are secure between users.</li>
                        <li class="flex items-start gap-2"><i class="fa-solid fa-circle-check text-blue-500 mt-1"></i>
                            You have total control over your profile visibility.</li>
                    </ul>
                </div>

                <div x-show="tab === 'terms'" x-transition x-cloak class="space-y-6" id="terms">
                    <h2 class="text-3xl font-black text-slate-950 mb-6">Terms of Service</h2>
                    <p class="text-slate-600 leading-relaxed">By using Order Ready, you agree to trade fairly and
                        respect other members of the community.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="p-4 bg-white rounded-xl border border-slate-100 font-bold text-sm text-center">No
                            Spamming</div>
                        <div class="p-4 bg-white rounded-xl border border-slate-100 font-bold text-sm text-center">
                            Genuine Listings Only</div>
                        <div class="p-4 bg-white rounded-xl border border-slate-100 font-bold text-sm text-center">Fair
                            Communication</div>
                        <div class="p-4 bg-white rounded-xl border border-slate-100 font-bold text-sm text-center">
                            Respect Admin Decisions</div>
                    </div>
                </div>

                <div x-show="tab === 'safety'" x-transition x-cloak class="space-y-6" id="safety">
                    <h2 class="text-3xl font-black text-slate-950 mb-6 text-red-600">Safety First</h2>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm">
                            <i class="fa-solid fa-location-dot text-2xl text-blue-600"></i>
                            <div>
                                <h4 class="font-black text-slate-900">Public Meetings</h4>
                                <p class="text-sm text-slate-500">Always meet in a public, well-lit place to exchange
                                    items and money.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm">
                            <i class="fa-solid fa-money-bill-transfer text-2xl text-green-600"></i>
                            <div>
                                <h4 class="font-black text-slate-900">Payment Safety</h4>
                                <p class="text-sm text-slate-500">Never send money in advance. Inspect the product
                                    before handing over the payment.</p>
                            </div>
                        </div>
                        <div class="flex items-start gap-4 p-5 bg-white rounded-2xl shadow-sm border border-red-50">
                            <i class="fa-solid fa-circle-exclamation text-2xl text-red-600"></i>
                            <div>
                                <h4 class="font-black text-slate-900">Report Suspects</h4>
                                <p class="text-sm text-slate-500">If a deal sounds too good to be true, or a user is
                                    aggressive, use our report button immediately.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    @include('layouts.footer')

</body>

</html>
