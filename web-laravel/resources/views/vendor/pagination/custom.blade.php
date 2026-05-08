@if ($paginator->hasPages())
    <div class="pagination-section">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button class="pagination-btn" disabled aria-disabled="true">
                <i class="fas fa-chevron-left"></i>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="pagination-btn" rel="prev">
                <i class="fas fa-chevron-left"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span class="pagination-info">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button class="pagination-btn active" aria-current="page">{{ $page }}</button>
                    @else
                        <a href="{{ $url }}" class="pagination-btn">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="pagination-btn" rel="next">
                <i class="fas fa-chevron-right"></i>
            </a>
        @else
            <button class="pagination-btn" disabled aria-disabled="true">
                <i class="fas fa-chevron-right"></i>
            </button>
        @endif

        <span class="pagination-info">
            Halaman {{ $paginator->currentPage() }} dari {{ $paginator->lastPage() }}
        </span>
    </div>
@endif
