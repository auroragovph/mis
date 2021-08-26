<button class="btn btn-default btn-sm">
    
    Receipt
</button>

<a href="{{ route('fms.documents.cancel.form', ['qrcode' => $qrcode, 'referer' => url()->current()]) }}"
    class="btn btn-default btn-sm"> Cancel</a>

    

<a href="{{ route('fms.documents.track', ['qrcode' => $qrcode]) }}" target="_blank" class="btn btn-default btn-sm">
    
    Track
</a>
