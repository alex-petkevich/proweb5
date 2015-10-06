<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editCategoryModalLabel">{!! trans('promos.cat_properties')  !!}</h4>
            </div>
            <div class="modal-body">
                <div id="editModalErrors" class="alert alert-danger" style="display: none">

                </div>
                <form>
                    <div class="form-group">
                        <label for="name" class="control-label">{!! trans('promos.name')  !!}</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="active">
                            {!! trans('promos.active')  !!}
                        </label>
                    </div>
                    <input type="hidden" name="id" id="id" value=""/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">{!! trans('promos.close')  !!}</button>
                <button type="button" class="btn btn-primary"
                        id="btnAdd">{!! trans('promos.submit')  !!}</button>
            </div>
        </div>
    </div>
</div>