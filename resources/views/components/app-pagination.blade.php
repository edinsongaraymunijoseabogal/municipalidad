<div>
    @if ($paginator->hasPages())
        <nav class="app-pagination mt-4">
            <ul class="pagination justify-content-center">
                {{-- Previous Page Link --}}
                @if ($paginator->onFirstPage())
                    <li class="page-item disabled">
                        <span class="page-link">@lang('pagination.previous')</span>
                    </li>
                @else
                    <li class="page-item">
                        <button type="button" class="page-link"
                            wire:click="previousPage('{{ $paginator->getPageName() }}')">
                            @lang('pagination.previous')
                        </button>
                    </li>
                @endif

                {{-- Pagination Elements --}}
                @foreach ($elements as $element)
                    {{-- "Three Dots" Separator --}}
                    @if (is_string($element))
                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                    @endif

                    {{-- Array Of Links --}}
                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            @if ($page == $paginator->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                            @else
                                <li class="page-item">
                                    <button type="button" class="page-link"
                                        wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')">
                                        {{ $page }}
                                    </button>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Page Link --}}
                @if ($paginator->hasMorePages())
                    <li class="page-item">
                        <button type="button" class="page-link"
                            wire:click="nextPage('{{ $paginator->getPageName() }}')">
                            @lang('pagination.next')
                        </button>
                    </li>
                @else
                    <li class="page-item disabled">
                        <span class="page-link">@lang('pagination.next')</span>
                    </li>
                @endif
            </ul>
        </nav>
    @endif
</div>
