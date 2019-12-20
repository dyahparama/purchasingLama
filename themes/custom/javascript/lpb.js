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

$(document).on('keyup', '.jumlah-diterima-lpb', function () {
    let parent = $(this).parent().parent()
    let harga = parent.find(".harga-lpb").val() ? parent.find(".harga-lpb").val() : 0
    let jumlah = parent.find(".jumlah-diterima-lpb").val() ? parent.find(".jumlah-diterima-lpb").val() : 0
    let total = harga * jumlah
    parent.find('.subtotal-lpb').val(total)

    let totalakhir = 0
    $('.subtotal-lpb').each(function () {
        totalakhir += parseInt($(this).val())
    })
    $('#total-akhir-lpb').val(totalakhir)
})
