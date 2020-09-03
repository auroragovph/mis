<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aurora MIS | 404 Not Found</title>
    <link rel="stylesheet" href="{{ asset('css/404.css') }}">
</head>
<body>
    <main class="bsod container">
        <h1 class="neg title"><span class="bg">Error - 404</span></h1>

        <p>The page you requested could not be found. Perharps you are here because:</p>
        <p>
          * The page has moved. <br>
          * The page no longer exists <br>
          * You type an incorect URL. <br>
        </p>

        <p>You can return to home page by clicking the link below:</p>



        <nav class="nav">
          <a href="{{ route('root.home') }}" class="link">Return Home</a>
        </nav>
      </main>

</body>
</html>