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

                <div class="news-body">
                    <h3>
                        <a href="{{ route('news.show', $item->slug) }}">
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

                        <span>
                            <i class="fa-regular fa-heart"></i>
                            {{ $item->likes_count ?? 0 }}
                        </span>
                    </div>
                </div>

            </article>
            @endforeach

        </div>

        @if(isset($news) && method_exists($news, 'links'))
            <div style="display: flex; justify-content: center; margin-top: 50px; padding: 20px 0; width: 100%;">
                <nav style="display: flex; justify-content: center; width: 100%;">
                    <ul style="display: flex; gap: 8px; list-style: none; padding: 0; margin: 0; align-items: center; flex-wrap: wrap; justify-content: center;">
                        
                        {{-- Previous --}}
                        @if ($news->onFirstPage())
                            <li>
                                <span style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: #f0f0f0; color: #bbb; border-radius: 10px; border: 1px solid #e5e5e5; font-size: 14px; font-weight: 500; cursor: not-allowed; user-select: none; opacity: 0.6;">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                    Previous
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $news->previousPageUrl() }}" 
                                   style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: #ffffff; color: #333; border-radius: 10px; border: 1px solid #e5e5e5; font-size: 14px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; cursor: pointer;"
                                   onmouseover="this.style.background='#e30613'; this.style.color='#ffffff'; this.style.borderColor='#e30613'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(227,6,19,0.25)';"
                                   onmouseout="this.style.background='#ffffff'; this.style.color='#333'; this.style.borderColor='#e5e5e5'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="15 18 9 12 15 6"></polyline></svg>
                                    Previous
                                </a>
                            </li>
                        @endif

                        {{-- Pages --}}
                        @php
                            $currentPage = $news->currentPage();
                            $lastPage = $news->lastPage();
                            $start = max(1, $currentPage - 2);
                            $end = min($lastPage, $currentPage + 2);
                            
                            if ($end - $start < 4) {
                                if ($start > 1) {
                                    $start = max(1, $end - 4);
                                }
                                if ($end < $lastPage) {
                                    $end = min($lastPage, $start + 4);
                                }
                            }
                        @endphp
                        
                        @if ($start > 1)
                            <li>
                                <a href="{{ $news->url(1) }}" 
                                   style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; background: #ffffff; color: #333; border-radius: 10px; border: 1px solid #e5e5e5; font-size: 14px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; cursor: pointer;"
                                   onmouseover="this.style.background='#e30613'; this.style.color='#ffffff'; this.style.borderColor='#e30613'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(227,6,19,0.25)';"
                                   onmouseout="this.style.background='#ffffff'; this.style.color='#333'; this.style.borderColor='#e5e5e5'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">1</a>
                            </li>
                            @if ($start > 2)
                                <li><span style="display: inline-flex; align-items: center; justify-content: center; min-width: 30px; height: 40px; color: #999; font-size: 14px;">…</span></li>
                            @endif
                        @endif
                        
                        @for ($i = $start; $i <= $end; $i++)
                            @if ($i == $currentPage)
                                <li>
                                    <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; background: #e30613; color: #ffffff; border-radius: 10px; border: 1px solid #e30613; font-size: 14px; font-weight: 600; box-shadow: 0 4px 15px rgba(227,6,19,0.3);">{{ $i }}</span>
                                </li>
                            @else
                                <li>
                                    <a href="{{ $news->url($i) }}" 
                                       style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; background: #ffffff; color: #333; border-radius: 10px; border: 1px solid #e5e5e5; font-size: 14px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; cursor: pointer;"
                                       onmouseover="this.style.background='#e30613'; this.style.color='#ffffff'; this.style.borderColor='#e30613'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(227,6,19,0.25)';"
                                       onmouseout="this.style.background='#ffffff'; this.style.color='#333'; this.style.borderColor='#e5e5e5'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">{{ $i }}</a>
                                </li>
                            @endif
                        @endfor
                        
                        @if ($end < $lastPage)
                            @if ($end < $lastPage - 1)
                                <li><span style="display: inline-flex; align-items: center; justify-content; center; min-width: 30px; height: 40px; color: #999; font-size: 14px;">…</span></li>
                            @endif
                            <li>
                                <a href="{{ $news->url($lastPage) }}" 
                                   style="display: inline-flex; align-items: center; justify-content: center; min-width: 40px; height: 40px; background: #ffffff; color: #333; border-radius: 10px; border: 1px solid #e5e5e5; font-size: 14px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; cursor: pointer;"
                                   onmouseover="this.style.background='#e30613'; this.style.color='#ffffff'; this.style.borderColor='#e30613'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(227,6,19,0.25)';"
                                   onmouseout="this.style.background='#ffffff'; this.style.color='#333'; this.style.borderColor='#e5e5e5'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">{{ $lastPage }}</a>
                            </li>
                        @endif

                        {{-- Next --}}
                        @if ($news->hasMorePages())
                            <li>
                                <a href="{{ $news->nextPageUrl() }}" 
                                   style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: #ffffff; color: #333; border-radius: 10px; border: 1px solid #e5e5e5; font-size: 14px; font-weight: 500; text-decoration: none; transition: all 0.3s ease; cursor: pointer;"
                                   onmouseover="this.style.background='#e30613'; this.style.color='#ffffff'; this.style.borderColor='#e30613'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(227,6,19,0.25)';"
                                   onmouseout="this.style.background='#ffffff'; this.style.color='#333'; this.style.borderColor='#e5e5e5'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                                    Next
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </a>
                            </li>
                        @else
                            <li>
                                <span style="display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; background: #f0f0f0; color: #bbb; border-radius: 10px; border: 1px solid #e5e5e5; font-size: 14px; font-weight: 500; cursor: not-allowed; user-select: none; opacity: 0.6;">
                                    Next
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        @endif

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