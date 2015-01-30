<ol class="breadcrumb">
    @foreach ($folder->path_collection->entries as $parent)
    <li>
        <a href="{{ route('box.show', $parent->id) }}">{{ $parent->name }}</a>
    </li>
    @endforeach
    <li class="active">{{ $folder->name }}</li>
</ol>

