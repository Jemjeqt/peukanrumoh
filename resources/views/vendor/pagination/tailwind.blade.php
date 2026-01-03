@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; justify-content: center; margin-top: 1.5rem;">
        <ul style="display: flex; list-style: none; padding: 0; margin: 0; gap: 0.5rem; align-items: center;">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 0.75rem; font-size: 13px; border-radius: 6px; border: 1px solid #e0e0e0; color: #999; background: #f5f5f5; cursor: not-allowed;">
                        « Previous
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 0.75rem; font-size: 13px; text-decoration: none; border-radius: 6px; border: 1px solid #e0e0e0; color: #666; background: white; transition: all 0.2s;">
                        « Previous
                    </a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 0.5rem; font-size: 13px; color: #666;">{{ $element }}</span>
                    </li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 0.5rem; font-size: 13px; border-radius: 6px; border: 1px solid #2E7D32; color: white; background: #2E7D32; font-weight: 600;">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}" style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 0.5rem; font-size: 13px; text-decoration: none; border-radius: 6px; border: 1px solid #e0e0e0; color: #666; background: white; transition: all 0.2s;">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 0.75rem; font-size: 13px; text-decoration: none; border-radius: 6px; border: 1px solid #e0e0e0; color: #666; background: white; transition: all 0.2s;">
                        Next »
                    </a>
                </li>
            @else
                <li>
                    <span style="display: inline-flex; align-items: center; justify-content: center; min-width: 36px; height: 36px; padding: 0 0.75rem; font-size: 13px; border-radius: 6px; border: 1px solid #e0e0e0; color: #999; background: #f5f5f5; cursor: not-allowed;">
                        Next »
                    </span>
                </li>
            @endif
        </ul>
    </nav>
@endif
