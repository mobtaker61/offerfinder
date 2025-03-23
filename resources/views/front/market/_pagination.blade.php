@if ($offers->hasPages())
<div class="d-flex justify-content-center mt-4">
    <nav aria-label="Offers navigation">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($offers->onFirstPage())
                <li class="page-item disabled">
                    <span class="page-link">Previous</span>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $offers->previousPageUrl() }}" rel="prev">Previous</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($offers->getUrlRange(1, $offers->lastPage()) as $page => $url)
                @if ($page == $offers->currentPage())
                    <li class="page-item active">
                        <span class="page-link">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    </li>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($offers->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $offers->nextPageUrl() }}" rel="next">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <span class="page-link">Next</span>
                </li>
            @endif
        </ul>
    </nav>
</div>
@endif 