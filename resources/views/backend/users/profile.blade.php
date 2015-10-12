@extends( ( Auth::user()->isAdmin() ? 'backend.layout' : 'frontend.layout' ))

@section('main')
    <div class="col-xs-5">
        <h1>{!! trans('users.edit_user') !!}</h1>
        {!! Form::model($user, array('method' => 'PATCH', 'route' => array('users.update_user', $user->id), 'role' => 'form')) !!}
        <div class="form-group @if ($errors->has('username')) has-error has-feedback @endif">
            {!! Form::label('username', trans('users.username'), array('class' => 'control-label')) !!}
            {!! Form::text('username', $user->username, array('disabled'=>1,'class' => 'form-control')) !!}
        </div>

        <div class="form-group @if ($errors->has('email')) has-error has-feedback @endif">
            {!! Form::label('email', trans('users.email'), array('class' => 'control-label')) !!}
            {!! Form::text('email', $user->email, array('class' => 'form-control')) !!}
        </div>
        <div class="form-group @if ($errors->has('password')) has-error has-feedback @endif">
            {!! Form::label('password', trans('login.password'), array('class' => 'control-label')) !!}
            {!! Form::password('password',array('class' => 'form-control')) !!}
        </div>
        <div class="form-group @if ($errors->has('birthdate')) has-error has-feedback @endif">
            {!! Form::label('birthdate', trans('users.birthdate'), array('class' => 'control-label')) !!}


            <div class='input-group date' id='datetimepicker1'>
                {!! Form::text('birthdate', $user->birthdate, array('class' => 'form-control')) !!}
                <span class="input-group-addon">
         <span class="glyphicon glyphicon-calendar"></span>
      </span>
            </div>

            <script type="text/javascript">
                $(function () {
                    $('#datetimepicker1').datetimepicker({
                        locale: 'ru',
                        showTodayButton: true,
                        format: 'YYYY-MM-DD'
                    });
                });
            </script>

        </div>

        <div class="form-group @if ($errors->has('fullname')) has-error has-feedback @endif">
            {!! Form::label('fullname', trans('users.fullname'), array('class' => 'control-label')) !!}
            {!! Form::text('fullname', $user->fullname, array('class' => 'form-control')) !!}
        </div>

        <div class="form-group @if ($errors->has('file')) has-error has-feedback @endif">
            {!! Form::label('file', trans('users.avatar'), array('class' => 'control-label')) !!}
            {!! Form::file('file') !!}
            @if ($errors->has('file')) <span class="glyphicon glyphicon-remove form-control-feedback"></span> @endif
            <img src="{!! Imagecache::get($user->avatar, '150x150resize')->src  !!}" id="thumb"
                 style="max-width:150px; max-height: 150px;@if ($user->avatar == '') display: none;@endif"
                 class="img-thumbnail">
            {!! Form::hidden('image', $user->avatar) !!}
            <div class="error alert alert-danger" style="display: none;"></div>
        </div>

        <div class="checkbox @if ($errors->has('notifications')) has-error has-feedback @endif">
            <label>
                {!! Form::checkbox('notifications','1',$user->notifications, array('id' => 'notifications')) !!}
                {!! trans('users.notifications') !!}
            </label>
        </div>

        <div class="form-group">
            {!! Form::submit(trans('users.update'), array('class' => 'btn btn-info')) !!}
            {!! link_to_route('users.index', trans('users.cancel'), $user->id, array('class' => 'btn btn-default')) !!}
        </div>
        {!! Form::close() !!}
    </div>


@stop

@section('scripts')
    @include('backend.users.edit.scripts')
@stop
