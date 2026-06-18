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
            {{ $setting->site_name ?? 'News Admin' }}
        </div>

        <nav class="admin-menu">

            <a href="{{ route('admin.dashboard') }}">
                <i class="fa-solid fa-chart-simple"></i>
                Dashboard
            </a>

            <a href="{{ route('news.create') }}">
                <i class="fa-solid fa-plus"></i>
                Create news
            </a>

            <a href="{{ route('admin.users') }}">
                <i class="fa-solid fa-users"></i>
                Users
            </a>

            <a href="{{ route('admin.categories') }}">
                <i class="fa-solid fa-folder"></i>
                Categories
            </a>

            <a href="{{ route('admin.contacts.index') }}">
                <i class="fa-solid fa-envelope"></i>
                Messages
                @php
                    $newContactsCount = \App\Models\Contact::where('status', 'new')->count();
                @endphp
                @if($newContactsCount > 0)
                    <span class="badge">{{ $newContactsCount }}</span>
                @endif
            </a>

            <a href="{{ route('admin.settings') }}">
                <i class="fa-solid fa-gear"></i>
                Settings
            </a>

        </nav>

    </aside>

    <main class="admin-content">

        @yield('content')

    </main>

</div>

</body>
</html>


