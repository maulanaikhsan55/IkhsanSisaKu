<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - SisaKu')</title>
    <link rel="icon" type="image/png" href="{{ asset('storage/images/logo.png') }}">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        /* IMMEDIATE WHITE BACKGROUND - prevents any flash */
        html, body {
            background: #ffffff !important;
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Loading overlay styling */
        #globalLoadingOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
            transition: opacity 0.3s ease-out;
        }

        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Main content styling */
        #mainContent {
            opacity: 1;
            transition: opacity 0.5s ease-out;
        }

        :root {
            --primary: #16a34a;
            --primary-dark: #15803d;
            --bg-primary: #f8fafc;
            --text-primary: #0f172a;
            --text-secondary: #64748b;
        }

body {
    background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
}

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(22, 163, 74, 0.25);
            border-radius: 8px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: rgba(22, 163, 74, 0.4);
        }

        /* Animations */
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

        @keyframes scaleIn {
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
            animation: fadeInUp 0.5s cubic-bezier(0.4, 0, 0.2, 1) forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.4s cubic-bezier(0.4, 0, 0.2, 1) forwards;
            opacity: 1 !important;
            visibility: visible !important;
            display: block !important;
        }

        /* Glassmorphism */
        .glass-dark {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(30px) saturate(180%);
            -webkit-backdrop-filter: blur(30px) saturate(180%);
        }

        /* Mobile Touch Target Sizing - iOS Minimum 44x44px */
        button, a {
            min-height: 44px;
            min-width: 44px;
            -webkit-tap-highlight-color: transparent;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
        }

        /* Transitions */
        button, a, input, select, textarea {
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Card Hover */
        .card-hover {
            transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-6px) scale(1.01);
            box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
        }

        /* Shadows */
        .shadow-soft {
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .shadow-soft-lg {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        }

        .shadow-modern {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.05);
        }

        /* Icons — compatibility mapping for FA5 (fas/far/fab) and FA6 (fa-solid/fa-regular/fa-brands)
           This ensures existing <i class="fas fa-..."> markup still shows correctly with FA6 CSS. */
        .fa-solid, .fas { font-family: "Font Awesome 6 Free"; font-weight: 900; }
        .fa-regular, .far { font-family: "Font Awesome 6 Free"; font-weight: 400; }
        .fa-brands, .fab { font-family: "Font Awesome 6 Brands"; font-weight: 400; }

        i.fas, i.far, i.fab, i.fa-solid, i.fa-regular, i.fa-brands {
            display: inline-block;
            vertical-align: middle;
            opacity: 1 !important;
        }

        /* Borders */
        .border-modern {
            border: 1px solid rgba(226, 232, 240, 0.8);
        }

        /* Gradients */
        .gradient-primary {
            background: linear-gradient(135deg, #16a34a 0%, #15803d 100%);
        }



        main {
            animation: fadeInContent 0.22s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
            opacity: 0;
            will-change: opacity;
            backface-visibility: hidden;
            -webkit-backface-visibility: hidden;
        }

        @keyframes fadeInContent {
            from {
                opacity: 0;
                transform: translateY(1px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        body {
            transition: background 0.12s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }

        @media (prefers-reduced-motion: reduce) {
            main, body {
                animation: none;
                opacity: 1;
                transition: none;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-gray-50 to-slate-50 min-h-screen overflow-x-hidden">



    <div class="flex min-h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 w-full sm:ml-0 md:ml-0 lg:ml-72 px-2 md:px-3 lg:px-6 py-6 pb-32 sm:pb-40 overflow-x-hidden" id="mainContent">
            <div class="max-w-7xl mx-auto">
                <!-- Mobile Header -->
                <div class="lg:hidden flex items-center justify-between mb-4 sm:mb-5 -mx-2 md:-mx-3 lg:-mx-6 px-2 md:px-3 lg:px-6 py-2.5 bg-white/50 backdrop-blur sticky top-0 z-40 rounded-b-2xl sm:rounded-b-3xl">
                    <button id="sidebarToggle" class="p-1.5 hover:bg-gray-100 rounded-lg transition" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-gray-700 text-lg"></i>
                    </button>
                    <div class="flex items-center gap-1.5">
                        <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-5 h-5 sm:w-6 sm:h-6">
                        <span class="font-bold text-green-700 text-sm sm:text-base">SisaKu</span>
                    </div>
                    <div class="w-8"></div>
                </div>

                @yield('content')
            </div>
        </main>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden" onclick="toggleSidebar()"></div>

    <!-- Notification Container for Toast Messages -->
    <div id="notificationContainer" class="fixed top-4 right-4 z-50 space-y-2"></div>

    <!-- Custom Scripts -->
    <script>
        /**
         * Display notification message
         */
        function showNotification(message, type = 'success') {
            const container = document.getElementById('notificationContainer');
            if (!container) return;

            const bgColor = type === 'success' ? 'bg-green-50 border-green-500' : 'bg-red-50 border-red-500';
            const textColor = type === 'success' ? 'text-green-800' : 'text-red-800';
            const iconColor = type === 'success' ? 'text-green-500' : 'text-red-500';
            const icon = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';

            const notification = document.createElement('div');
            notification.className = `${bgColor} border-l-4 p-3 sm:p-4 rounded-lg sm:rounded-xl animate-scale-in alert-auto-hide text-sm`;
            notification.innerHTML = `
                <div class="flex items-center gap-2">
                    <i class="fas ${icon} ${iconColor} text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
                    <p class="${textColor} font-medium">${message}</p>
                </div>
            `;

            container.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 4000);
        }

        function toggleSidebar() {
            const sidebar = document.querySelector('aside');
            const overlay = document.getElementById('sidebarOverlay');
            
            if (sidebar && overlay) {
                sidebar.classList.toggle('sidebar-visible');
                overlay.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }
        }

        window.addEventListener('load', () => {
            // Fade in the entire page smoothly after everything is loaded
            document.documentElement.style.opacity = '1';

            // Ensure sidebar is hidden on mobile on page load
            const sidebar = document.querySelector('aside');
            if (sidebar && window.innerWidth < 1024) {
                sidebar.classList.remove('sidebar-visible');
            }

            setTimeout(() => {
                const alerts = document.querySelectorAll('.alert-auto-hide');
                alerts.forEach(alert => {
                    alert.style.transition = 'all 0.5s cubic-bezier(0.4, 0, 0.2, 1)';
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 500);
                });
            }, 5000);

            const elements = document.querySelectorAll('[class*="animate-"]');
            elements.forEach((element, index) => {
                element.style.animationDelay = `${index * 0.05}s`;
            });

            const sidebarToggle = document.getElementById('sidebarToggle');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                });
            }
        });

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 1024) {
                const sidebar = document.querySelector('aside');
                const overlay = document.getElementById('sidebarOverlay');
                if (sidebar) sidebar.classList.remove('sidebar-visible');
                if (overlay) overlay.classList.add('hidden');
                document.body.classList.remove('overflow-hidden');
            } else {
                const sidebar = document.querySelector('aside');
                if (sidebar) sidebar.classList.remove('sidebar-visible');
            }
        });

        // Auto-update notifications polling system
        let lastNotificationCount = 0;
        let notificationPollingInterval;

        function startNotificationPolling() {
            // Check immediately
            checkNotifications();

            // Then poll every 5 seconds for real-time feel
            notificationPollingInterval = setInterval(checkNotifications, 5000);
        }

        function stopNotificationPolling() {
            if (notificationPollingInterval) {
                clearInterval(notificationPollingInterval);
            }
        }

        function checkNotifications() {
            fetch('{{ route("admin.notifications.counts") }}')
                .then(response => response.json())
                .then(data => {
                    updateNotificationBadges(data);
                    checkForNewNotifications(data.total);
                    lastNotificationCount = data.total;
                })
                .catch(error => {});
        }

        function updateNotificationBadges(data) {
            // Update password reset badge
            const passwordResetBadge = document.getElementById('passwordResetBadge');
            if (passwordResetBadge) {
                if (data.password_resets > 0) {
                    passwordResetBadge.textContent = data.password_resets;
                    passwordResetBadge.classList.remove('hidden');
                } else {
                    passwordResetBadge.classList.add('hidden');
                }
            }

            // Update pending users badge
            const pendingUsersBadge = document.getElementById('pendingUsersBadge');
            if (pendingUsersBadge) {
                if (data.pending_users > 0) {
                    pendingUsersBadge.textContent = data.pending_users;
                    pendingUsersBadge.classList.remove('hidden');
                } else {
                    pendingUsersBadge.classList.add('hidden');
                }
            }

            // Update total notification badge in header
            const totalBadge = document.getElementById('totalNotificationBadge');
            if (totalBadge) {
                if (data.total > 0) {
                    totalBadge.textContent = data.total > 99 ? '99+' : data.total;
                    totalBadge.classList.remove('hidden');
                } else {
                    totalBadge.classList.add('hidden');
                }
            }
        }

        function checkForNewNotifications(currentTotal) {
            if (currentTotal > lastNotificationCount && lastNotificationCount > 0) {
                // There are new notifications, show toast
                showNewNotificationToast();
            }
        }

        function showNewNotificationToast() {
            fetch('{{ route("admin.notifications.recent") }}')
                .then(response => response.json())
                .then(data => {
                    if (data.notifications && data.notifications.length > 0) {
                        const notification = data.notifications[0];
                        showNotificationToast(notification);
                    }
                })
                .catch(error => {});
        }

        function showNotificationToast(notification) {
            const container = document.getElementById('notificationContainer');
            if (!container) return;

            const toast = document.createElement('div');
            toast.className = 'bg-blue-50 border-l-4 border-blue-500 p-3 sm:p-4 rounded-lg sm:rounded-xl animate-scale-in notification-toast cursor-pointer';
            toast.onclick = () => window.location.href = notification.url;

            toast.innerHTML = `
                <div class="flex items-start gap-3">
                    <i class="fas ${notification.icon} text-blue-500 text-lg sm:text-xl mt-0.5 flex-shrink-0"></i>
                    <div class="flex-1 min-w-0">
                        <p class="text-blue-800 font-semibold text-sm">${notification.title}</p>
                        <p class="text-blue-700 text-xs sm:text-sm mt-1">${notification.message}</p>
                        <p class="text-blue-600 text-xs mt-1">${notification.time}</p>
                    </div>
                    <button onclick="event.stopPropagation(); this.parentElement.parentElement.remove()" class="text-blue-400 hover:text-blue-600 ml-2">
                        <i class="fas fa-times text-sm"></i>
                    </button>
                </div>
            `;

            container.appendChild(toast);

            // Auto remove after 8 seconds
            setTimeout(() => {
                if (toast.parentElement) {
                    toast.style.transition = 'all 0.5s ease';
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateX(100%)';
                    setTimeout(() => toast.remove(), 500);
                }
            }, 8000);
        }

        function makeNumbersResponsive() {
            const responsiveElements = document.querySelectorAll('.responsive-number');

            responsiveElements.forEach(element => {
                const card = element.closest('.glass-dark');
                if (!card) return;

                const iconElement = card.querySelector('.w-12.h-12, .w-10, .w-11, .w-12');
                const iconWidth = iconElement ? iconElement.offsetWidth + 20 : 68;

                const text = element.getAttribute('data-value') || element.textContent.trim();
                const cardWidth = card.offsetWidth;
                const padding = 40;
                const availableWidth = cardWidth - padding - iconWidth;

                element.style.fontSize = '';

                const testSpan = document.createElement('span');
                testSpan.style.fontSize = window.getComputedStyle(element).fontSize;
                testSpan.style.fontFamily = window.getComputedStyle(element).fontFamily;
                testSpan.style.fontWeight = window.getComputedStyle(element).fontWeight;
                testSpan.style.position = 'absolute';
                testSpan.style.visibility = 'hidden';
                testSpan.style.whiteSpace = 'nowrap';
                testSpan.textContent = text;
                document.body.appendChild(testSpan);

                const textWidth = testSpan.offsetWidth;
                document.body.removeChild(testSpan);

                const scale = Math.min(1, availableWidth / textWidth);
                const finalScale = Math.max(0.25, scale);

                const originalSize = parseFloat(window.getComputedStyle(element).fontSize);
                const newSize = originalSize * finalScale;

                const minSize = 12;
                const finalSize = Math.max(minSize, newSize);

                element.style.fontSize = `${finalSize}px`;

                if (finalScale < 0.5) {
                    element.style.letterSpacing = '0.5px';
                } else {
                    element.style.letterSpacing = '';
                }
            });
        }

        // Start polling when page loads
        document.addEventListener('DOMContentLoaded', () => {
            // Check notifications immediately on page load
            checkNotifications();
            startNotificationPolling();
            makeNumbersResponsive();
            window.addEventListener('resize', makeNumbersResponsive);
        });

        // Stop polling when page unloads
        window.addEventListener('beforeunload', () => {
            stopNotificationPolling();
        });
    </script>

    <!-- Custom JS -->
    @vite(['resources/js/app.js'])

    @stack('scripts')

    <!-- Floating Chatbot -->
    @include('components.floating-chatbot')
</body>
</html>