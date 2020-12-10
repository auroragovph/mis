<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <style>
        *{
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
        }
        table, th, tr, td {
            border: solid 1px black;
            border-collapse: collapse;
            min-width: 100%;
            margin: 0 auto;
        }

        /* td{
            text-align: center;
        } */
    </style>
</head>
<body>
    <table>
        <thead>
            
            <tr>
                <th colspan="2">EMPLOYEE LISTS</th>
               
            </tr>
            <tr>
                <th colspan="1">Name</th>
                <th colspan="1">Office</th>
            </tr>

        </thead>
        <tbody>

            @foreach($employees as $employee)

                <tr>
                    <td>{{ name_helper($employee->name) }}</td>
                    <td>{{ office_helper($employee->division) }}</td>
                </tr>

            @endforeach

        </tbody>
    </table>
</body>
</html>