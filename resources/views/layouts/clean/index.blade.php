<!doctype html>
<html lang="en">
  <head>

    @include('layouts.partials.meta')

    <title>Sign in - Tabler - Premium and Open Source dashboard template with responsive and high quality UI.</title>
    @include('layouts.partials.styles')

  </head>
  <body  class="d-flex flex-column">

    <div class="page page-center">
      {{ $slot ?? '' }}
    </div>

    @include('layouts.partials.scripts')

  </body>
</html>
