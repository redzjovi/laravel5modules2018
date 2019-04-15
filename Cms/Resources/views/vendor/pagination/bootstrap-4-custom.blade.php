@if ($paginator->hasPages())
    <div class="float-left">
        @if ($paginator->total() > $paginator->perPage())
            {{ trans('cms::cms.param1_to_param2_of_param3',
                [
                    'from' => ($paginator->currentPage() - 1) * $paginator->perPage() + 1,
                    'to' => ($paginator->currentPage() - 1) * $paginator->perPage() + $paginator->count(),
                    'total' => $paginator->total(),
                ]
            ) }}
        @endif
    </div>
    <div class="float-right">
        <ul class="justify-content-center pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled"><span class="page-link"><i class="fas fa-angle-double-left"></i></span></li>
                <li class="page-item disabled"><span class="page-link"><i class="fas fa-angle-left"></i></span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $paginator->url(1) }}" rel="prev"><i class="fas fa-angle-double-left"></i></a></li>
                <li class="page-item"><a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><i class="fas fa-angle-left"></i></a></li>
            @endif

            @if (! $paginator->onFirstPage() or $paginator->hasMorePages())
                <select class="page-item-select">
                    {{-- Pagination Elements --}}
                    @for ($page = 1; $page <= $paginator->lastPage(); $page++)
                        @if ($page == $paginator->currentPage())
                            <option data-href="{{ $paginator->url($page) }}" selected>{{ $page }}</option>
                        @else
                            <option data-href="{{ $paginator->url($page) }}">{{ $page }}</option>
                        @endif
                    @endfor
                </select>

                <script type="application/javascript">
                    document.querySelectorAll('.page-item-select').forEach(pageItemSelect => {
                        pageItemSelect.addEventListener('change', function() {
                            window.location.href = this.options[this.selectedIndex].getAttribute('data-href');
                        });
                    });
                </script>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item"><a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next"><i class="fas fa-angle-right"></i></a></li>
                <li class="page-item"><a class="page-link" href="{{ $paginator->url($paginator->lastPage()) }}" rel="next"><i class="fas fa-angle-double-right"></i></a></li>
            @else
                <li class="page-item disabled"><span class="page-link"><i class="fas fa-angle-right"></i></span></li>
                <li class="page-item disabled"><span class="page-link"><i class="fas fa-angle-double-right"></i></span></li>
            @endif
        </ul>
    </div>
@endif
