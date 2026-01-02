@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="disabled" aria-disabled="true">
                &laquo; Prev
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                &laquo; Prev
            </a>
        @endif

        {{-- Page Numbers (sliding window of 3) --}}
        @php
            $currentPage = $paginator->currentPage();
            $lastPage = $paginator->lastPage();
            
            // Calculate the window of 3 pages
            if ($lastPage <= 3) {
                $start = 1;
                $end = $lastPage;
            } else {
                if ($currentPage <= 2) {
                    $start = 1;
                    $end = 3;
                } elseif ($currentPage >= $lastPage - 1) {
                    $start = $lastPage - 2;
                    $end = $lastPage;
                } else {
                    $start = $currentPage - 1;
                    $end = $currentPage + 1;
                }
            }
        @endphp

        @for ($page = $start; $page <= $end; $page++)
            @if ($page == $currentPage)
                <span class="active" aria-current="page">{{ $page }}</span>
            @else
                <a href="{{ $paginator->url($page) }}">{{ $page }}</a>
            @endif
        @endfor

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                Next &raquo;
            </a>
        @else
            <span class="disabled" aria-disabled="true">
                Next &raquo;
            </span>
        @endif
    </nav>
@endif
