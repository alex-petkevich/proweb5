<!-- Modal -->
<div class="modal fade" id="catSelector" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"
                    aria-label="{!! trans('blog_categories.close') !!}"><span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="myModalLabel">{!! trans('promos.select_cats') !!}
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
                  <div class="col-md-6 text-left">
                     <button type="button" class="btn btn-default" id="refresh">
                        <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span>
                     </button>
                  </div>
                  <div class="col-md-6">
                     <button type="button" class="btn btn-primary"
                             id="selCat">{!! trans('promos.submit') !!}</button>
                     <button type="button" class="btn btn-default"
                             data-dismiss="modal">{!! trans('promos.close') !!}</button>
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
   });

   $('#catSelector').on('hide.bs.modal', function (e) {
      $("input[name='cat_id']:checked").prop('checked', false);
   });

   $('#catSelector').on('shown.bs.modal', function (e) {
      loadSelection();
   });

   $('#refresh').click(function () {
      getTree();
   });

   $('#selCat').click(function () {
      var selected_tits = [];
      var selected_vals = [];
      $.each($("input[name='cat_id']:checked"), function () {
         //          $(this).val();
         var label = $("label[for='" + this.id + "']");
         selected_tits.push(label.text());
         selected_vals.push($(this).val());
      });
      $('#categories-view').val(selected_tits.join(", "));
      $('#categories-hidden').val(selected_vals.join(","));
      $('#catSelector').modal('toggle');
   });

   function loadSelection() {
      var vals = $("#categories-hidden").val().split(",");
      $.each(vals, function (key, val) {
         $("#cat-" + val).prop('checked', true);
      });
   }

   function processSuccess(data) {
      $('#progress').hide();
      treeview(data, $('#tree'));
      loadSelection();
   }


   function getTree() {
      $('#progress').show();
      $.ajax({
         url: '/api/promos/categories?active=1',
         success: processSuccess,
         error: function () {
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
      current += "<label for='cat-" + val.id + "'>" + (val.active != '1' ? '<s>' : '') + val.name + (val.active != '1' ? '</s>' : '') + "</label>";
      current += "</div><div class=\"col-md-4 text-right\">";
      current += "<input type='radio' name='cat_id' id='cat-" + val.id + "' value='" + val.id + "' />";
      current += "</div></div></div>";
      current += "</li>";

      var prevHtml = element.html();
      element.html(prevHtml + current);
   }

</script>