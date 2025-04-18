<div class="d-flex justify-content-between">
    {{-- Informasi Jumlah Data --}}
    <div class="data-info text-center mt-2">
        <p class="text-gray">
            Showing 
            <strong>{{ $paginator->firstItem() }}</strong> 
            to 
            <strong>{{ $paginator->lastItem() }}</strong> 
            of 
            <strong>{{ $paginator->total() }}</strong> 
            entries
        </p>
    </div>

    {{-- Navigasi Paginasi dengan Panah --}}
    <div class="pagination-container">
        <ul class="pagination">
            {{-- Panah Kiri --}}
            @if (!$paginator->onFirstPage())
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" aria-label="Previous">
                        &laquo;
                    </a>
                </li>
            @else
                <li class="disabled"><span>&laquo;</span></li>
            @endif

            {{-- Nomor Halaman --}}
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @if ($i == $paginator->currentPage())
                    <li class="active"><span>{{ $i }}</span></li>
                @else
                    <li><a href="{{ $paginator->url($i) }}">{{ $i }}</a></li>
                @endif
            @endfor

            {{-- Panah Kanan --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" aria-label="Next">
                        &raquo;
                    </a>
                </li>
            @else
                <li class="disabled"><span>&raquo;</span></li>
            @endif
        </ul>
    </div>
</div>
