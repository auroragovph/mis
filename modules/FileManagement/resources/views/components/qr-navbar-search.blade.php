<form action="{{ route('fms.document.track') }}" method="get">
    <div class="input-icon">
        <span class="input-icon-addon">
            <!-- Download SVG icon from http://tabler-icons.io/i/search -->
            <x-ui.icon icon="search" />
        </span>
        <input type="text" class="form-control" name="qrcode" placeholder="Search…"
            aria-label="Search in website">
    </div>
</form>
