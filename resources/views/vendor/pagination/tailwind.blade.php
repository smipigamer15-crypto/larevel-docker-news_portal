@if ($paginator->hasPages())
    <div class="custom-pagination">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span class="page disabled">« Previous</span>
        @else
            <a class="page" href="{{ $paginator->previousPageUrl() }}">« Previous</a>
        @endif

        {{-- Numbers --}}
        <div class="pages">
            @foreach ($elements as $element)
                @if (is_string($element))
                    <span class="dots">{{ $element }}</span>
                @endif

                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="page active">{{ $page }}</span>
                        @else
                            <a class="page" href="{{ $url }}">{{ $page }}</a>
                        @endif
                    @endforeach
                @endif
            @endforeach
        </div>

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a class="page" href="{{ $paginator->nextPageUrl() }}">Next »</a>
        @else
            <span class="page disabled">Next »</span>
        @endif

    </div>
@endif