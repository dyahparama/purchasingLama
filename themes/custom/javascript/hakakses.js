let baseURL=$("#baseURL").data("url");

$('.dd').nestable({
    handleClass:'123'
})

$(document).on('click', '.radio-group', function(){
    $('.checkbox-akses').prop('checked', false)
    $.ajax({
        'type': "POST",
        'global': false,
        'dataType': 'json',
        'url': baseURL+"hak-akses/getAkses",
        'data': {'group': $(this).val()},
        'success': function (data) {
            $.each(data, function(key, val){
                $('#val'+val).prop('checked', true)
            })
        }
    });
})
