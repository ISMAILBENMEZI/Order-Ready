<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.head')
    <title>Account Suspended</title>
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full bg-white rounded-[2.5rem] shadow-xl p-10 text-center border border-slate-100">
        <div class="w-20 h-20 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <i class="fa-solid fa-user-slash text-3xl"></i>
        </div>

        <h1 class="text-2xl font-black text-slate-900 mb-2">Account Suspended</h1>
        <p class="text-slate-500 text-sm mb-8 leading-relaxed">
            Hello <span class="font-bold text-slate-800">{{ session('name') }}</span>, your account (<span
                class="italic">{{ session('email') }}</span>) has been disabled by the administrator.
        </p>

        <div class="bg-amber-50 border border-amber-100 rounded-2xl p-4 mb-8 text-left">
            <div class="flex gap-3">
                <i class="fa-solid fa-circle-info text-amber-500 mt-1"></i>
                <p class="text-xs text-amber-700 leading-normal">
                    If you believe this is a mistake or would like to appeal, please contact our support team.
                </p>
            </div>
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('contact') }}"
                class="w-full py-4 bg-slate-900 text-white rounded-2xl font-bold hover:bg-blue-600 transition-all shadow-lg shadow-slate-200">
                Contact Support
            </a>
            <a href="{{ route('home') }}" class="text-sm font-bold text-slate-400 hover:text-slate-600 transition-all">
                Back to Homepage
            </a>
        </div>
    </div>
</body>

</html>
