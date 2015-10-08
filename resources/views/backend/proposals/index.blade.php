@extends('backend.layout')

@section('main')

    <h1 class="page-header">{!! trans('proposals.all_proposals') !!}</h1>

    <div class="row">
        <div class="col-xs-12 col-md-8">


            <a href="{!! route('proposals.create') !!}" class="btn btn-success"
               title="{!! trans('proposals.add_new_proposal') !!}" id="create_button"><span
                        class="glyphicon glyphicon-plus"></span> {!! trans('proposals.add_new_proposal') !!}</a>

            <button type="button" class="btn btn-default" id="btn-search"><span
                        class="glyphicon glyphicon-search"></span> {!! trans('proposals.search') !!} </button>

            {!! Form::model($proposals, array('method' => 'GET', 'route' => array('proposals.index'), 'role' => 'form', 'class' => 'navbar-form navbar-right') ) !!}
            <div class="form-group">
                {!! Form::label('sort_by', trans('general.sort_by'), array('class' => 'control-label')) !!}
                {!! Form::select('sort_value', $sort_options, $sort['value'], array('class' => 'form-control input-sm')) !!}
            </div>

            <div class="form-group">
                {!! Form::label('sort_dir', trans('general.sort_dir'), array('class' => 'sr-only')) !!}
                {!! Form::select('sort_dir', [''=>'-','0'=>trans('general.sort_asc'),'1'=>trans('general.sort_desc')], $sort['dir'], array('class' => 'form-control input-sm')) !!}
            </div>

            <div class="form-group">
                {!! Form::submit(trans('general.sort'), array('class' => 'btn btn-default btn-sm')) !!}
            </div>

            {!! Form::close() !!}

        </div>
        <div class="col-xs-6 col-md-4"></div>
    </div>

    <p>
    {!! Form::model($proposals, array('method' => 'GET', 'route' => array('proposals.index'), 'role' => 'form', 'class' => (isset($filter['filter']) ?  'form-inline form-search' : 'form-inline form-search'), 'style' => (isset($filter['filter']) ?  '' : 'display:none') )) !!}
    <div class="well">

        <div class="form-group">
            {!! Form::label('title', trans('proposals.title'), array('class' => 'sr-only')) !!}
            {!! Form::text('title', $filter['title'], array('class' => 'form-control input-sm', 'placeholder' =>  trans('proposals.title'))) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', trans('proposals.description'), array('class' => 'sr-only')) !!}
            {!! Form::text('description', $filter['description'], array('class' => 'form-control input-sm', 'placeholder' =>  trans('proposals.description'))) !!}
        </div>

        {!! Form::submit(trans('proposals.search'), array('class' => 'btn btn-info btn-sm')) !!}
        {!! link_to_route('proposals.index', trans('proposals.clear'), array('filter'=>'reset'), array('class' => 'btn btn-default btn-sm')) !!}
        {!! Form::hidden('filter','apply') !!}
    </div>
    {!! Form::close() !!}
    </p>

    @if (count($proposals))
        <input type="hidden" name="_token" id="csrf_token" value="{!! csrf_token() !!}"/>
        <br/>


        <table class="table table-striped table-hover table-condensed">
            <thead>
            <tr>
                <th>{!! trans('proposals.published_at') !!}</th>
                <th>{!! trans('proposals.title') !!}</th>
                <th>{!! trans('proposals.user') !!}</th>
                <th colspan="2" width="5%">

                </th>
            </tr>
            </thead>

            <tbody>
            @foreach ($proposals as $proposal)
                <tr id="tr-{!! $proposal->id !!}">
                    <td>{{{ date('d.m.Y',strtotime($proposal->published_at)) }}}</td>
                    <td>{{{ $proposal->title }}}</td>
                    <td>
                        @if ($proposal->user!=null)
                            {!! link_to_route('users.edit', $proposal->user->fullname ? $proposal->user->fullname : $proposal->user->username, $proposal->user->id) !!}
                        @endif
                    </td>
                    <td>{!! link_to_route('proposals.edit', trans('proposals.edit'), array($proposal->id), array('class' => 'btn btn-info btn-sm')) !!}</td>
                    <td>
                        {!! Form::open(array('method' => 'DELETE', 'route' => array('proposals.destroy', $proposal->id))) !!}
                        {!! Form::submit(trans('proposals.delete'), array('class' => 'btn btn-danger btn-sm')) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <?php echo $proposals->render(); ?>

    @else
        <p class="text-center">
            {!! trans('proposals.no_proposals') !!}</p>
    @endif
@stop


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {

        });
    </script>
@stop