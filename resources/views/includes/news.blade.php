<main class="content-area">

    {{-- Main news --}}
    <section class="hero-news">
      
        <a href="{{ route('news.show', $heroNews->slug) }}" class="hero-card">

            <img src="{{ asset('storage/'.$heroNews->image) }}"
                 alt="{{ $heroNews->title }}">

            <div class="hero-overlay"></div>

            <div class="hero-content">

                <span class="hero-category">
                    {{ $heroNews->category }}
                </span>

                <h1>
                    {{ $heroNews->title }}
                </h1>

                <p>
                    {{ Str::limit($heroNews->content, 120) }}
                </p>

                <div class="hero-meta">

                    <span>
                        <i class="fa-regular fa-clock"></i>
                        {{ $heroNews->created_at->format('d.m.Y H:i') }}
                    </span>

                    <span>
                        <i class="fa-regular fa-eye"></i>
                        {{ $heroNews->views }}
                    </span>

                    <span>
                        <i class="fa-regular fa-heart"></i>
                        {{ $heroNews->likes_count ?? 0 }}
                    </span>

                </div>

            </div>

        </a>
    </section>

    {{-- Popular --}}
    <section class="popular-news">

        <div class="popular-top">

            <h2>POPULAR</h2>

            <div class="popular-filter">
                <a href="#" class="filter-btn active" data-category="all">All</a>

                @foreach($categories as $cat)
                <a href="#" class="filter-btn" data-category="{{ $cat }}">
                    {{ $cat }}
                </a>
                @endforeach
            </div>

        </div>

        <div class="popular-grid">

            @foreach($news as $item)

                <article class="popular-card" data-category="{{ $item->category }}">

                    <a href="{{ route('news.show', $item->slug) }}">

                        <div class="popular-image">

                            <img src="{{ $item->image ? asset('storage/'.$item->image) : asset('images/default.jpg') }}"
                                 alt="{{ $item->title }}">

                            <span class="popular-tag">
                                {{ $item->category }}
                            </span>

                        </div>

                        <div class="popular-body">

                            <h3>
                                {{ $item->title }}
                            </h3>

                            <div class="popular-meta">

                                <span>
                                    <i class="fa-regular fa-clock"></i>
                                    {{ optional($item->created_at)->format('d.m.Y') }}
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

                    </a>

                </article>

            @endforeach

        </div>

    </section>

</main>