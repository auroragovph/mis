@if($pr->document->status !== config('constants.document.status.cancelled.id'))
<a href="{{ route('fms.procurement.request.edit', $pr->id) }}" class="btn btn-warning btn-sm">
    <i class="fas fa-edit"></i>
    Edit
</a>
@endif

<a href="{{ route('fms.procurement.request.show', $pr->id) }}?print=1" class="btn btn-default btn-sm">
    <i class="fas fa-print"></i>
    Print
</a>