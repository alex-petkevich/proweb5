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
            {!! Form::label('title', trans('proposals.name'), array('class' => 'sr-only')) !!}
            {!! Form::text('title', $filter['name'], array('class' => 'form-control input-sm', 'placeholder' =>  trans('proposals.name'))) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', trans('proposals.description'), array('class' => 'sr-only')) !!}
            {!! Form::text('description', $filter['description'], array('class' => 'form-control input-sm', 'placeholder' =>  trans('proposals.description'))) !!}
        </div>

        <div class="form-group">
            {!! Form::label('search-active', trans('proposals.active'), array('class' => 'control-label')) !!}
            {!! Form::select('active', [''=>'-','1'=>trans('general.yes'),'0'=>trans('general.no')], $filter['active'], array('class' => 'form-control input-sm', 'id' => 'search-active')) !!}
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
                <th>{!! trans('proposals.img') !!}</th>
                <th>{!! trans('proposals.name') !!}</th>
                <th>{!! trans('proposals.category') !!}</th>
                <th>{!! trans('proposals.clicks') !!} / {!! trans('proposals.shows') !!}</th>
                <th width="5%">{!! trans('proposals.active') !!}</th>
                <th colspan="2" width="5%">

                </th>
            </tr>
            </thead>

            <tbody>
            @foreach ($proposals as $proposal)
                <tr @if (!$proposal->active) class="tr-disabled" @endif id="tr-{!! $proposal->id !!}">
                    <td><img src="{!! Imagecache::get($proposal->img, '150x150')->src !!}" id="thumb"
                             style="max-width:50px; max-height: 50px;@if ($proposal->img == '') display: none;@endif"
                             class="img-thumbnail"></td>
                    <td>{{{ $proposal->name }}}</td>
                    <td>
                        @if ($proposal->category)
                            <span class="badge">{!! $proposal->category->name !!}</span>
                        @endif
                    </td>
                    <td>{{{ $proposal->clicks }}} / {{{ $proposal->shows }}}</td>
                    <td><input type="Checkbox" name="active" class='proposal-active' value="{!! $proposal->id !!}"
                               @if ($proposal->active) checked @endif /></td>
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

    @include('backend.proposals.categories.index')
    @include('backend.proposals.categories.edit')
@stop


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".proposal-active").bootstrapSwitch({
                'size': 'small',
                onSwitchChange: changeActive
            });
        });
        function changeActive(el, state) {
            var proposal_id = this.value;
            var data = new FormData();
            data.append('id', proposal_id);
            data.append('active', state);
            $.ajax({
                url: '/proposals/update_state',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (result) {
                    if (state)
                        $("#tr-" + proposal_id).removeClass("tr-disabled");
                    else
                        $("#tr-" + proposal_id).addClass("tr-disabled");
                },
                error: function (result) {

                }
            });
        }
    </script>
@stop