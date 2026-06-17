@extends('layouts.main')

@section('header-title')
News
@endsection

@section('content')

<div class="category-page">

    <h1 class="category-title">
        <i class="fa-regular fa-newspaper"></i>
        All news
    </h1>

    <p class="category-subtitle">
        The latest and most relevant news from all categories
    </p>

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

     <div class="pagination-wrapper">
        {{ $news->links() }}
    </div>

</div>

@endsection