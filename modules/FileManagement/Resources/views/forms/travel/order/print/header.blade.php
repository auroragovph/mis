<header>
    <table>
        <tr>

            <td width="20%">
                <img src="logo/{{ get_config('lgu.logo.md') }}" alt="LGU LOGO">
            </td>

            <td width="80%" class="">
                <p class="pretitle">Republic of the Philippines</p>
                <p><strong>{{ strtoupper(get_config('lgu.name')) }}</strong></p>
                <p>{{ strtoupper(get_config('lgu.address.municipality').", ".get_config('lgu.address.province')." ".get_config('lgu.address.code')) }}</p>
            </td>

            <td width="20%">
                &nbsp;
            </td>
        </tr>
        <tr>
            <td colspan="3">
                <h1>TRAVEL ORDER</h1>
            </td>
        </tr>
    </table>
</header>