<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>Masuk ke SisaKu</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInScale {
            from {
                opacity: 0;
                transform: scale(0.95);
            }
            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-fade-in-scale {
            animation: fadeInScale 0.5s ease-out;
        }

        .animate-delay-100 {
            animation-delay: 0.1s;
        }

        .animate-delay-200 {
            animation-delay: 0.2s;
        }

        .animate-delay-300 {
            animation-delay: 0.3s;
        }

        .animate-delay-400 {
            animation-delay: 0.4s;
        }

        .animate-delay-500 {
            animation-delay: 0.5s;
        }

        .animate-delay-600 {
            animation-delay: 0.6s;
        }
    </style>
</head>
<body class="bg-green-50 text-gray-800">

    <!-- Navigation -->
    <nav class="w-full fixed top-0 left-0 right-0 z-50 flex items-center justify-center pt-2 sm:pt-4 px-3 sm:px-4">
        <div class="flex items-center gap-1 sm:gap-6 bg-white shadow-lg rounded-full px-2.5 sm:px-6 md:px-8 py-1.5 sm:py-3 border border-gray-200 w-fit">
            <div class="flex items-center gap-1.5">
                <div class="w-8 sm:w-11 h-8 sm:h-11 bg-white rounded-xl sm:rounded-2xl shadow-md flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-4.5 sm:w-6 h-4.5 sm:h-6">
                </div>
                <span class="font-bold text-green-700 text-sm sm:text-lg">SisaKu</span>
            </div>
            <div class="hidden sm:block w-px h-5 bg-gray-200"></div>
            <a href="{{ route('welcome') }}" class="text-xs sm:text-sm text-gray-700 hover:text-green-700 transition-colors font-medium whitespace-nowrap">Beranda</a>
        </div>
    </nav>

    <!-- Login Container -->
    <div class="min-h-screen flex items-center justify-center px-4 pt-24 sm:pt-32 pb-10 sm:pb-20">
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl w-full max-w-sm sm:max-w-md lg:max-w-lg p-6 sm:p-8 lg:p-10 animate-fade-in-scale">
            <!-- Logo & Header -->
            <div class="text-center mb-8 sm:mb-10 animate-fade-in-up">
                <div class="inline-flex items-center justify-center w-14 sm:w-16 h-14 sm:h-16 bg-green-600 rounded-3xl mb-3 sm:mb-4 shadow-lg animate-fade-in-scale animate-delay-100">
                    <i class="fas fa-sign-in-alt text-white text-xl sm:text-2xl"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2 animate-fade-in-up animate-delay-200">Masuk ke SisaKu</h1>
                <p class="text-xs sm:text-sm text-gray-600 animate-fade-in-up animate-delay-300">Kelola sampah dengan mudah</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg text-sm">
                    <div class="flex gap-2">
                        <i class="fas fa-exclamation-circle text-red-500 text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
                        <div>
                            <p class="text-red-800 font-semibold text-xs sm:text-sm">Terjadi kesalahan:</p>
                            @foreach ($errors->all() as $error)
                                <p class="text-red-700 text-xs sm:text-sm">{{ $error }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-4 sm:space-y-6">
                @csrf

                <!-- Email/Username Input -->
                <div class="animate-fade-in-up animate-delay-300">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Email atau Username</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-green-600 text-sm"></i>
                        <input
                            type="text"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="email@gmail.com"
                            class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 bg-green-50 border-2 border-green-200 rounded-lg sm:rounded-xl text-sm focus:outline-none focus:border-green-600 focus:bg-white transition"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div class="animate-fade-in-up animate-delay-400">
                    <label class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-green-600 text-sm"></i>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            placeholder="••••••••"
                            class="w-full pl-10 sm:pl-12 pr-10 sm:pr-12 py-2.5 sm:py-3 bg-green-50 border-2 border-green-200 rounded-lg sm:rounded-xl text-sm focus:outline-none focus:border-green-600 focus:bg-white transition"
                            required
                        >
                        <button type="button" onclick="togglePassword()" class="absolute right-3 sm:right-4 top-1/2 -translate-y-1/2 text-gray-400 hover:text-green-600 text-sm">
                            <i class="fas fa-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center animate-fade-in-up animate-delay-500">
                    <input type="checkbox" name="remember" id="remember" class="w-4 h-4 text-green-700 border-gray-300 rounded focus:ring-green-700">
                    <label for="remember" class="ml-2 text-xs sm:text-sm text-gray-600">Ingat saya</label>
                </div>

                <!-- Login Button -->
                <button
                    type="submit"
                    class="w-full bg-green-600 hover:bg-green-700 text-white py-2.5 sm:py-3 rounded-lg sm:rounded-xl font-semibold shadow-lg transition transform hover:scale-105 text-sm sm:text-base animate-fade-in-up animate-delay-600"
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

    <!-- Floating Chatbot -->
    @include('components.floating-chatbot')
</body>
</html>
