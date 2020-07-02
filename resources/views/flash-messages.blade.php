@if ($message = Session::get('message'))
<div class="alert alert-{{Session::get('alert-class', 'info')}} alert-block">
    <button type="button" class="close"
     data-dismiss="alert">×</button>    
    <strong>{{ $message }}</strong>
</div>
@endif

@if ($errors->any())
    @foreach ($errors->all() as $error)
    <div class="alert alert-danger alert-block">
        <button type="button" class="close"
        data-dismiss="alert">×</button>    
        <strong>{{ $error }}</strong>
    </div>
    @endforeach
@endif
 