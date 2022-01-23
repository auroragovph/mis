@if ($showPagination)
<div class="card-footer d-flex align-items-center">

    <p class="m-0 text-muted">Showing
        <span>{{ $rows->count() ? $rows->firstItem() : 0 }}</span> to
        <span>{{ $rows->count() ? $rows->lastItem() : 0 }}</span> of
        <span>{{ $rows->total() }}</span> entries
    </p>

    {{ $rows->links('livewire-tables::bootstrap-5.includes.paginator') }}
    {{-- {{ $rows->links() }} --}}
    {{-- @if ($paginationEnabled && $rows->lastPage() > 1)

    @else
    @endif --}}

</div>
@endif

