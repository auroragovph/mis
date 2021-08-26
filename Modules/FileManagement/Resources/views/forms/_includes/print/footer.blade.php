
<div class="footer btm">

    <div class="footer-logo">
        <img src="{{ asset('media/logos/kumakalinga.png') }}" alt="">
    </div>

    <div class="footer-footnote">
        <p>Aurora, Gobyernong Kumakalinga</p>
        <p>Management Information System</p>

        <span class="pager">Page 1 of 1</span>
    </div>

    <div class="footer-qrcode">
        <img src="{{ qr_to_base64($qrcode) }}" alt="">
        <p>{{ $qrcode }}</p>
    </div>

</div>