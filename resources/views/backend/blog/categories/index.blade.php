<!-- Modal -->
<div class="modal fade" id="catEditor" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"
                    aria-label="{!! trans('blog_categories.close') !!}"><span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">{!! trans('blog_categories.categories_title') !!}
            </h4>
         </div>
         <div class="modal-body">
            <div class="progress" id="progress" style="display:none;">
               <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100"
                    aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                  <span class="sr-only">{!! trans('general.wait') !!}</span>
               </div>
            </div>

            <div id="tree"></div>
         </div>
         <div class="modal-footer">

            <div class="container-fluid">
               <div class="row">
                  <div class="col-md-4 text-left">
                     <button type="button" class="btn btn-success" id="addCat" data-toggle="modal"><span
                           class="glyphicon glyphicon-plus"
                           aria-hidden="true"></span> {!! trans('blog_categories.add') !!}</button>
                     <button type="button" class="btn btn-default" id="refresh">
                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                     </button>
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
      getTree();
      $('#btnAdd').click(function () {
         if ($('#id').val()) {
            editCat();
         } else {
            addCat();
         }
      });

   });

   $('#addCat').click(function () {
      showModalCat("", "", "1");
   });

   $('#refresh').click(function () {
      getTree();
   });

   function processSuccess(data) {
      $('#progress').hide();
      treeview(data, $('#tree'));
   }


   function getTree() {
      $('#progress').show();
      $.ajax({
         url: 'api/blog/categories',
         success: processSuccess,
         error: function () {
            $('#progress').hide();
         },
         dataType: "json"
      });
   }

   function delCat(id) {
      $('#progress').show();
      $.ajax({
         url: 'api/blog/categories/' + id,
         type: "DELETE",
         success: getTree,
         error: function () {
            $('#progress').hide();
         },
         dataType: "json"
      });
   }

   function addCat() {

      var parent_id = $('#parent_id').val();
      var name = $('#name').val();
      var title = $('#title').val();
      var active = $('#active').prop("checked");

      if (title == '') {
         $('#box-title').addClass('has-error').addClass('has-feedback');
         return false;
      } else {
         $('#box-title').removeClass('has-error').removeClass('has-feedback');
      }

      var data = {
         parent_id: parent_id,
         name: name,
         title: title,
         active: active
      };

      $('#progress').show();

      $.ajax({
         url: 'api/blog/categories',
         type: "POST",
         data: data,
         success: function (data) {
            $('#progress').hide();
            if (data.status == 'OK') {
               $('#editModal').modal('toggle');
               getTree();
            } else {
               displayErrors(data.messages);
            }
         },
         error: function (xhr, data) {
            $('#progress').hide();
         },
         dataType: "json"
      });
   }

   function editCat() {

      var parent_id = $('#parent_id').val();
      var name = $('#name').val();
      var title = $('#title').val();
      var active = $('#active').prop("checked");
      var id = $('#id').val();

      if (title == '') {
         $('#box-title').addClass('has-error').addClass('has-feedback');
         return false;
      } else {
         $('#box-title').removeClass('has-error').removeClass('has-feedback');
      }

      var data = {
         parent_id: parent_id,
         name: name,
         title: title,
         active: active
      };

      $('#progress').show();

      $.ajax({
         url: 'api/blog/categories/' + id,
         type: "PUT",
         data: data,
         success: function (data) {
            $('#progress').hide();
            if (data.status == 'OK') {
               $('#editModal').modal('toggle');
               getTree();
            } else {
               displayErrors(data.messages);
            }
         },
         error: function (xhr, data) {
            $('#progress').hide();
         },
         dataType: "json"
      });
   }

   function displayErrors(messages) {
      var mess = "";
      $.each(messages, function (val) {
         mess += messages[val] + "<br />";
      });
      $('#editModalErrors').html(mess);
      $('#editModalErrors').show();
   }

   function treeview(data, element) {
      element.html("");
      $.each(data, function (key, val) {
         recursiveFunction(key, val, element, 0);
      });
      var html = "<ul class=\"list-group\">" + element.html() + "</ul>";
      element.html(html);
   }

   function recursiveFunction(key, val, element, shift) {
      displayValue(key, val, element, shift);
      var value = val['children'];
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
      current += "<a href='javascript:;' onclick='showModalCat(this.getAttribute(\"dataid\"),this.text, this.getAttribute(\"dataactive\"), this.getAttribute(\"dataname\"), this.getAttribute(\"dataparent\"))' dataid='" + val.id + "' dataname='" + val.name + "' dataactive='" + val.active + "' dataparent='" + val.parent_id + "' class='disabled'>" + (val.active != '1' ? '<s>' : '') + val.title + (val.active != '1' ? '</s>' : '') + "</a>";
      current += "</div><div class=\"col-md-4 text-right\">";
      current += "<button type=\"button\" class=\"btn btn-default btn-xs cats-add\" onclick='showModalCat(\"\",\"\", \"1\", \"\", this.getAttribute(\"dataparent\"))' dataparent='" + val.id + "'><span class=\"glyphicon glyphicon-plus\"></span></button>";
      current += "<button type=\"button\" class=\"btn btn-default btn-xs cats-delete\" onclick='delCat(this.getAttribute(\"dataid\"))' dataid='" + val.id + "'><span class=\"glyphicon glyphicon-minus\"></span></button>";
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
      $('#box-title').removeClass('has-error').removeClass('has-feedback');
      $('#editModalErrors').hide();
      $('#editModal').modal();
   }

</script>