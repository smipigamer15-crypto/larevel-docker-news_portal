@extends('layouts.main')

@section('header-title')
{{ $category }}
@endsection

@section('content')

<div class="category-page">

    <h1 class="category-title">
        <i class="fa-regular fa-newspaper"></i>
        {{ $category }}
    </h1>

    <p class="category-subtitle">
        The latest and most relevant news about {{ $category }}
    </p>

    <div class="category-news-grid">

        @foreach($news as $item)

        <article class="category-news-card">

            <div class="category-news-image">
                <img src="{{ asset('storage/'.$item->image) }}"
                     alt="{{ $item->title }}">

                <span class="category-badge">
                    {{ $item->category }}
                </span>
            </div>

            <h3 class="category-news-title">
                <a href="{{ route('news.show', $item->id) }}">
                    {{ $item->title }}
                </a>
            </h3>

            <div class="category-news-meta">

                <span>
                    <i class="fa-regular fa-clock"></i>
                    {{ $item->created_at->format('d.m.Y H:i') }}
                </span>

                <span>
                    <i class="fa-regular fa-eye"></i>
                    {{ $item->views ?? 0 }}
                </span>

            </div>

        </article>

        @endforeach

    </div>

</div>

@endsection