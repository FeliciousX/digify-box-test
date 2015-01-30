@extends ('master')

@section ('extra_css')
@stop

@section ('content')

{{--- TODO: @feliciousx add breadcrumbs ---}}

@include ('fragments.message')

<table class="table table-hover">
<thead>
    <th>Type</th>
    <th>Name</th>
</thead>
<tbody id="listFiles">
@foreach ($files->entries as $row)
<tr>
<td>{{ $row->type }}</td>
<td><a href="{{ route('box.show', [$row->id, 'type' => $row->type]) }}">{{ $row->name }}</a></td>
</tr>
@endforeach
</tbody>
</table>
{{ var_dump(Session::get('token')) }}
@stop

@section ('extra_js')
@stop
