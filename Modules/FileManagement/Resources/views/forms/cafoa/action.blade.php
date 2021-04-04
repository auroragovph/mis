<div class="dropdown">
    <button class="btn bg-navy dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Actions
    </button>
    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">

        <h6 class="dropdown-header">Actions:</h6>

        @include('filemanagement::documents.general_action_button', [
            'button_doc_id' => $cafoa->document_id,
            'qr' => $cafoa->document->qr
        ])

        <div class="dropdown-divider"></div>

        <a class="dropdown-item" href="{{ route('fms.cafoa.edit', $cafoa->id) }}">Edit Document</a>
        <a class="dropdown-item" href="{{ route('fms.cafoa.print', $cafoa->id) }}">Print Document</a>

        

    </div>
</div>