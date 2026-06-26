@extends('layouts.main')

@section('header-title')
About
@endsection

@section('content')

<div class="main-content">


    <h1>About</h1>

    <div class="hero-image">
    <img src="{{ asset('storage/news/newsletter.jpg') }}" alt="about">
    <div class="hero-overlay">
        <div class="overlay-content">
            <h3>Your trusted news source</h3>
            <p>Objectivity. Reliability. Relevance.</p>
            <div class="overlay-line"></div>
            <a href="{{ route('news.index') }}" class="overlay-btn">
                <span>Read News</span>
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>
    </div>
    </div>

    <div class="about-block mission-block">
        <div class="block-icon">
            <i class="fas fa-bullseye"></i>
        </div>
        <h2>Our mission</h2>
        <p>
           We strive to provide our readers with truthful, objective and up-to-date information about events in Ukraine and the world.
        </p>
    </div>

    <div class="about-block who-block">
        <div class="block-icon">
            <i class="fas fa-users"></i>
        </div>
        <h2>Who we are</h2>
        <p>
            NEWS is a modern news publication that covers political, economic, cultural and sports events.
        </p>
    </div>

    <div class="about-block values-block">
        <div class="block-icon">
            <i class="fas fa-gem"></i>
        </div>
        <h2>Our values</h2>

        <div class="values">

            <div class="value-item">
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <h3>
                    Certainty
                </h3>
                <p>We check every fact.</p>
            </div>

            <div class="value-item">
                <div class="icon">
                    <i class="fas fa-eye"></i>
                </div>
                <h3>
                    Objectivity
                </h3>
                <p>Without prejudice and manipulation.</p>
            </div>

            <div class="value-item">
                <div class="icon">
                    <i class="fas fa-bolt"></i>
                </div>
                <h3>Topicality</h3>
                <p>We provide news promptly.</p>
            </div>

            <div class="value-item">
                <div class="icon">
                    <i class="fas fa-heart"></i>
                </div>
                <h3>Responsibility</h3>
                <p>We respect every reader.</p>
            </div>

        </div>
    </div>

</div>
 
@endsection