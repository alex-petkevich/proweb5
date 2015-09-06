<script>
   $(document).ready(function () {
      var uploadInput = $('#file'), // Инпут с файлом
              imageInput = $('[name="image"]'), // Инпут с URL картинки
              thumb = document.getElementById('thumb'), // Превью картинки
              error = $('div.error'); // Вывод ошибки при загрузке файла
      uploadInput.on('change', function () {
         var data = new FormData();
         data.append('file', uploadInput[0].files[0]);
         $.ajax({
            url: '/upload',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            dataType: 'json',
            success: function (result) {
               if (result.filelink) {
                  thumb.style.display = 'block';
                  thumb.setAttribute('src', result.filelink);
                  imageInput.val(result.filelink);
                  error.hide();
               } else {
                  error.text(result.message);
                  error.show();
               }
            },
            error: function (result) {
               error.text("{{ trans('users.upload_error') }}");
               error.show();
            }
         });
      });
      function split(val) {
         return val.split(/, \s*/);
      }
      function extractLast(term) {
         return split(term).pop();
      }
   });
</script>