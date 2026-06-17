@extends('layouts.main')

@section('content')

<div class="category-page">

    <h1 class="category-title">
        <i class="fa-solid fa-magnifying-glass"></i>
        Search results: "{{ $query }}"
    </h1>

    <p class="category-subtitle">
        News found for your query
    </p>

    @if($news->count())

        <div class="news-grid">

            @foreach($news as $item)
            <article class="news-card">

                <div class="news-image">
                    <img src="{{ asset('storage/'.$item->image) }}"
                         alt="{{ $item->title }}">

                    <span class="news-category">
                        {{ $item->category }}
                    </span>
                </div>

                <h3>
                    <a href="{{ route('news.show', $item->id) }}">
                        {{ $item->title }}
                    </a>
                </h3>

                <div class="news-meta">
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

        <div class="pagination">
            {{ $news->links() }}
        </div>

    @else

        <div class="empty-search">
            <div class="empty-search-icon">
                <i class="fa-regular fa-face-frown"></i>
            </div>

            <h3>Nothing found</h3>
            <p>For query <strong>"{{ $query }}"</strong></p>
            <p class="empty-search-hint">Try changing your search query or go to the home page</p>
            <a href="{{ route('home') }}" class="empty-search-btn">
                <i class="fa-solid fa-house"></i> Home
            </a>
        </div>

    @endif

</div>

@endsection