@if ($paginator->hasPages())
    <div style="display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 20px;">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <button disabled
                style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: #f5f5f5; border-radius: 4px; cursor: not-allowed; opacity: 0.5; color: #999; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
            </button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
                style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: white; border-radius: 4px; cursor: pointer; color: #1a4d7d; display: flex; align-items: center; justify-content: center; font-size: 12px; text-decoration: none; transition: all 0.3s;">
                <i class="fas fa-chevron-left" style="font-size: 12px;"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <span style="padding: 0 4px; color: #999; font-size: 12px;">{{ $element }}</span>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <button disabled
                            style="width: 32px; height: 32px; border: 1px solid #0d2640; background: #0d2640; border-radius: 4px; cursor: default; color: white; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 600;">
                            {{ $page }}
                        </button>
                    @else
                        <a href="{{ $url }}"
                            style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: white; border-radius: 4px; cursor: pointer; color: #1a4d7d; display: flex; align-items: center; justify-content: center; font-size: 13px; text-decoration: none; transition: all 0.3s; font-weight: 600;">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
                style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: white; border-radius: 4px; cursor: pointer; color: #1a4d7d; display: flex; align-items: center; justify-content: center; font-size: 12px; text-decoration: none; transition: all 0.3s;">
                <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
            </a>
        @else
            <button disabled
                style="width: 32px; height: 32px; border: 1px solid #e0e0e0; background: #f5f5f5; border-radius: 4px; cursor: not-allowed; opacity: 0.5; color: #999; display: flex; align-items: center; justify-content: center; font-size: 12px;">
                <i class="fas fa-chevron-right" style="font-size: 12px;"></i>
            </button>
        @endif

        {{-- Page Info --}}
        <span style="font-size: 12px; color: #999; margin-left: 10px;">
            Halaman {{ $paginator->currentPage() }} dan {{ $paginator->lastPage() }}
        </span>
    </div>
@endif
