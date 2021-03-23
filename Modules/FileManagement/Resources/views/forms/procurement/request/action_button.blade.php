<div class="dropdown">
    <button class="btn bg-navy dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

        <h6 class="dropdown-header">Actions:</h6>

        @include('filemanagement::documents.general_action_button', ['button_doc_id' => $pr->document_id])

        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="{{ route('fms.procurement.request.edit', $pr->id) }}">Edit Document</a>
        <a class="dropdown-item" href="{{ route('fms.procurement.request.print', $pr->id) }}">Print Document</a>

        @if($pr->document->purchase_order == null)
            <a class="dropdown-item" href="{{ route('fms.procurement.order.create', ['document' => $pr->document_id]) }}">Convert into PO</a>     
        @else 
            <a class="dropdown-item" href="{{route('fms.procurement.order.show', $pr->document->purchase_order->id) }}">Show Purchase Order</a>
        @endif



    </div>
</div>