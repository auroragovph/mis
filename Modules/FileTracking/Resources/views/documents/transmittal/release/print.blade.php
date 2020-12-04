<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Transmittal Report</title>
    <style>
        table{
            width: 100%;
        }
    </style>
</head>
<body>
    <table>
        <thead>
            <tr>
                <td><img src="{{ asset('images/logo-sm.png') }}" alt="" width="100px" height="100px"></td>
                <td>
                    TRANSMITTAL REPORT
                </td>
                <td>
                    <img width="75" height="75" src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(500)->generate('caddd264-6c1c-4d90-b391-6254e51d7733')) !!}" alt="" class="symbol-label">
                </td>
            </tr>
        </thead>
    </table>
</body>
</html>