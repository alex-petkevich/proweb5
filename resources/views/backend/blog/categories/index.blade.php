<!-- Modal -->
<div class="modal fade" id="catEditor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"
                        aria-label="{!! trans('blog_categories.close') !!}"><span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">{!! trans('blog_categories.categories_title') !!}</h4>
            </div>
            <div class="modal-body">
                <div id="tree"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal">{!! trans('blog_categories.close') !!}</button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        function getTree() {
            var data = [
                {
                    text: "Parent 1",
                    tags: ["<button type=\"button\" class=\"btn btn-default btn-xs\"><span class=\"glyphicon glyphicon-minus\"></span></button>", "<button type=\"button\" class=\"btn btn-default btn-xs\"><span class=\"glyphicon glyphicon-plus\"></span></button>"],
                    nodes: [
                        {
                            text: "Child 1",
                            nodes: [
                                {
                                    text: "Grandchild 1"
                                },
                                {
                                    text: "Grandchild 2"
                                }
                            ]
                        },
                        {
                            text: "Child 2"
                        }
                    ]
                },
                {
                    text: "Parent 2"
                },
                {
                    text: "Parent 3"
                },
                {
                    text: "Parent 4"
                },
                {
                    text: "Parent 5"
                }
            ];
            return data;
        }

        $('#tree').treeview({data: getTree(), showTags: true});
        $('#tree').treeview('expandAll');
    });
</script>