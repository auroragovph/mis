
<a class="dropdown-item" target="_new" href="{{ route('fms.documents.receipt', $button_doc_id) }}">Print Receipt</a>
<a class="dropdown-item" target="_new" href="{{ route('fms.documents.attach.form', $button_doc_id) }}">Attach Document</a>

<form id="cancelDocumentForm" action="{{ route('fms.documents.cancel.form') }}" method="POST">
    @csrf
    <input type="hidden" name="document" value="{{ $qr ?? null }}">
    <button type="submit" class="dropdown-item"">Cancel Document</button>
</form>

<a class="dropdown-item" target="_new" href="{{ route('fms.documents.track', ['qr' => $qr ?? null]) }}">Track Document</a>


