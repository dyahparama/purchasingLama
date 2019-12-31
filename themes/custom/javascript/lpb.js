const formatCur = {mDec:0, aSep:'.', aDec:','}

$(document).ready(function(){
    $('.autonumeric').each(function(){
        $(this).autoNumeric('init', formatCur)
    })
})

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
    let jumlahKirim = parent.find(".jumlah-lpb").val() ? parent.find(".jumlah-lpb").autoNumeric('get') : 0
    let jumlahTerima = parent.find(".jumlah-diterima-lpb").val() ? parent.find(".jumlah-diterima-lpb").autoNumeric('get') : 0

    console.log(jumlahKirim)
    console.log(jumlahTerima)

    if (parseFloat(jumlahKirim) < parseFloat(jumlahTerima)) {
        alert("Jumlah diterima salah")
        $(this).autoNumeric('set', jumlahKirim)
    }
})

$(document).on('keyup', '.jumlah-diterima-lpb', function () {
    let parent = $(this).parent().parent()
    let harga = parent.find(".harga-lpb").val() ? parent.find(".harga-lpb").autoNumeric('get') : 0
    let jumlah = parent.find(".jumlah-diterima-lpb").val() ? parent.find(".jumlah-diterima-lpb").autoNumeric('get') : 0
    let total = harga * jumlah
    parent.find('.subtotal-lpb').autoNumeric('set', total)

    let totalakhir = 0
    $('.subtotal-lpb').each(function () {
        totalakhir += parseInt($(this).autoNumeric('get'))
    })
    $('#total-akhir-lpb').autoNumeric('set', totalakhir)
})

$("#submit-lpb").click(function(e) {
        let pass = true;
        let data = $("#form-lpb").serializeArray();
        let cekJumlahTerima = true;
        $(document).find(".jumlah-diterima-lpb").each(function() {
            
            if (!$(this).val() || $(this).val() == "0") {
                cekJumlahTerima = false;
            }
        });
        if (!cekJumlahTerima) {
            alert("jumlah terima tidak boleh 0");
        } else {
            data.forEach(element => {
                if ((element.value == "" && !element.name.includes("kode_supplier"))
                    && (element.value == "" && !element.name.includes("Pemohon"))
                    && (element.value == "" && !element.name.includes("user_forward"))
                    && (element.value == "" && !element.name.includes("keterangan"))
                    && (element.value == "" && !element.name.includes("note"))
                    && (element.value == "" && !element.name.includes("surat_jalan"))
                    ) {
                    pass = false;
                }
            });
            if (pass) {
                alert("asas");
            } else {
                alert("data belum lengkap");
            }
        }
    });
