<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify Identity - EasyColoc</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .code-input:focus {
            transform: scale(1.05);
            border-color: #2563eb;
            box-shadow: 0 10px 15px -3px rgba(37, 99, 235, 0.1);
        }
    </style>
</head>

<body class="bg-[#fcfcfd] min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <div class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-blue-50 rounded-full blur-[120px] -z-10"></div>
    <div class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-indigo-50 rounded-full blur-[120px] -z-10"></div>

    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-3xl shadow-xl shadow-blue-100 mb-4 border border-blue-50">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#2563eb"
                    stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 13V6a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h9" />
                    <polyline points="22 7 12 13 2 7" />
                    <path d="M18 19l2 2 4-4" />
                </svg>
            </div>
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Check your mail.</h1>
            <p class="text-slate-500 font-medium mt-2 px-6">We've sent a 6-digit security code to your email address.
            </p>
        </div>

        <div class="glass-card p-10 rounded-[2.5rem] shadow-2xl shadow-slate-200/60">
            @if (session('success'))
                <div
                    class="mb-6 p-4 rounded-2xl bg-emerald-50 text-emerald-700 text-sm font-bold flex items-center gap-3 border border-emerald-100 italic">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="3">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <p class="bg-red-100 text-red-700 p-3 rounded mb-4">
                    {{ session('error') }}
                </p>
            @endif

            <form method="POST" action="{{ route('auth.verify.email') }}">
                @csrf

                <div class="mb-8 text-center">
                    <label class="block text-xs font-black text-slate-400 uppercase tracking-[0.2em] mb-4">Verification
                        Code</label>
                    <input type="text" name="code" maxlength="6"
                        class="code-input w-full text-center text-4xl font-black tracking-[0.5em] py-5 bg-white border-2 border-slate-100 rounded-2xl transition-all outline-none text-blue-600 shadow-inner"
                        placeholder="000000" required>

                    @error('code')
                        <p class="text-red-500 text-xs font-bold mt-3 bg-red-50 py-2 rounded-lg italic">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-slate-900 text-white py-5 rounded-2xl font-black text-sm hover:bg-blue-600 transition-all shadow-xl shadow-slate-200 active:scale-[0.98]">
                    Verify & Continue
                </button>
            </form>

            <div class="text-center mt-4">
                <p class="text-sm text-gray-600 mb-2">
                    Didn't receive the code?
                </p>

                <form method="POST" action="{{ route('auth.resend.code') }}">
                    @csrf
                    <button type="submit" class="text-blue-600 hover:underline font-medium">
                        Resend Email
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
