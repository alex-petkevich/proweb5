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

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-4 text-left">
                            <button type="button" class="btn btn-success" id="addCat" data-toggle="modal"><span
                                        class="glyphicon glyphicon-plus"
                                        aria-hidden="true"></span> {!! trans('blog_categories.add') !!}</button>
                        </div>
                        <div class="col-md-4 col-md-offset-4">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal">{!! trans('blog_categories.close') !!}</button>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>

<script type="text/javascript">

    $(document).ready(function () {
        $('#addCat').click(function () {
            showModalCat("", "", "1");
        });
        function getTree() {
            $.ajax({
                url: 'blog/categories/api/get',
                data: data,
                success: success,
                dataType: dataType
            });
            
            var data = [
                {
                    text: "Parent 1",
                    id: "parent_1",
                    name: "name1",
                    parent_id: "parent_name1",
                    active: "1",
                    nodes: [
                        {
                            text: "Child 1",
                            id: "parent_21",
                            nodes: [
                                {
                                    text: "Grandchild 1",
                                    id: "parent3_1",
                                },
                                {
                                    text: "Grandchild 2",
                                    id: "parent4_1",
                                }
                            ]
                        },
                        {
                            text: "Child 2",
                            id: "paren5t_1",
                        }
                    ]
                },
                {
                    text: "Parent 2",
                    id: "par6ent_1",
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

        treeview(getTree(), $('#tree'));
    });

    function treeview(data, element) {
        $.each(data, function (key, val) {
            recursiveFunction(key, val, element, 0);
        });
        var html = "<ul class=\"list-group\">" + element.html() + "</ul>";
        element.html(html);
    }

    function recursiveFunction(key, val, element, shift) {
        displayValue(key, val, element, shift);
        var value = val['nodes'];
        if (value instanceof Object) {
            shift++;
            $.each(value, function (key, val) {
                recursiveFunction(key, val, element, shift)
            });
        }
    }

    function displayValue(key, val, element, shift) {
        var current = "<li class=\"list-group-item\">";
        current += "<div class=\"container-fluid\"><div class=\"row\"><div class=\"col-md-8 text-left\">";
        current += "&nbsp;".repeat(shift * 3);
        current += "<a href='javascript:;' onclick='showModalCat(this.getAttribute(\"dataid\"),this.text, this.getAttribute(\"dataactive\"), this.getAttribute(\"dataname\"), this.getAttribute(\"dataparent\"))' dataid='" + val.id + "' dataname='" + val.name + "' dataactive='" + val.active + "' dataparent='" + val.parent_id + "'>" + val.text + "</a>";
        current += "</div><div class=\"col-md-4 text-right\">";
        current += "<button type=\"button\" class=\"btn btn-default btn-xs cats-add\" onclick='showModalCat(\"\",\"\", \"1\", \"\", this.getAttribute(\"dataparent\"))' dataparent='" + val.id + "'><span class=\"glyphicon glyphicon-plus\"></span></button>";
        current += "<button type=\"button\" class=\"btn btn-default btn-xs cats-delete\"><span class=\"glyphicon glyphicon-minus\"></span></button>";
        current += "</div></div></div>";
        current += "</li>";

        var prevHtml = element.html();
        element.html(prevHtml + current);
    }

    function showModalCat(id, title, active, name, parent_id) {
        $('#id').val(id != 'undefined' ? id : "");
        $('#parent_id').val(parent_id != 'undefined' ? parent_id : "");
        $('#name').val(name != 'undefined' ? name : "");
        $('#title').val(title != 'undefined' ? title : "");
        $('#active').prop("checked", active == '1');
        $('#editModal').modal();
    }
    
</script>