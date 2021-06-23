{{-- <div class="dropdown">
    <button class="btn bg-navy dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

        <h6 class="dropdown-header">Actions:</h6>

        @include('filemanagement::documents.general_action_button', [
            'button_doc_id' => $to->document_id,
            'qr' => $to->document->qr
        ])

        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="{{ route('fms.travel.order.edit', $to->id) }}">Edit Document</a>
        <a class="dropdown-item" href="{{ route('fms.travel.order.print', $to->id) }}">Print Document</a>

        

    </div>
</div> --}}

<a href="{{ route('fms.travel.order.edit', $to->id) }}" class="btn btn-warning btn-sm"><i class="fas fa-edit"></i> Edit</a>
<a href="{{ route('fms.travel.order.show', $to->id) }}?print=1" class="btn btn-default btn-sm"><i class="fas fa-print"></i> Print</a>