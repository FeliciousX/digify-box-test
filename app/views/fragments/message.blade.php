@if (Session::has('success'))
<div class="alert alert-success" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
{{ Session::pull('success') }}
</div>
@endif

@if (Session::has('info'))
<div class="alert alert-info" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
{{ Session::pull('info') }}
</div>
@endif

@if (Session::has('warning'))
<div class="alert alert-warning" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
{{ Session::pull('warning') }}
</div>
@endif

@if (Session::has('error'))
<div class="alert alert-danger" role="alert">
<button type="button" class="close" data-dismiss="alert" aria-label="Close">
    <span aria-hidden="true">&times;</span>
</button>
{{ Session::pull('error') }}
</div>
@endif

