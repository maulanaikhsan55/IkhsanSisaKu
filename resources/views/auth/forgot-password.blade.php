<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <title>Lupa Password - SisaKu</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo.png') }}">
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
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-6 sm:w-8 h-6 sm:h-8">
                </div>
                <span class="font-bold text-green-700 text-lg sm:text-xl">SisaKu</span>
            </div>
            <a href="{{ route('welcome') }}" class="hidden sm:inline text-sm text-gray-700 hover:text-green-600 transition font-medium">Beranda</a>
        </div>
    </nav>

    <!-- Forgot Password Container -->
    <div class="min-h-screen flex items-center justify-center px-4 pt-24 sm:pt-32 pb-10 sm:pb-20">
        <div class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl w-full max-w-sm p-6 sm:p-10">
            <!-- Logo & Header -->
            <div class="text-center mb-8 sm:mb-10">
                <div class="inline-flex items-center justify-center w-14 sm:w-16 h-14 sm:h-16 bg-gradient-to-br from-green-500 to-emerald-600 rounded-2xl mb-3 sm:mb-4 shadow-lg">
                    <i class="fas fa-key text-white text-xl sm:text-2xl"></i>
                </div>
                <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Lupa Password?</h1>
                <p class="text-xs sm:text-sm text-gray-600">Masukkan email Anda untuk mengirim permintaan reset password ke admin</p>
            </div>

            <!-- Status Message -->
            @if(session('status'))
            <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-3 sm:p-4 rounded-lg animate-scale-in text-sm">
                <div class="flex gap-2">
                    <i class="fas fa-check-circle text-green-500 text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="text-green-800 font-semibold text-xs sm:text-sm">Berhasil!</p>
                        <p class="text-green-700 text-xs sm:text-sm mt-1">{{ session('status') }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Error Messages -->
            @if($errors->any())
            <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-3 sm:p-4 rounded-lg animate-scale-in text-sm">
                <div class="flex gap-2">
                    <i class="fas fa-exclamation-circle text-red-500 text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
                    <div>
                        <p class="text-red-800 font-semibold text-xs sm:text-sm">Terjadi kesalahan:</p>
                        @foreach($errors->all() as $error)
                        <p class="text-red-700 text-xs sm:text-sm">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('password.email') }}" method="POST" class="space-y-4 sm:space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">Email</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-green-600 text-sm"></i>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               placeholder="email@gmail.com"
                               class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-2.5 sm:py-3 bg-green-50 border-2 border-green-200 rounded-lg sm:rounded-xl text-sm focus:outline-none focus:border-green-600 focus:bg-white transition @error('email') border-red-500 bg-red-50 @enderror"
                               required>
                    </div>
                    @error('email')
                    <p class="mt-2 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2.5 sm:py-3 rounded-lg sm:rounded-xl font-semibold shadow-lg transition transform hover:scale-105 text-sm sm:text-base">
                    <i class="fas fa-paper-plane mr-2"></i>
                    Kirim Permintaan ke Admin
                </button>
            </form>

            <!-- Back to Login -->
            <div class="text-center mt-6">
                <p class="text-xs sm:text-sm text-gray-600">Ingat password Anda? 
                    <a href="{{ route('login') }}" class="text-green-600 hover:text-green-700 font-semibold transition">
                        Kembali ke Login
                    </a>
                </p>
            </div>
        </div>
    </div>

    @include('partials.footer')

</body>
</html>
