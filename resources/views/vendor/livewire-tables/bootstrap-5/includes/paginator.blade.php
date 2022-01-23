@if ($paginator->hasPages())
    <ul class="pagination m-0 ms-auto">

        {{-- Previous Page Link --}}
        @if (!$paginator->onFirstPage())

        <li class="page-item">
            <button type="button" dusk="previousPage" class="page-link" wire:click="previousPage('page')" wire:loading.attr="disabled" rel="prev">
                <x-ui.icon icon="chevron-left" />

                prev
            </button>
        </li>
        @else

        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled"><button class="page-link">{{ $element }}</button></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li wire:key="paginator-page-1-page-{{ $page }}" class="page-item active" aria-current="page">
                            <button class="page-link">{{ $page }}</button>
                        </li>
                    @else
                        <li wire:key="paginator-page-1-page-{{ $page }}" class="page-item">
                            <button class="page-link" wire:click="gotoPage({{ $page }}, 'page')" >{{ $page }}</button>
                        </li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="page-item">
                <button class="page-link" wire:click="nextPage('page')" wire:loading.attr="disabled" rel="next">
                    next
                    <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                    <x-ui.icon icon="chevron-right" />

                </button>
            </li>
        @endif
    </ul>
@endif
