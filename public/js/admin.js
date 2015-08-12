$(document).ready(function() {
    $('input[type=radio][name=id]').change(function() {
        if ($(this).is(':checked')) {
            $('#edit_button').removeClass('disabled');
            $('#delete_button').removeClass('disabled');
        } else {
            $('#edit_button').addClass('disabled');
            $('#delete_button').addClass('disabled');
        }
    });

    $('#edit_button').click(function() {
        $('#edit_button').prop('href',$('#edit_button').prop('href') + '/' + $('input[name=id]:checked').val() + '/edit');
        return true;
    });

    $('#delete_button').click(function() {

        $('#delete_button').prop('href',$('#delete_button').prop('href') + '/' + $('input[name=id]:checked').val());

        $('#delete_button').append(function(){
            return "\n<form action='"+$(this).attr('href')+"' method='POST' id='del_form' style='display:none'>" +
            "<input type='hidden' name='_method' value='DELETE' />" +
            "<input type='hidden' name='_token' value='"+$('#csrf_token').val()+"' />"
            "</form>";
        });

        $("#del_form").submit();
        return false;
    });

    $('#btn-search').click(function() {
        if ($('.form-search').is(":visible")) {
            $('.form-search').addClass("hide");
        } else {
            $('.form-search').hide().removeClass("hide").slideDown('fast');
        }
    });

});