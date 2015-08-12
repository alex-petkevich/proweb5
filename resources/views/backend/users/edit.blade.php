@extends('backend.layout')

@section('main')
@if ($errors->any())
	<ul class="alert alert-warning error-list">
		{!! implode('', $errors->all('<li class="error">:message</li>')) !!}
	</ul>
@endif

<div class="col-xs-5">
@if (!$user->id)
<h1 class="page-header">{!! trans('users.create_user') !!}</h1>
{!! Form::open(array('route' => 'users.store', 'role' => 'form')) !!}
@else
<h1 class="page-header">{!! trans('users.edit_user') !!}</h1>
{!! Form::model($user, array('method' => 'PATCH', 'route' => array('users.update', $user->id), 'role' => 'form')) !!}
@endif
@if ($user->id)
    <div class="form-group">
      {!! Form::label('created', trans('users.created'), array('class' => 'control-label')) !!}
      {!! Form::text('created_at', $user->created_at, array('disabled'=>1,'class' => 'form-control')) !!}
    </div>
    <div class="form-group">
      {!! Form::label('updated', trans('users.updated'), array('class' => 'control-label')) !!}
      {!! Form::text('updated_at', $user->updated_at, array('disabled'=>1,'class' => 'form-control')) !!}
    </div>
@endif

    <div class="form-group @if ($errors->has('username')) has-error has-feedback @endif">
      {!! Form::label('username', trans('users.username'), array('class' => 'control-label')) !!}
      {!! Form::text('username', $user->username, array('disabled'=>$user->id,'class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('email')) has-error has-feedback @endif">
      {!! Form::label('email', trans('users.email'), array('class' => 'control-label')) !!}
      {!! Form::text('email', $user->email, array('disabled'=>$user->id,'class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('password')) has-error has-feedback @endif">
      {!! Form::label('password', trans('login.password'), array('class' => 'control-label')) !!}
      {!! Form::password('password',array('class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('roles')) has-error has-feedback @endif">
      {!! Form::label('roles', trans('users.roles'), array('class' => 'control-label')) !!}
      {!! Form::text('roles', Input::old('roles', implode(', ', array_fetch($user->roles()->get(array('role'))->toArray(), 'role'))),array('class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('active')) has-error has-feedback @endif">
      {!! Form::label('active', trans('users.active'), array('class' => 'control-label')) !!}
      {!! Form::checkbox('active','1',array('class' => 'form-control')) !!}
    </div>

        <div class="form-group">
      {!! Form::submit(trans('users.update'), array('class' => 'btn btn-info')) !!}
      {!! link_to_route('users.index', trans('users.cancel'), $user->id, array('class' => 'btn btn-default')) !!}
        </div>
{!! Form::close() !!}
</div>
@stop

@section('scripts')
<script>
   $(document).ready(function(){
      function split( val ) {
         return val.split( /,\s*/ );
      }
      function extractLast( term ) {
         return split( term ).pop();
      }

      $( "#roles" )
         // don't navigate away from the field on tab when selecting an item
         .bind( "keydown", function( event ) {
            if ( event.keyCode === $.ui.keyCode.TAB &&
               $( this ).data( "ui-autocomplete" ).menu.active ) {
               event.preventDefault();
            }
         })
         .autocomplete({
            source: function( request, response ) {
               $.getJSON( "/roles", {
                     term: extractLast( request.term ),
                  },
                  function( data ) {
                     response($.map(data, function(item) {
                        return {
                           value: item.role
                        }
                     }))
                  }
               );
            },
            search: function() {
               // custom minLength
               var term = extractLast( this.value );
               if ( term.length < 2 ) {
                  return false;
               }
            },
            focus: function() {
               // prevent value inserted on focus
               return false;
            },
            select: function( event, ui ) {
               console.log(ui);
               console.log(this);
               var terms = split( this.value );
               // remove the current input
               terms.pop();
               // add the selected item
               terms.push( ui.item.value );
               // add placeholder to get the comma-and-space at the end
               terms.push( "" );
               this.value = terms.join( ", " );
               return false;
            }
         });
   });
</script>
@stop