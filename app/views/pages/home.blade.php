@extends ('master')

@section ('extra_css')
@stop

@section ('content')
<div class="row">
<div class="col-xs-4 col-xs-offset-4">
    <h1>Welcome to Boxify.</h1>
    <a href="{{ action('login.box') }}" class="btn btn-primary btn-lg">Login with  Box</a>
</div>
</div>
@stop

@section ('extra_js')
@stop
