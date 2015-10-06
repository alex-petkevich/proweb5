@extends('backend.layout')

@section('main')

    <h1 class="page-header">{!! trans('promos.all_promos') !!}</h1>

    <div class="row">
        <div class="col-xs-12 col-md-8">


            <a href="{!! route('promos.create') !!}" class="btn btn-success"
               title="{!! trans('promos.add_new_promo') !!}" id="create_button"><span
                        class="glyphicon glyphicon-plus"></span> {!! trans('promos.add_new_promo') !!}</a>

            <button type="button" class="btn btn-default" id="btn-search"><span
                        class="glyphicon glyphicon-search"></span> {!! trans('promos.search') !!} </button>

            {!! Form::model($promos, array('method' => 'GET', 'route' => array('promos.index'), 'role' => 'form', 'class' => 'navbar-form navbar-right') ) !!}
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
        <div class="col-xs-6 col-md-4">

            <button class="btn btn-info"
                    title="{!! trans('promos.categories') !!}" id="categories_editor" data-toggle="modal"
                    data-target="#catEditor"><span
                        class="glyphicon glyphicon-list-alt"></span> {!! trans('promos.categories') !!}</button>
        </div>
    </div>

    <p>
    {!! Form::model($promos, array('method' => 'GET', 'route' => array('promos.index'), 'role' => 'form', 'class' => (isset($filter['filter']) ?  'form-inline form-search' : 'form-inline form-search'), 'style' => (isset($filter['filter']) ?  '' : 'display:none') )) !!}
    <div class="well">

        <div class="form-group">
            {!! Form::label('title', trans('promos.name'), array('class' => 'sr-only')) !!}
            {!! Form::text('title', $filter['name'], array('class' => 'form-control input-sm', 'placeholder' =>  trans('promos.name'))) !!}
        </div>

        <div class="form-group">
            {!! Form::label('description', trans('promos.description'), array('class' => 'sr-only')) !!}
            {!! Form::text('description', $filter['description'], array('class' => 'form-control input-sm', 'placeholder' =>  trans('promos.description'))) !!}
        </div>

        <div class="form-group">
            {!! Form::label('active', trans('promos.active'), array('class' => 'control-label')) !!}
            {!! Form::select('active', [''=>'-','1'=>trans('general.yes'),'0'=>trans('general.no')], $filter['active'], array('class' => 'form-control input-sm')) !!}
        </div>

        {!! Form::submit(trans('promos.search'), array('class' => 'btn btn-info btn-sm')) !!}
        {!! link_to_route('promos.index', trans('promos.clear'), array('filter'=>'reset'), array('class' => 'btn btn-default btn-sm')) !!}
        {!! Form::hidden('filter','apply') !!}
    </div>
    {!! Form::close() !!}
    </p>

    @if (count($promos))
        <input type="hidden" name="_token" id="csrf_token" value="{!! csrf_token() !!}"/>
        <br/>


        <table class="table table-striped table-hover table-condensed">
            <thead>
            <tr>
                <th>{!! trans('promos.img') !!}</th>
                <th>{!! trans('promos.name') !!}</th>
                <th>{!! trans('promos.category') !!}</th>
                <th width="5%">{!! trans('promos.active') !!}</th>
                <th colspan="2" width="5%">

                </th>
            </tr>
            </thead>

            <tbody>
            @foreach ($promos as $promo)
                <tr @if (!$promo->active) class="tr-disabled" @endif id="tr-{!! $promo->id !!}">
                    <td><img src="{!! Imagecache::get($promo->avatar, '150x150')->src !!}" id="thumb"
                             style="max-width:50px; max-height: 50px;@if ($promo->img == '') display: none;@endif"
                             class="img-thumbnail"></td>
                    <td>{{{ $promo->name }}}</td>
                    <td>
                        @if ($promo->category)
                            <span class="badge">{!! $promo->category->name !!}</span>
                        @endif
                    </td>
                    <td><input type="Checkbox" name="active" class='promo-active' value="{!! $promo->id !!}"
                               @if ($promo->active) checked @endif /></td>
                    <td>{!! link_to_route('promos.edit', trans('promos.edit'), array($promo->id), array('class' => 'btn btn-info btn-sm')) !!}</td>
                    <td>
                        {!! Form::open(array('method' => 'DELETE', 'route' => array('promos.destroy', $promo->id))) !!}
                        {!! Form::submit(trans('promos.delete'), array('class' => 'btn btn-danger btn-sm')) !!}
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <?php echo $promos->render(); ?>

    @else
        <p class="text-center">
            {!! trans('promos.no_promos') !!}</p>
    @endif

    @include('backend.promos.categories.index')
    @include('backend.promos.categories.edit')
@stop


@section('scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $(".promo-active").bootstrapSwitch({
                'size': 'small',
                onSwitchChange: changeActive
            });
        });
        function changeActive(el, state) {
            var promo_id = this.value;
            var data = new FormData();
            data.append('id', promo_id);
            data.append('active', state);
            $.ajax({
                url: '/promos/update_state',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (result) {
                    if (state)
                        $("#tr-" + promo_id).removeClass("tr-disabled");
                    else
                        $("#tr-" + promo_id).addClass("tr-disabled");
                },
                error: function (result) {

                }
            });
        }
    </script>
@stop