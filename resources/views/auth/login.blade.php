<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk ke SisaKu</title>
    <link rel="icon" type="image/png" href="{{ asset('build/assets/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }
    </style>
</head>
<body class="bg-green-50 text-gray-800">

    <!-- Navigation -->
    <nav class="w-full fixed top-0 left-0 right-0 z-50 flex items-center justify-center pt-2 sm:pt-4 px-4">
        <div class="flex items-center gap-4 sm:gap-8 bg-white shadow-lg rounded-full px-4 sm:px-10 py-2 sm:py-3 border border-gray-200 w-full sm:w-auto max-w-md sm:max-w-none">
            <div class="flex items-center gap-2">
                <div class="w-10 sm:w-12 h-10 sm:h-12 bg-white rounded-2xl shadow-lg flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('build/assets/logo.png') }}" alt="Logo" class="w-6 sm:w-8 h-6 sm:h-8">
                </div>
                <span class="font-bold text-green-700 text-lg sm:text-xl">SisaKu</span>
            </div>
            <a href="{{ route('welcome') }}" class="hidden sm:inline text-sm text-gray-700 hover:text-green-700 transition font-medium">Beranda</a>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="min-h-screen flex items-center justify-center px-4 pt-24 sm:pt-32 pb-10 sm:pb-20">
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl w-full max-w-sm p-6 sm:p-10">
            <!-- Logo & Header -->
            <div class="text-center mb-8 sm:mb-10">
                <h2 class="text-2xl sm:text-3xl font-bold mb-2"><span class="text-gray-800">Masuk ke </span><span class="text-green-700">SisaKu</span></h2>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-700 px-3 sm:px-4 py-2 sm:py-3 rounded-lg sm:rounded-xl mb-6 text-sm">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
                @csrf

                <!-- Email/Username Input -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Email atau Username</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-green-700 text-sm"></i>
                        <input
                            type="text"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="email@gmail.com"
                            class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 bg-green-50 border-2 border-green-200 rounded-lg sm:rounded-xl text-sm focus:outline-none focus:border-green-700 focus:bg-white transition"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-green-700 text-sm"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            class="w-full pl-10 sm:pl-12 pr-10 sm:pr-12 py-2.5 sm:py-3 bg-green-50 border-2 border-green-200 rounded-lg sm:rounded-xl text-sm focus:outline-none focus:border-green-700 focus:bg-white transition"
                            required
                        >
                        <button type="button" onclick="togglePassword()" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-700 text-sm">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-green-700 border-gray-300 rounded focus:ring-green-700">
                    <label for="remember" class="ml-2 text-xs sm:text-sm text-gray-600">Ingat saya</label>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full bg-green-700 hover:bg-green-800 text-white py-2.5 sm:py-3 rounded-lg sm:rounded-xl font-semibold shadow-lg transition transform hover:scale-105 text-sm sm:text-base"
                >
                    Masuk
                </button>

                <!-- Forgot Password -->
                <div class="text-center">
                    <a href="{{ route('password.request') }}" class="text-xs sm:text-sm text-green-700 hover:text-green-800 font-medium">Lupa password?</a>
                </div>


            </form>
        </div>
    </div>

    @include('partials.footer')

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eyeIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>
