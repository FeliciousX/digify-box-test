<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Box Integration Test</title>

    @include ('fragments.css')

    @section ('extra_css')
    @show

</head>
<body>

@include ('fragments.navbar')

<div class="container">
    @yield ('content')
</div>

@include ('fragments.js')
@section ('extra_js')
@show

</body>
</html>

