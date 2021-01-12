<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        

*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
}
body{
    font-family: 'Arial', sans-serif;
}
.page-border{
    border: 2px solid black;
}

table{
    width: 100%;
    border-collapse: collapse;
}

td,th {
    vertical-align: baseline;
}

.pl-3{
    padding-left: 10px;
}

.ml-3{
    margin-left: 10px;
}

.text-right{
    text-align: right;
}

.text-center{
    text-align: center;
}

.center{
    text-align: center;
    vertical-align: middle;
}

.btm{
    border-top: 2px solid black;
}

.bbm{
    border-bottom: 2px solid black;
}

.blm{
    border-left: 2px solid black;
}

.brm{
    border-right: 2px solid black;
}

.bt{
    border-top: 1px solid black;
}

.bb{
    border-bottom: 1px solid black;
}

.bl{
    border-left: 1px solid black;
}

.br{
    border-right: 1px solid black;
}

.rep{
    font-size: 12px;
}

.pro{
    font-size: 12px;
    margin-top: -5px;
}

h3{
    font-size: 20px;
}

.footer-page p{
    font-size: 10px;
}
    </style>
</head>
<body>
    <table class="btm blm brm">

        <thead>

            <tr>
                <th colspan="6">PURCHASE REQUEST</th>
            </tr>

            <tr class="bt bb">
                <th class="br">ROW1</th>
                <th class="br">ROW2</th>
                <th class="br">ROW3</th>
                <th class="br">ROW4</th>
                <th class="br">ROW5</th>
                <th>ROW6</th>
            </tr>
        </thead>

        <tbody>
            <tr class="bt bb">
                <td class="br">ROW1</td>
                <td class="br">ROW2</td>
                <td class="br">ROW3</td>
                <td class="br">ROW4</td>
                <td class="br">ROW5</td>
                <td>ROW6</td>
            </tr>

        </tbody>
        <tfoot>
            <tr class="bbm">
                <th colspan="6">PURCHASE REQUEST</th>
            </tr>
        </tfoot>
    </table>
</body>
</html>