<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Chart Examples</title>
    {!! Charts::styles() !!}
  </head>
  <body>

    <div class="app">
      {!! $chart3->html() !!}
      <br>

      {!! $chart4->html() !!}
      <br>
      {!! $chart5->html() !!}
    </div>




<!--Scripts oes here-->
    {!! Charts::scripts() !!}
    {!! $chart3->script() !!}
    {!! $chart4->script() !!}
    {!! $chart5->script() !!}
  </body>
</html>
