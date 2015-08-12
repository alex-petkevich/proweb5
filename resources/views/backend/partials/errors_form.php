@if($field) {!!-- HTML Displayed For a Single Error --!!}

<div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert">×</a>
    <ul class="list-unstyled">
        {!! $errors->first($field, '<li class="error">:message</li>') !!}
    </ul>
</div>

@else {!!-- HTML Displayed For Multiple Errors --!!}

<div class="alert alert-danger">
    <a href="#" class="close" data-dismiss="alert">×</a>
    <ul class="list-unstyled">
        {!! implode('', $errors->all('<li class="error">:message</li>')) !!}
    </ul>
</div>

@endif
