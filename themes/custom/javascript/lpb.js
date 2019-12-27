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

$(document).on('change', '.jumlah-diterima-lpb', function () {
    let parent = $(this).parent().parent()
    let jumlahKirim = parent.find(".jumlah-lpb").val() ? parent.find(".jumlah-lpb").val() : 0
    let jumlahTerima = parent.find(".jumlah-diterima-lpb").val() ? parent.find(".jumlah-diterima-lpb").val() : 0

    console.log(jumlahKirim)
    console.log(jumlahTerima)

    if (parseFloat(jumlahKirim) < parseFloat(jumlahTerima)) {
        alert("Jumlah diterima salah")
        $(this).val(parseInt(jumlahKirim))
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

$("#submit-lpb").click(function(e) {
        let pass = true;
        let data = $("#form-lpb").serializeArray();
        data.forEach(element => {
            if ((element.value == "" && !element.name.includes("kode_supplier"))
                && (element.value == "" && !element.name.includes("Pemohon"))
                && (element.value == "" && !element.name.includes("user_forward"))
                && (element.value == "" && !element.name.includes("keterangan"))
                ) {
                pass = false;
            }
        });
        console.log(data);
        if (pass) {
            $("#form-lpb").submit();
        } else {
            alert("data belum lengkap");
        }
    });
