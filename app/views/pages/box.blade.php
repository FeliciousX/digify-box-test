@extends ('master')

@section ('extra_css')
@stop

@section ('content')

<ol class="breadcrumb">
    @foreach ($folder->path_collection->entries as $parent)
    <li>
        <a href="{{ route('box.show', [$parent->id, 'type' => $parent->type]) }}">{{ $parent->name }}</a>
    </li>
    @endforeach
    <li class="active">{{ $folder->name }}</li>
</ol>

@include ('fragments.message')

<table class="table table-hover">
<thead>
    <th>Type</th>
    <th>Name</th>
</thead>
<tbody id="listFiles">
@foreach ($folder->item_collection->entries as $row)
<tr>
<td>
    @if (str_is('file', $row->type))
    <span class="glyphicon glyphicon-file text-muted"></span>
    @else
    <span class="glyphicon glyphicon-folder-close text-muted"></span>
    @endif
</td>
<td><a href="{{ route('box.show', [$row->id, 'type' => $row->type]) }}">{{ $row->name }}</a></td>
</tr>
@endforeach
</tbody>
</table>
<p>
    {{ var_dump($folder->path_collection) }}
</p>
<p>
    {{ var_dump(Session::get('token')) }}
</p>
<p>
    {{ var_dump(Session::get('redirect')) }}
</p>
@stop

@section ('extra_js')
@stop
