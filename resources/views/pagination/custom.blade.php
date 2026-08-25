@if ($paginator->hasPages())
    <nav
        role="navigation"
        aria-label="Pagination Navigation"
    >
        @if ($paginator->onFirstPage())
            <span>
                &laquo; Trước
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}">
                &laquo; Trước
            </a>
        @endif

        @foreach (
            $paginator->getUrlRange(
                max(1, $paginator->currentPage() - 2),
                min($paginator->lastPage(), $paginator->currentPage() + 2)
            ) as $page => $url
        )
            @if ($page == $paginator->currentPage())
                <span aria-current="page">
                    <span>{{ $page }}</span>
                </span>
            @else
                <a href="{{ $url }}">
                    {{ $page }}
                </a>
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}">
                Sau &raquo;
            </a>
        @else
            <span>
                Sau &raquo;
            </span>
        @endif
    </nav>
@endif