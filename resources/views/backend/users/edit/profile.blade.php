@extends('backend.users.edit.parent_tabs')

@section('tab_content')


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
                    format: 'DD.MM.YYYY'
                });
            });
        </script>

    </div>

    <div class="form-group @if ($errors->has('fullname')) has-error has-feedback @endif">
        {!! Form::label('fullname', trans('users.fullname'), array('class' => 'control-label')) !!}
        {!! Form::text('fullname', $user->username, array('class' => 'form-control')) !!}
    </div>

    <div class="form-group @if ($errors->has('notifications')) has-error has-feedback @endif">
        {!! Form::label('notifications', trans('users.notifications'), array('class' => 'control-label')) !!}
        {!! Form::checkbox('notifications','1',$user->notifications, array('id' => 'notifications')) !!}
    </div>


@stop
