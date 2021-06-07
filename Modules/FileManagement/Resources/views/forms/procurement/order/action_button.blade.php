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

        <a class="dropdown-item" href="{{ route('fms.procurement.order.show',[
            'id' => $po->id,
            'print' => true
        ]) }}">Print Document</a>

        @php
            $pr = $po->document->forms->where('formable_type', 'Purchase Request')->first();
            $pr = $pr->formable;
        @endphp

        <a class="dropdown-item" href="{{route('fms.procurement.request.show', $pr->id) }}">Show Purchase Request</a>

        <div class="dropdown-divider"></div>

        @php($attached_forms = $po->document->forms->pluck('formable_type')->toArray())

        @if(in_array('CAFOA', $attached_forms))

            <?php
                $cafoa = $po->document->forms->where('formable_type', 'CAFOA')->first();
                $cafoa = $cafoa->formable;
            ?>


            <a class="dropdown-item" target="_new" href="{{ route('fms.cafoa.show', $cafoa->id) }}">Show CAFOA</a>

        @else 
                <a class="dropdown-item" href="{{ route('fms.cafoa.create', [
                    'attachment' => true,
                    'document_id' => $po->document_id,
                    'qr' => $po->document->qr,
                    'token' => csrf_token(),
                    'header' => 'Attach CAFOA for Procurement'
                ]) }}">Attach CAFOA</a>
        @endif

    </div>
</div>