@if ($paginator->hasPages())
<style>
.nusa-pagination { display:flex; align-items:center; gap:4px; list-style:none; margin:0; padding:0; }
.nusa-pagination .page-item .page-link,
.nusa-pagination .page-item span {
    display:inline-flex; align-items:center; justify-content:center;
    min-width:34px; height:34px; padding:0 10px;
    border:1.5px solid #e0e0e0; border-radius:8px;
    font-size:13px; font-weight:600; color:#444;
    background:#fff; text-decoration:none; cursor:pointer;
    transition:all .2s;
}
.nusa-pagination .page-item .page-link:hover { border-color:#D10024; color:#D10024; background:#fff5f5; }
.nusa-pagination .page-item.active span { background:#D10024; border-color:#D10024; color:#fff; }
.nusa-pagination .page-item.disabled span,
.nusa-pagination .page-item.disabled .page-link { color:#ccc; border-color:#f0f0f0; cursor:default; background:#fafafa; }
</style>
<nav>
    <ul class="nusa-pagination">
        @if ($paginator->onFirstPage())
            <li class="page-item disabled"><span>← Sebelumnya</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}">← Sebelumnya</a></li>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <li class="page-item disabled"><span>{{ $element }}</span></li>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><span>{{ $page }}</span></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}">Selanjutnya →</a></li>
        @else
            <li class="page-item disabled"><span>Selanjutnya →</span></li>
        @endif
    </ul>
</nav>
@endif
