<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="editCategoryModalLabel">{!! trans('blog_categories.properties')  !!}</h4>
            </div>
            <div class="modal-body">
                <form>
                    <div class="form-group">
                        <label for="name" class="control-label">{!! trans('blog_categories.address')  !!}</label>
                        <input type="text" class="form-control" id="name">
                    </div>
                    <div class="form-group">
                        <label for="title" class="control-label">{!! trans('blog_categories.title')  !!}</label>
                        <input type="text" class="form-control" id="title">
                    </div>
                    <div class="checkbox">
                        <label>
                            <input type="checkbox" id="active">
                            {!! trans('blog_categories.active')  !!}
                        </label>
                    </div>
                    <input type="hidden" name="id" id="id" value=""/>
                    <input type="hidden" name="parent_id" id="parent_id" value=""/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">{!! trans('blog_categories.close')  !!}</button>
                <button type="button" class="btn btn-primary">{!! trans('blog_categories.submit')  !!}</button>
            </div>
        </div>
    </div>
</div>