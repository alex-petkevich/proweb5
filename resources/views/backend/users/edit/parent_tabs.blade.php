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

        <ul class="nav nav-pills">
            <li role="presentation" class="active"><a href="#">{!! trans('users.tabs-general')  !!}</a></li>
            <li role="presentation"><a href="#">{!! trans('users.tabs-profile')  !!}</a></li>
            <li role="presentation"><a href="#">{!! trans('users.tabs-notes')  !!}</a></li>
        </ul>
        <br/>

        @yield('tab_content')
    </div>

@stop

@section('scripts')
    <script>
        $(document).ready(function () {
            function split(val) {
                return val.split(/,\s*/);
            }

            function extractLast(term) {
                return split(term).pop();
            }

            $("#roles")
                // don't navigate away from the field on tab when selecting an item
                    .bind("keydown", function (event) {
                        if (event.keyCode === $.ui.keyCode.TAB &&
                                $(this).data("ui-autocomplete").menu.active) {
                            event.preventDefault();
                        }
                    })
                    .autocomplete({
                        source: function (request, response) {
                            $.getJSON("/roles", {
                                        term: extractLast(request.term),
                                    },
                                    function (data) {
                                        response($.map(data, function (item) {
                                            return {
                                                value: item.role
                                            }
                                        }))
                                    }
                            );
                        },
                        search: function () {
                            // custom minLength
                            var term = extractLast(this.value);
                            if (term.length < 2) {
                                return false;
                            }
                        },
                        focus: function () {
                            // prevent value inserted on focus
                            return false;
                        },
                        select: function (event, ui) {
                            console.log(ui);
                            console.log(this);
                            var terms = split(this.value);
                            // remove the current input
                            terms.pop();
                            // add the selected item
                            terms.push(ui.item.value);
                            // add placeholder to get the comma-and-space at the end
                            terms.push("");
                            this.value = terms.join(", ");
                            return false;
                        }
                    });
        });
    </script>
@stop