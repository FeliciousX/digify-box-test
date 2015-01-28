<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Box Integration Test</title>
    @include('fragments.css')
    @section('extra_css')
    @show
</head>
<body>
<div class="container">
<h1>Hi there</h1>
@yield ('content')
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
@section ('extra_js')
@show
</body>
</html>

