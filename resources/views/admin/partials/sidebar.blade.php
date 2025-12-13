<aside class="sidebar-main" style="border-radius: 0 24px 24px 0;">
    <div class="flex flex-col h-full p-2 sm:p-3 md:p-4 md:p-5">
        
        <!-- Logo Section -->
        <div class="px-1 sm:px-1.5 md:px-2 py-2 sm:py-2.5 md:py-3 mb-2 sm:mb-2.5 md:mb-3">
            <div class="flex items-center gap-2 sm:gap-2.5 md:gap-3">
                <div class="w-8 sm:w-9 md:w-10 h-8 sm:h-9 md:h-10 bg-white rounded-lg sm:rounded-xl shadow-md flex items-center justify-center flex-shrink-0">
                    <img src="{{ asset('storage/images/logo.png') }}" alt="Logo" class="w-4 sm:w-5 md:w-6 h-4 sm:h-5 md:h-6">
                </div>
                <div class="min-w-0">
                    <h1 class="text-sm sm:text-base md:text-lg font-bold text-green-700 truncate">SisaKu</h1>
                    <p class="text-xs text-gray-400 font-normal mt-0">Admin</p>
                </div>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex-1 overflow-y-auto px-2 sm:px-3 custom-scrollbar">
            <div class="space-y-2 sm:space-y-2.5">

                <!-- Main Navigation -->
                <div class="nav-section">
                    <div class="nav-section-title">Menu Utama</div>

                    <!-- Dashboard -->
                    <a href="{{ route('admin.dashboard') }}"
                       class="nav-link {{ request()->routeIs('admin.dashboard') ? 'nav-active' : '' }}">
                        <div class="nav-icon-wrapper">
                            <i class="fas fa-th-large"></i>
                        </div>
                        <span class="nav-label">Dashboard</span>
                    </a>

                    <!-- Karang Taruna -->
                    <a href="{{ route('admin.karang-taruna.index') }}"
                       class="nav-link {{ request()->routeIs('admin.karang-taruna.*') ? 'nav-active' : '' }}">
                        <div class="nav-icon-wrapper">
                            <i class="fas fa-building"></i>
                        </div>
                        <span class="nav-label">Karang Taruna</span>
                    </a>
                </div>

                <!-- Divider -->
                <div class="nav-divider"></div>

                <!-- Data Management -->
                <div class="nav-section">
                    <div class="nav-section-title">Manajemen Data</div>

                    <!-- Master Data Group -->
                    <div class="nav-group">
                        <button onclick="toggleSubmenu('master-data')" class="nav-link nav-parent">
                            <div class="nav-icon-wrapper relative">
                                <i class="fas fa-database"></i>
                                <span id="pendingUsersBadge" class="absolute -top-2 -right-2 hidden bg-orange-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center animate-pulse">0</span>
                            </div>
                            <span class="nav-label">Master Data</span>
                            <i class="fas fa-chevron-down nav-chevron" id="master-data-icon"></i>
                        </button>
                        <div class="nav-submenu" id="master-data-submenu">
                            <a href="{{ route('admin.master-data.kategori-sampah') }}"
                               class="submenu-link {{ request()->routeIs('admin.master-data.kategori-sampah') ? 'submenu-active' : '' }}">
                                <i class="fas fa-circle submenu-bullet"></i>
                            <span>Kategori & Harga Sampah</span>
                            </a>
                            <a href="{{ route('admin.master-data.kategori-keuangan') }}"
                               class="submenu-link {{ request()->routeIs('admin.master-data.kategori-keuangan') ? 'submenu-active' : '' }}">
                                <i class="fas fa-circle submenu-bullet"></i>
                                <span>Kategori Keuangan</span>
                            </a>
                        </div>
                    </div>

                    <!-- Laporan Group -->
                    <div class="nav-group">
                        <button onclick="toggleSubmenu('laporan')" class="nav-link nav-parent">
                            <div class="nav-icon-wrapper">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            <span class="nav-label">Laporan</span>
                            <i class="fas fa-chevron-down nav-chevron" id="laporan-icon"></i>
                        </button>
                        <div class="nav-submenu" id="laporan-submenu">
                            <a href="{{ route('admin.laporan.arus-kas') }}"
                               class="submenu-link {{ request()->routeIs('admin.laporan.arus-kas') ? 'submenu-active' : '' }}">
                                <i class="fas fa-circle submenu-bullet"></i>
                                <span>Arus Kas</span>
                            </a>
                            <a href="{{ route('admin.laporan.dampak-lingkungan') }}"
                               class="submenu-link {{ request()->routeIs('admin.laporan.dampak-lingkungan') ? 'submenu-active' : '' }}">
                                <i class="fas fa-circle submenu-bullet"></i>
                                <span>Dampak Lingkungan</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Divider -->
                <div class="nav-divider"></div>

                <!-- System & Settings -->
                <div class="nav-section">
                    <div class="nav-section-title">Sistem</div>

                    <!-- Password Reset Requests -->
                    <a href="{{ route('admin.password-reset.index') }}"
                       class="nav-link relative {{ request()->routeIs('admin.password-reset.*') ? 'nav-active' : '' }}">
                        <div class="nav-icon-wrapper relative">
                            <i class="fas fa-bell"></i>
                            <span id="passwordResetBadge" class="absolute -top-2 -right-2 hidden bg-red-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center animate-pulse">0</span>
                        </div>
                        <span class="nav-label">Permintaan Reset Password</span>
                    </a>

                    <!-- Pengaturan -->
                    <a href="{{ route('admin.pengaturan') }}"
                       class="nav-link {{ request()->routeIs('admin.pengaturan') ? 'nav-active' : '' }}">
                        <div class="nav-icon-wrapper">
                            <i class="fas fa-cog"></i>
                        </div>
                        <span class="nav-label">Pengaturan</span>
                    </a>
                </div>

            </div>
        </nav>

        <!-- User Profile Footer -->
        <div class="px-0.5 sm:px-1 md:px-1.5 py-2 sm:py-2.5 md:py-3 border-t border-gray-200/20 mt-auto flex-shrink-0">
            <div class="profile-container">
                <div class="profile-info">
                    <div class="profile-avatar">
                        {{ substr(auth()->user()->nama_lengkap ?? auth()->user()->name, 0, 1) }}
                    </div>
                    <div class="min-w-0">
                        <p class="profile-name">{{ auth()->user()->nama_lengkap ?? auth()->user()->name }}</p>
                        <p class="profile-role">Admin</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="logout-button" title="Logout">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>

    </div>
