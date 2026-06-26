<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Panel</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<div class="admin-layout">

    <aside class="admin-sidebar">

        @php
            $setting = \App\Models\Setting::first();
        @endphp

        <div class="admin-logo">
            <span class="logo-text">{{ $setting->site_name ?? 'News Admin' }}</span>
            <button class="menu-toggle-admin" onclick="toggleAdminMenu()">
                <i class="fas fa-bars"></i>
            </button>
        </div>

        <nav class="admin-menu" id="adminMenu">

            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fa-solid fa-chart-simple"></i>
                Dashboard
            </a>

            <a href="{{ route('news.create') }}" class="{{ request()->routeIs('news.create') ? 'active' : '' }}">
                <i class="fa-solid fa-plus"></i>
                Create news
            </a>

            <a href="{{ route('admin.users') }}" class="{{ request()->routeIs('admin.users') ? 'active' : '' }}">
                <i class="fa-solid fa-users"></i>
                Users
            </a>

            <a href="{{ route('admin.categories') }}" class="{{ request()->routeIs('admin.categories') ? 'active' : '' }}">
                <i class="fa-solid fa-folder"></i>
                Categories
            </a>

            <a href="{{ route('admin.contacts.index') }}" class="{{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                <i class="fa-solid fa-envelope"></i>
                Messages
                @php
                    $newContactsCount = \App\Models\Contact::where('status', 'new')->count();
                @endphp
                @if($newContactsCount > 0)
                    <span class="badge">{{ $newContactsCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.settings') }}" class="{{ request()->routeIs('admin.settings') ? 'active' : '' }}">
                <i class="fa-solid fa-gear"></i>
                Settings
            </a>

        </nav>

    </aside>

    <main class="admin-content">

        @yield('content')

    </main>

</div>

<script>
function toggleAdminMenu() {
    const menu = document.getElementById('adminMenu');
    menu.classList.toggle('open');
}

// Закриваємо меню при кліку поза ним
document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.admin-sidebar');
    const menu = document.getElementById('adminMenu');
    const toggleBtn = document.querySelector('.menu-toggle-admin');
    
    if (window.innerWidth <= 768) {
        if (!sidebar.contains(event.target)) {
            menu.classList.remove('open');
        }
    }
});

// Закриваємо меню при виборі пункту
document.querySelectorAll('.admin-menu a').forEach(link => {
    link.addEventListener('click', function() {
        if (window.innerWidth <= 768) {
            document.getElementById('adminMenu').classList.remove('open');
        }
    });
});
</script>

</body>
</html>