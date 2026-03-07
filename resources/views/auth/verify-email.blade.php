<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-md bg-white shadow-lg rounded-xl p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            Verify Your Email
        </h2>

        @if (session('success'))
            <p class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </p>
        @endif

        <form method="POST" action="{{ route('auth.verify.email') }}">
            @csrf

            <div class="mb-4">
                <label class="block text-gray-700 mb-2">Verification Code</label>
                <input type="text" name="code" maxlength="6" class="w-full px-4 py-2 border rounded-lg"
                    placeholder="Enter 6-digit code">
                @error('code')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded-lg hover:bg-blue-700">
                Verify Email
            </button>
        </form>
    </div>

</body>

</html>
