@if ($showSearch)

    <div class="mb-3">
        <div class="input-group input-group-flat">
            <input class="form-control" autocomplete="off" wire:model{{ $this->searchFilterOptions }}="filters.search" placeholder="{{ __('Search') }}" type="text">
            @if (isset($filters['search']) && strlen($filters['search']))
            <span class="input-group-text">
                <a wire:click="$set('filters.search', null)" class="link-secondary" title="" data-bs-toggle="tooltip" data-bs-original-title="Clear search">
                    <!-- Download SVG icon from http://tabler-icons.io/i/x -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </a>
            </span>
            @endif
        </div>
    </div>
@endif
