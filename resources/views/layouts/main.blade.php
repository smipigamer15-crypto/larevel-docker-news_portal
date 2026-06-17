<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('header-title')</title>
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
</head>
<body>
    

<header>
    <div class="container">
        <div class="topbar-left">
            <span class="current-date">
                {{ now()->format('l, d F Y') }}
            </span>

            <a href="{{ route('about') }}">About</a>
            <a href="{{ route('contact') }}">Contact</a>
        </div>

        <div class="topbar-right">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</header>

<nav class="main-navbar">
    <div class="container">
        <div class="logo">
            <a href="{{ route('home') }}">NEWS</a>
        </div>

        <ul class="nav-menu">

    <li>
        <a href="{{ route('home') }}"
           class="{{ request()->routeIs('home') ? 'active' : '' }}">
            Home
        </a>
    </li>

    <li>
        <a href="{{ route('news.index') }}"
           class="{{ request()->routeIs('news.index') ? 'active' : '' }}">
            News
        </a>
    </li>

    <li>
        <a href="{{ route('news.category', 'Politics') }}"
           class="{{ request()->is('category/Politics') ? 'active' : '' }}">
            Politics
        </a>
    </li>

    <li>
        <a href="{{ route('news.category', 'World') }}"
           class="{{ request()->is('category/World') ? 'active' : '' }}">
            World
        </a>
    </li>

    <li>
        <a href="{{ route('news.category', 'Sports') }}"
           class="{{ request()->is('category/Sports') ? 'active' : '' }}">
            Sports
        </a>
    </li>

    <li>
        <a href="{{ route('news.category', 'Culture') }}"
           class="{{ request()->is('category/Culture') ? 'active' : '' }}">
            Culture
        </a>
    </li>

    <li>

        @auth
            @if(auth()->user()->hasAnyRole(['admin','helper']))
                <a href="{{ route('admin.dashboard') }}" class="admin-link" target="_blank">
                    Admin
                </a>
            @endif
        @endauth
    </li>

        </ul>

    <div class="header-actions">

  <form action="{{ route('search.index') }}" method="GET" class="search-wrapper" id="searchWrapper">

    <input type="text" name="q" id="searchInput" class="search-input" placeholder="Search news..." autocomplete="off">

    <div class="search-results" id="searchResults"></div>

    <button type="button" class="search-btn" id="searchBtn">
        <i class="fas fa-search"></i>
    </button>

</form>


        @auth
    <a href="{{ route('dashboard') }}" class="login-btn">
        {{ auth()->user()->name }}
    </a>
        @endauth

        @guest
    <a href="{{ route('login') }}" class="login-btn">
        <i class="fas fa-user"></i>
        Login
    </a>
        @endguest

        </div>
    </div>
</nav>

<div class="news-layout">


@yield('content')
@if(!isset($hideSidebar) || !$hideSidebar)
    <aside class="sidebar">
@php
    $latestNews = \App\Models\News::latest()->take(4)->get();
@endphp
       <div class="sidebar-widget">
    <h3>Latest news</h3>
    @foreach($latestNews as $item)
        <a href="{{ route('news.show', $item->id) }}" class="latest-item">
            <img src="{{ asset('storage/'.$item->image) }}" alt="{{ $item->title }}">
            <div>
                <h5>
                    {{ Str::limit($item->title, 45) }}
                </h5>
                <span>
                    {{ $item->created_at->format('d.m.Y H:i') }}
                </span>
            </div>
        </a>

    @endforeach

</div>

        <div class="sidebar-widget">
    <h3>Categories</h3>

    <ul class="category-list">
        <li>
            <a href="{{ route('news.category', 'Politics') }}">
                <span><i class="fa-solid fa-landmark"></i> Politics</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </li>

        <li>
            <a href="{{ route('news.category', 'World') }}">
                <span><i class="fa-solid fa-earth-europe"></i> World</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </li>

        <li>
            <a href="{{ route('news.category', 'Sports') }}">
                <span><i class="fa-solid fa-futbol"></i> Sports</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </li>

        <li>
            <a href="{{ route('news.category', 'Culture') }}">
                <span><i class="fa-solid fa-masks-theater"></i> Culture</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>
        </li>
    </ul>
</div>
    </aside>
@endif

</div>



<footer class="footer">
    <div class="footer-container">

        <div class="footer-col">
            <h4>NEWS</h4>
            <p class="footer-desc">
              We cover the most important events in Ukraine and the world, providing prompt, reliable and up-to-date information. Our goal is to help readers stay informed about major news, social changes, economic processes, political decisions, and events that affect the lives of the country and every citizen.
            </p>

            <div class="socials">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-youtube"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <div class="footer-col">
            <h4>Navigation</h4>
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('news.index') }}">News</a></li>
                <li><a href="{{ route('news.category', 'Politics') }}">Politics</a></li>
                <li><a href="{{ route('news.category', 'World') }}">World</a></li>
                <li><a href="{{ route('news.category', 'Sports') }}">Sports</a></li>
                <li><a href="{{ route('news.category', 'Culture') }}">Culture</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Information</h4>
            <ul>
                <li><a href="{{ route('about') }}">About us</a></li>
                <li> <a href="{{ route('contact') }}">Contacts</a></li>
                <li><a href="#">Privacy policy</a></li>
                <li><a href="#">Cookie</a></li>
            </ul>
        </div>

    </div>

    <div class="footer-bottom">
        <p>© {{ date('Y') }} NEWS. All rights reserved.</p>
        <p>Created in Ukraine 🇺🇦</p>
    </div>
</footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
</body>
</html>