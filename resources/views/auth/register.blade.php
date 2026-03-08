<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account - Order Ready</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    @vite(['resources/js/auth/register.js'])
</head>

<body class="bg-slate-50 min-h-screen flex items-center justify-center p-4">

    <div class="w-full max-w-lg bg-white shadow-2xl rounded-2xl overflow-hidden">
        <div id="form-alert"
            class="fixed top-6 left-1/2 -translate-x-1/2 hidden px-6 py-4 rounded-2xl shadow-xl text-sm font-bold z-50 transition-all duration-300">
        </div>

        <div class="w-full p-8 md:p-10">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Create Account</h2>
                <p class="text-gray-500 mt-2">Join Order Ready and start connecting today</p>
            </div>

            <form id="register-form" method="POST" action="{{ route('auth.register.store') }}">
                @csrf

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border rounded-lg">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-2 border rounded-lg">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Password</label>
                    <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg">
                </div>

                <div class="mb-6">
                    <label class="block text-gray-700 mb-2">Register As</label>
                    <select name="role_id" class="w-full px-4 py-2 border rounded-lg">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id') == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                    Create Account
                </button>
            </form>

            <p class="text-center text-gray-500 mt-8 text-sm">
                Already have an account?
                <a href="#" class="text-blue-600 font-bold hover:underline transition duration-200">Sign In</a>
            </p>
        </div>
    </div>

</body>

</html>
