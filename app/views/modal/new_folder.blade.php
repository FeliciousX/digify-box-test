<div class="modal fade" id="newFolder" tabindex="-1" role="dialog" aria-labelledby="newFolderTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newFolderTitle">New Folder</h4>
            </div><!-- /.modal-header -->
            {{ Form::open(['method' => 'POST', 'route' => ['box.store']]) }}
            {{ Form::hidden('parentId', $parent->id) }}
            <div class="modal-body">
                <div class="form-group">
                    {{ Form::label('folderName', 'Name') }}
                    {{ Form::text('folderName', NULL, ['class' => 'form-control', 'id' => 'folderName', 'placeholder' => 'Folder Name']) }}
                </div>
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-primary">Create</button>
            </div><!-- /.modal-footer -->
            {{ Form::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /#newFolder -->
