<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aurora MIS | 500 Internal Service Error</title>
    <link rel="stylesheet" href="{{ asset('css/error-page.css') }}">

</head>
<body>
    <main class="bsod container">
        <h1 class="neg title"><span class="bg">Error - 500</span></h1>
        <p>An error has occured, to continue:</p>
        <p>* Return to our homepage.<br />
        * Send us an e-mail about this error and try later.</p>
        <nav class="nav">
          <a href="{{ route('dashboard') }}" class="link">Return Home</a>
        </nav>
      </main>

</body>
</html>