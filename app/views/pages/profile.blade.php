@extends ('master')

@section ('extra_css')
@stop

@section ('content')

@include ('fragments.message')

<table class="table table-hover">
<thead>
    <th>Type</th>
    <th>Name</th>
</thead>
<tbody id="listFiles">
</tbody>
</table>

{{ Form::hidden('list_url', route('box.index')) }}
@stop

@section ('extra_js')
<script type="text/javascript">
$(function(){
    $.ajax('http://localhost/box').done(function($data) {
        // loops through the item collection 
        $.each($data, function($key, $value) {
            $row = $('<tr>');
            $tdata1 = $('<td>'+$value['type']+'</td>');
            $tdata2 = $('<td>'+$value['name']+'</td>');

            $row.append($tdata1);
            $row.append($tdata2);
            $('#listFiles').append($row);
            
        });
    });
});</script>
@stop
