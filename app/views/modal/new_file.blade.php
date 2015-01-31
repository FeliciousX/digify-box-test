<div class="modal fade" id="newFile" tabindex="-1" role="dialog" aria-labelledby="newFileTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="newFileTitle">Upload File</h4>
            </div><!-- /.modal-header -->
            {{ Form::open(['route' => ['photo.store'], 'files' => true]) }}
            {{ Form::hidden('parentId', $parent->id) }}
            <div class="modal-body">
                <div class="form-group">
                    {{ Form::label('fileName', 'Name') }}
                    {{ Form::text('fileName', NULL, ['class' => 'form-control', 'id' => 'fileName', 'placeholder' => 'File Name']) }}
                </div>
                <div class="form-group">
                    {{ Form::label('fileInput', 'File Input') }}
                    {{ Form::file('fileInput') }}
                    <p class="help-block">Choose file to upload.</p>
                </div>
            </div><!-- /.modal-body -->
            <div class="modal-footer">
                <a href="#" class="btn btn-default" data-dismiss="modal">Close</a>
                <button type="submit" class="btn btn-primary" >Upload</button>
            </div><!-- /.modal-footer -->
            {{ Form::close() }}
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /#newFile -->

