<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard - SisaKu')</title>
    <link rel="icon" type="image/png" href="{{ asset('build/assets/logo.png') }}">
    
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
        * {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
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
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 via-gray-50 to-slate-50 min-h-screen overflow-x-hidden">

    <div class="flex min-h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('admin.partials.sidebar')

        <!-- Main Content -->
        <main class="flex-1 w-full sm:ml-0 md:ml-0 lg:ml-72 p-2 sm:p-3 md:p-6 lg:p-8 pb-32 sm:pb-40 overflow-x-hidden" id="mainContent">
            <div class="max-w-7xl mx-auto">
                <!-- Mobile Header -->
                <div class="lg:hidden flex items-center justify-between mb-4 sm:mb-5 -mx-2 sm:-mx-3 -mt-2 sm:-mt-3 px-2 sm:px-3 py-2.5 bg-white/50 backdrop-blur sticky top-0 z-40">
                    <button id="sidebarToggle" class="p-1.5 hover:bg-gray-100 rounded-lg transition" onclick="toggleSidebar()">
                        <i class="fas fa-bars text-gray-700 text-lg"></i>
                    </button>
                    <div class="flex items-center gap-1.5">
                        <img src="{{ asset('build/assets/logo.png') }}" alt="Logo" class="w-5 h-5 sm:w-6 sm:h-6">
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

        document.addEventListener('DOMContentLoaded', () => {
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

        // Password Reset Notification Polling
        function checkPasswordResetRequests() {
            fetch('{{ route("admin.password-reset.api.pending-count") }}')
                .then(response => response.json())
                .then(data => {
                    const badge = document.getElementById('passwordResetBadge');
                    if (badge) {
                        if (data.count > 0) {
                            badge.textContent = data.count;
                            badge.classList.remove('hidden');
                        } else {
                            badge.classList.add('hidden');
                        }
                    }
                })
                .catch(error => console.error('Error checking password reset requests:', error));
        }

        // Check on page load only
        document.addEventListener('DOMContentLoaded', () => {
            checkPasswordResetRequests();
        });
    </script>

    @stack('scripts')

    <!-- Floating Chatbot -->
    @include('components.floating-chatbot')
</body>
</html>