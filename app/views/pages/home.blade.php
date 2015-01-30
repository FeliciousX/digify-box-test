@extends ('master')

@section ('extra_css')
@stop

@section ('content')
<div class="row">
    <div class="page-header">
        <h1 class="text-info">Welcome to Boxify!
        <small>
            <a href="{{ action('login') }}" class="btn btn-default">Login with  Box</a>
        </small>
        </h1>
    </div>
</div>
@stop

@section ('extra_js')
@stop
