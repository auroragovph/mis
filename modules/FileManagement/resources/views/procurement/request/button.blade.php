@if($pr->series->status !== \DocumentStatusEnum::CANCELLED->value)
<a href="{{ route('fms.procurement.request.edit', $pr->id) }}" class="btn btn-warning btn-sm">
    <x-ui.icon icon="pencil" />
    Edit
</a>
@endif

<a href="{{ route('fms.procurement.request.show', $pr->id) }}?print=1" class="btn btn-default btn-sm">
    <x-ui.icon icon="printer" class="text-muted" />
    Print
</a>
