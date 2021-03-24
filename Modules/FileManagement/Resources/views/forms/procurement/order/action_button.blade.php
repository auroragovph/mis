<div class="dropdown">
    <button class="btn bg-navy dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

        <h6 class="dropdown-header">Actions:</h6>

        @include('filemanagement::documents.general_action_button', [
            'button_doc_id' => $po->document_id,
            'qr' => $po->document->qr
        ])

        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="{{ route('fms.procurement.order.edit', $po->id) }}">Edit Document</a>
        <a class="dropdown-item" href="{{ route('fms.procurement.order.print', $po->id) }}">Print Document</a>

        <a class="dropdown-item" href="{{route('fms.procurement.request.show', $po->document->purchase_request->id) }}">Show Purchase Request</a>

        <div class="dropdown-divider"></div>

        @if($po->document->type == config('constants.document.type.procurement.order'))
            <a class="dropdown-item" href="{{ route('fms.procurement.cafoa.create', [
                'document' => $po->document_id
            ]) }}">Attach CAFOA</a>
        @endif

        @if($po->document->type == config('constants.document.type.procurement.cafoa'))
            <a class="dropdown-item" target="_new" href="{{ route('fms.procurement.cafoa.show', $po->document->cafoa->id) }}">Show CAFOA</a>
        @endif



    </div>
</div>