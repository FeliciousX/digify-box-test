@extends ('master')

@section ('extra_css')
@stop

@section ('content')

@include ('fragments.message')

<h2>Hello {{ Auth::user()->username }}</h2>
<p>Welcome to your profile page.</p>
@stop

@section ('extra_js')
@stop
