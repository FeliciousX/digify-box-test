@extends ('master')

@section ('extra_css')
@stop

@section ('content')
<div class="row">
    <div class="col-xs-12">
        {{ Form::open() }}
        @include ('fragments.message')
        <div class="form-group">
            <input name="user[username]" type="username" class="form-control" id="username" placeholder="Username" required>
        </div>
        <div class="form-group">
            <input name="user[password]" type="password" class="form-control" id="password" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
        {{ Form::close() }}
    </div><!-- /.col-xs-12 -->
</div><!-- /.row -->
@stop

@section ('extra_js')
@stop

