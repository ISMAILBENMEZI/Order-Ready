<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Order Ready</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/js/auth/register.js'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</head>

<body class="bg-slate-50 min-h-screen flex flex-col">
    @include('layouts.header')

    <main class="flex-grow flex items-center justify-center p-4 my-10">

        <div class="w-full max-w-lg bg-white shadow-2xl rounded-2xl overflow-hidden">

            <div id="form-alert"
                class="fixed top-6 left-1/2 -translate-x-1/2 hidden px-6 py-4 rounded-2xl shadow-xl text-sm font-bold z-50 transition-all duration-300">
            </div>

            <div class="w-full p-8 md:p-10">
                <div class="text-center mb-8">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-blue-50 text-blue-600 rounded-full mb-4">
                        <i class="fa-solid fa-user-plus text-2xl"></i>
                    </div>
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Create Account</h2>
                    <p class="text-gray-500 mt-2">Join Order Ready and start connecting today</p>
                </div>

                <form id="register-form" method="POST" action="{{ route('auth.register.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-semibold px-1">Full Name</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-user"></i>
                            </span>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="John Doe"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white">
                        </div>
                        @error('name')
                            <p class="text-red-500 text-sm mt-1 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-semibold px-1">Email Address</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-envelope"></i>
                            </span>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="example@gmail.com"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-sm mt-1 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2 font-semibold px-1">Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-lock"></i>
                            </span>
                            <input type="password" name="password" id="password" placeholder="••••••••"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 mb-2 font-semibold px-1">Confirm Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400">
                                <i class="fa-solid fa-shield-check"></i>
                            </span>
                            <input type="password" name="password_confirmation" placeholder="••••••••"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="block text-gray-700 mb-2 font-semibold px-1">Register As</label>
                        <div class="relative">
                            <span
                                class="absolute inset-y-0 left-0 pl-4 flex items-center text-gray-400 pointer-events-none">
                                <i class="fa-solid fa-users-gear"></i>
                            </span>
                            <select name="role_id"
                                class="w-full pl-11 pr-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-blue-500 outline-none transition-all bg-slate-50 focus:bg-white appearance-none">
                                @foreach ($roles as $role)
                                    <option value="{{ $role->id }}"
                                        {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            <div
                                class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-gray-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                        @error('role_id')
                            <p class="text-red-500 text-sm mt-1 px-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 shadow-lg shadow-blue-100 transition-all active:scale-[0.98] flex items-center justify-center gap-2">
                        <span>Create Account</span>
                        <i class="fa-solid fa-user-check text-sm"></i>
                    </button>
                </form>

                <p class="text-center text-gray-500 mt-8 text-sm font-medium">
                    Already have an account?
                    <a href="{{ route('auth.login') }}"
                        class="text-blue-600 font-bold hover:underline transition duration-200">Sign In</a>
                </p>
            </div>
        </div>
    </main>

    @include('layouts.footer')

</body>

</html>