</aside>

<style>
/* Sidebar Styling */
.sidebar-main {
    position: fixed;
    top: 0;
    left: 0;
    height: 100vh;
    width: 224px;
    z-index: 50;
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border-right: 1px solid rgba(0, 0, 0, 0.04);
    box-shadow: 2px 0 12px rgba(0, 0, 0, 0.04);
    transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    transform: translateX(-100%);
}

@media (min-width: 640px) {
    .sidebar-main {
        width: 256px;
    }
}

@media (min-width: 768px) {
    .sidebar-main {
        width: 288px;
    }
}

@media (min-width: 1024px) {
    .sidebar-main {
        transform: translateX(0);
        width: 288px;
    }
}

.sidebar-main.sidebar-visible {
    transform: translateX(0);
}

.sidebar-glass {
    background: rgba(255, 255, 255, 0.98);
    backdrop-filter: blur(20px) saturate(180%);
    -webkit-backdrop-filter: blur(20px) saturate(180%);
    border-right: 1px solid rgba(0, 0, 0, 0.04);
    box-shadow: 2px 0 12px rgba(0, 0, 0, 0.04);
}

.custom-scrollbar::-webkit-scrollbar {
    width: 4px;
}

.custom-scrollbar::-webkit-scrollbar-track {
    background: transparent;
}

.custom-scrollbar::-webkit-scrollbar-thumb {
    background: rgba(22, 163, 74, 0.2);
    border-radius: 10px;
}

.custom-scrollbar::-webkit-scrollbar-thumb:hover {
    background: rgba(22, 163, 74, 0.3);
}

/* Navigation Links */
.nav-link {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 7px 9px;
    border-radius: 12px;
    color: #64748b;
    font-size: 12px;
    font-weight: 400;
    text-decoration: none;
    cursor: pointer;
    border: none;
    background: rgba(0, 0, 0, 0.02);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    width: 100%;
    outline: none;
    position: relative;
}

