<li class="navi-item">
    <a target="_new" href="{{ route('fms.documents.receipt', $button_doc_id) }}" class="navi-link">
        <span class="navi-text">
            <i class="flaticon2-copy"></i> Print Receipt
        </span>
    </a>
</li>

<li class="navi-item">
    <a target="_new" href="{{ route('fms.documents.attach.form', $button_doc_id) }}" class="navi-link">
        <span class="navi-text">
            <i class="flaticon2-clip-symbol"></i> Attach Document
        </span>
    </a>
</li>

<li class="navi-item">
    <a href="{{ route('fms.documents.cancel.form', $button_doc_id) }}" class="navi-link">
        <span class="navi-text">
            <i class="flaticon2-cancel"></i> Cancel Document
        </span>
    </a>
</li>