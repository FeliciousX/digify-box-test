@extends ('master')

@section ('content')

@include ('fragments.breadcrumb', array('folder', $folder))

@include ('fragments.message')

<table class="table table-hover">
<caption>
    <div class="dropdown">
    <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
        Action
        <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="#newFolder" data-toggle="modal" data-target="#newFolder">
            New Folder
            </a>
        </li>
        <li role="presentation">
            <a role="menuitem" tabindex="-1" href="#newFile" data-toggle="modal" data-target="#newFile">
            Upload File
            </a>
        </li>
    </ul>
    </div>
</caption>
<thead>
    <th>Type</th>
    <th>Name</th>
</thead>
<tbody id="listFiles">

@foreach ($folder->item_collection->entries as $row)
<tr>
    @if (str_is('file', $row->type))
    <td><span class="glyphicon glyphicon-file text-primary"></span></td>
    <td><a href="{{ route('box.edit', $row->id) }}">{{ $row->name }}</a></td>
    @else
    <td><span class="glyphicon glyphicon-folder-close text-info"></span></td>
    <td><a href="{{ route('box.show', $row->id) }}">{{ $row->name }}</a></td>
    @endif
</tr>
@endforeach

</tbody>
</table>
<p>
    {{ var_dump(Session::get('token')) }}
</p>
<p>
    {{ var_dump(Session::get('redirect')) }}
</p>

@include ('modal.new_folder', array('parent' => $folder))
@include ('modal.new_file', array('parent' => $folder))
@stop

@section ('extra_js')
@stop