@media (min-width: 640px) {
    .nav-link {
        gap: 10px;
        padding: 8px 11px;
        border-radius: 14px;
        font-size: 13px;
    }
}

@media (min-width: 768px) {
    .nav-link {
        gap: 12px;
        padding: 9px 13px;
        border-radius: 16px;
        font-size: 14px;
    }
}

.nav-link:hover {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.nav-link.nav-active {
    background: rgba(34, 197, 94, 0.12);
    color: #16a34a;
    font-weight: 500;
    box-shadow: none;
}

.nav-icon-wrapper {
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    font-size: 13px;
    background: rgba(34, 197, 94, 0.08);
    border-radius: 10px;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

@media (min-width: 640px) {
    .nav-icon-wrapper {
        width: 19px;
        height: 19px;
        font-size: 14px;
        border-radius: 11px;
    }
}

@media (min-width: 768px) {
    .nav-icon-wrapper {
        width: 20px;
        height: 20px;
        font-size: 15px;
        border-radius: 12px;
    }
}

.nav-icon-wrapper i {
    opacity: 1 !important;
    transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
}

.nav-link:hover .nav-icon-wrapper i {
    transform: scale(1.05);
}

.nav-link.nav-active::before {
    content: '';
    position: absolute;
    left: 0;
    top: 50%;
    transform: translateY(-50%);
    width: 3px;
    height: 20px;
    background: #16a34a;
    border-radius: 0 2px 2px 0;
}

.nav-link.nav-parent {
    cursor: pointer;
}

.nav-link.nav-parent:hover {
    background: rgba(34, 197, 94, 0.1);
}

.nav-label {
    flex: 1;
    word-break: break-word;
}

.nav-chevron {
    margin-left: auto;
    font-size: 9px;
    transition: transform 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    color: #94a3b8;
    flex-shrink: 0;
}

@media (min-width: 768px) {
    .nav-chevron {
        font-size: 10px;
    }
}

/* Submenu */
.nav-group {
    margin: 0;
    padding: 0;
}

.nav-submenu {
    margin-top: 0;
    margin-left: 14px;
    padding-left: 0;
    border-left: none;
    overflow: hidden;
    max-height: 0;
    transition: max-height 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    opacity: 0;
}

@media (min-width: 640px) {
    .nav-submenu {
        margin-left: 16px;
    }
}

@media (min-width: 768px) {
    .nav-submenu {
        margin-left: 20px;
    }
}

.nav-submenu.show {
    max-height: 400px;
    opacity: 1;
}

.submenu-link {
    display: flex;
    align-items: center;
    gap: 7px;
    padding: 5px 8px;
    color: #64748b;
    font-size: 11px;
    font-weight: 400;
    border-radius: 10px;
    margin: 1px 0;
    text-decoration: none;
    border: none;
    outline: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    background: rgba(0, 0, 0, 0.02);
}

@media (min-width: 640px) {
    .submenu-link {
        gap: 8px;
        padding: 6px 10px;
        font-size: 12px;
        border-radius: 12px;
        margin: 1.5px 0;
    }
}

@media (min-width: 768px) {
    .submenu-link {
        gap: 9px;
        padding: 7px 11px;
        font-size: 13px;
        border-radius: 14px;
        margin: 2px 0;
    }
}

.submenu-link:hover {
    background: rgba(34, 197, 94, 0.1);
    color: #16a34a;
}

.submenu-link.submenu-active {
    background: rgba(34, 197, 94, 0.12);
    color: #16a34a;
    font-weight: 500;
}

.submenu-bullet {
    font-size: 3.5px;
    opacity: 0.5;
    color: #16a34a;
    flex-shrink: 0;
}

@media (min-width: 640px) {
    .submenu-bullet {
        font-size: 4px;
    }
}

/* Navigation Sections */
.nav-section {
    margin-bottom: 8px;
}

@media (min-width: 640px) {
    .nav-section {
        margin-bottom: 10px;
    }
}

@media (min-width: 768px) {
    .nav-section {
        margin-bottom: 12px;
    }
}

.nav-section-title {
    font-size: 9px;
    font-weight: 600;
    color: #94a3b8;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
    padding: 0 2px;
}

@media (min-width: 640px) {
    .nav-section-title {
        font-size: 9.5px;
        margin-bottom: 5px;
        padding: 0 3px;
    }
}

@media (min-width: 768px) {
    .nav-section-title {
        font-size: 10px;
        margin-bottom: 6px;
        padding: 0 4px;
    }
}

/* Divider */
.nav-divider {
    height: 1px;
    background: rgba(0, 0, 0, 0.06);
    margin: 4px 0;
    border: none;
    padding: 0;
}

@media (min-width: 640px) {
    .nav-divider {
        margin: 5px 0;
    }
}

@media (min-width: 768px) {
    .nav-divider {
        margin: 6px 0;
    }
}

/* Profile Section */
.profile-container {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 8px 9px;
    border-radius: 16px;
    background: rgba(34, 197, 94, 0.08);
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(34, 197, 94, 0.12);
    gap: 6px;
}

@media (min-width: 640px) {
    .profile-container {
        padding: 9px 10px;
        border-radius: 18px;
        gap: 8px;
    }
}

@media (min-width: 768px) {
    .profile-container {
        padding: 10px 11px;
        border-radius: 20px;
        gap: 10px;
    }
}

.profile-container:hover {
    background: rgba(34, 197, 94, 0.12);
    border-color: rgba(34, 197, 94, 0.2);
}

.profile-info {
    display: flex;
    align-items: center;
    gap: 7px;
    flex: 1;
    min-width: 0;
}

@media (min-width: 640px) {
    .profile-info {
        gap: 8px;
    }
}

@media (min-width: 768px) {
    .profile-info {
        gap: 10px;
    }
}

.profile-avatar {
    width: 32px;
    height: 32px;
    background: #16a34a;
    border-radius: 7px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 11px;
    flex-shrink: 0;
}

@media (min-width: 640px) {
    .profile-avatar {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        font-size: 12px;
    }
}

@media (min-width: 768px) {
    .profile-avatar {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        font-size: 13px;
    }
}

.profile-name {
    font-size: 11px;
    font-weight: 500;
    color: #1f2937;
    margin: 0;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

@media (min-width: 640px) {
    .profile-name {
        font-size: 11.5px;
    }
}

@media (min-width: 768px) {
    .profile-name {
        font-size: 12px;
    }
}

.profile-role {
    font-size: 9px;
    font-weight: 400;
    color: #94a3b8;
    margin: 1px 0 0 0;
}

@media (min-width: 640px) {
    .profile-role {
        font-size: 9.5px;
        margin: 1.5px 0 0 0;
    }
}

@media (min-width: 768px) {
    .profile-role {
        font-size: 10px;
        margin: 2px 0 0 0;
    }
}

.logout-button {
    padding: 6px 7px;
    border-radius: 7px;
    color: #ef4444;
    background: transparent;
    border: none;
    cursor: pointer;
    outline: none;
    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
    flex-shrink: 0;
    font-size: 11px;
}

@media (min-width: 640px) {
    .logout-button {
        padding: 6.5px 7.5px;
        border-radius: 8px;
        font-size: 12px;
    }
}

@media (min-width: 768px) {
    .logout-button {
        padding: 7px 8px;
        border-radius: 8px;
        font-size: 13px;
    }
}

.logout-button:hover {
    background: rgba(239, 68, 68, 0.1);
    color: #dc2626;
}

/* Icons */
i.fas, i.far, i.fab {
    opacity: 1 !important;
}
</style>

<script>
function toggleSubmenu(menuId) {
    const submenu = document.getElementById(menuId + '-submenu');
    const icon = document.getElementById(menuId + '-icon');
    
    if (submenu && icon) {
        submenu.classList.toggle('show');
        icon.style.transform = submenu.classList.contains('show') ? 'rotate(180deg)' : 'rotate(0deg)';
    }
}

// Auto-open active submenu on page load
document.addEventListener('DOMContentLoaded', function() {
    const activeSubmenuItems = document.querySelectorAll('.submenu-link.submenu-active');
    activeSubmenuItems.forEach(item => {
        const submenu = item.closest('.nav-submenu');
        if (submenu) {
            submenu.classList.add('show');
            const groupId = submenu.id.replace('-submenu', '');
            const icon = document.getElementById(groupId + '-icon');
            if (icon) {
                icon.style.transform = 'rotate(180deg)';
            }
        }
    });
});
</script>