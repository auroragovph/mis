<footer>
    <table>
        <tr>

            <td width="20%">
                <img class="banner" src="{{ get_config('lgu.logo.banner') }}" alt="LGU BANNER">
            </td>

            <td width="80%" class="">
                <p><em>{{ get_config('lgu.slogan') }}</em></p>
                <p>Management Information System</p>
            </td>

            <td width="20%">
                @isset($qrcode)
                    <img class="qrcode-image" src="{{ qr_to_base64($qrcode) }}" alt="QR Code">
                    <p class="qrcode-label">{{ $qrcode }}</p>
                @endisset
            </td>
        </tr>
    </table>
</footer>