@if ($paginator->hasPages())
    <nav>
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="paginate_button previous disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link" aria-hidden="true"><i class="fa fa-angle-left"></i></span>
                </li>
            @else
                <li class="paginate_button previous">
                    <a class="page-link" wire:click="previousPage" rel="prev" aria-label="@lang('pagination.previous')"><i class="fa fa-angle-left"></i></a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="paginate_button disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="paginate_button active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                        @else
                            <li class="paginate_button"><a class="page-link" wire:click="gotoPage({{ $page }})">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="paginate_button next">
                    <a class="page-link" wire:click="nextPage" rel="next" aria-label="@lang('pagination.next')"><i class="fa fa-angle-right"></i></a>
                </li>
            @else
                <li class="paginate_button next disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link" aria-hidden="true"><i class="fa fa-angle-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif

@push('styles')
    <style>
        .page-link {
            font-size: 14px !important;
            line-height: 20px !important;
        }
        .pagination {
            margin: 0;
        }
        ul.pagination > .disabled > span {
            opacity: 1 !important;
        }
        .pagination li {
            margin-left: 0;
        }
        .pagination li a {
            cursor: pointer;
        }
    </style>
@endpush