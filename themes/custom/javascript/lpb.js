$(document).on('change', '#nama-supplier', function(){
    if ($(this).val()) {
        $.ajax({
            url: "lpb/getDetailBarang",
            type: "post", //form method
            data: {
                nama_supplier: "tes",
                id_po: "2"
            },
            dataType: "json",
            beforeSend: function () { },
            success: function (result) {
                let html = ""
                $.each(result, function (key, value) {
                    let id = value['ID']
                    html += '<tr>'
                    html += '<td><input name="value[id][]" class="form-control" readonly value=""></td>'
                })
            },
            complete: function (result) { },
            error: function (xhr, Status, err) { }
        })
    }
})
