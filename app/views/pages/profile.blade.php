@extends ('master')

@section ('extra_css')
@stop

@section ('content')

@include ('fragments.message')

<table class="table table-hover">
    <th>Type</th>
    <th>Name</th>
</table>

{{ Form::hidden('list_url', route('box.index')) }}
@stop

@section ('extra_js')
<script type="text/javascript">
$(function(){
    list_url = $('input[name=list_url]').val();
    $.ajax({
        type: "GET",
        url: list_url
    })
    .done(function($data) {
        console.log($data);
    });
});
</script>
@stop
