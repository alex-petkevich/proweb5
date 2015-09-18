<tr>
   <td class="col-md-0">{!! FORM::radio('id',$page['id'],false, array('id'=>'id_'.$page['id'])) !!}</td>
   <td>{!! str_repeat('&nbsp;',$page['shift']) !!} {!! Form::label('id_'.$page['id'], $page['title']) !!}</td>
</tr>
@if (isset($page['children']) && count($page['children']) > 0)

@foreach ($page['children'] as $page)
@include('backend.pages.partials.page', $page)
@endforeach

@endif
