<div class="flex justify-between border-t-2 border-black" style="height: 7%;">

    <div class="flex items-center justify-center w-1/4">
        <img class="w-16 h-12" src="{{ asset('media/logos/kumakalinga.png') }}" alt="">
    </div>

    <div class="w-2/4 text-center items-center justify-center">
        <p class="text-xs mt-2">{{ get_config('lgu.slogan') }}</p>
        <p class="text-xs">Management Information System</p>
        <span class="pager text-sm">Page 1 of 1</span>
    </div>

    <div class="w-1/4 flex flex-col text-center">
        @isset($qrcode)
            <img class="w-12 h-12 mx-auto" src="{{ qr_to_base64($qrcode) }}" alt="QR Code">
            <p>{{ $qrcode }}</p>
        @endisset
    </div>

</div>
