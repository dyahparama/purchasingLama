var dataRB = []
var countSelect = 1
$('#add-detail-po').on('click', function () {
    $('#table-body').append('<tr>' + $('#table-body tr.table-row:last').html() + '</tr>')
    $('#table-body tr.table-row:last td').each(function () {
        $(this).val("")
    })
    $('#row-total').appendTo('#table-body')

    let html = '<select name="jenis[]" class="form-control select2-modal" data-plugin="select2"><option>Pilih Jenis Barang</option>'
    $.each(dataRB, function (key, value) {
        html += '<option value="' + key + '">' + value['Jenis_Nama'] + '</option>'
    })
    html += '</select>'

    $('.jenis-barang:last').html(html)

    $('.jenis-barang select').each(function () {
        // $(this).html(html)
        // $(this).select2('destroy')
        $(this).select2()
    })
})

$(document).on('click', '.delete-row', function () {
    // alert($('#table-body tr').length)
    if ($('#table-body tr').length > 2) {
        // alert("Detailsss")
        let c = confirm("Apakah yakin akan menghapus data?")
        if (c)
            $(this).parent().parent().remove()
    }
    else {
        alert("Detail harus ada")
    }
})

$('#add-detail-termin').on('click', function () {
    $('#table-termin').append('<tr>' + $('#table-termin tr.table-row-termin:last').html() + '</tr>')
    $('#table-termin tr.table-row-termin:last td').each(function () {
        $(this).val("")
    })
    $('#row-total-termin').appendTo('#table-termin')
    $(".tgl").datepicker({ format: "dd/mm/yyyy" })
})

$(document).on('click', '.delete-row-termin', function () {
    // alert($('#table-body tr').length)
    if ($('#table-termin tr').length > 2) {
        let c = confirm("Apakah yakin akan menghapus data?")
        if (c)
            $(this).parent().parent().remove()
    }
    else {
        alert("Termin harus ada")
    }
})

$(document).on('change', '#kode-rb-po', function () {
    if ($(this).val()) {
        $.ajax({
            url: "po/getDetailRB",
            type: "post", //form method
            data: {
                id: $(this).val()
            },
            dataType: "json",
            beforeSend: function () { },
            success: function (result) {
                dataRB = result
                let html = "<option>Pilih Jenis Barang</option>"
                $.each(dataRB, function (key, value) {
                    html += '<option value="' + key + '">' + value['Jenis_Nama'] + '</option>'
                })
                $('.jenis-barang select').each(function () {
                    $(this).html(html)
                    // $(this).select2('destroy')
                    $(this).select2()
                })
            },
            complete: function (result) { },
            error: function (xhr, Status, err) { }
        })
    }
})

$(document).on('change', '.jumlah-po', function () {
    let parent = $(this).parent().parent()
    parent.find('select').each(function () {
        let jenis = $(this).val()
        if (jenis) {
            let jumlah = 0
            $('.jumlah-po').each(function () {
                if (jenis == $(this).parent().parent().find('select').val())
                    jumlah += parseInt($(this).val())
            })
            // alert(jumlah)
            if (dataRB[$(this).val()]['Jumlah'] < jumlah) {
                alert("Total " + dataRB[$(this).val()]['Jenis_Nama'] + " tidak boleh lebih dari " + dataRB[$(this).val()]['Jumlah'])
                parent.find('.jumlah-po').val(dataRB[$(this).val()]['Jumlah'] - (jumlah - parent.find('.jumlah-po').val()))
            }
        }
    })
})

$(document).on('keyup', '.harga-po-val, .jumlah-po-val, .diskon-po-val, .diskon2-po-val', function () {
    let parent = $(this).parent().parent()
    let harga = parent.find(".harga-po-val").val() ? parent.find(".harga-po-val").val() : 0
    let jumlah = parent.find(".jumlah-po-val").val() ? parent.find(".jumlah-po-val").val() : 0
    let total = harga * jumlah
    let diskonPersen = parent.find(".diskon-po-val").val() ? parent.find(".diskon-po-val").val() : 0
    let diskonRP = parent.find(".diskon2-po-val").val() ? parent.find(".diskon2-po-val").val() : 0
    if ($(this).hasClass('diskon-po-val')) {
        diskonPersen = parent.find(".diskon-po-val").val() ? parent.find(".diskon-po-val").val() : 0
        diskonRP = total * diskonPersen / 100
        parent.find('.diskon2-po-val').val(diskonRP)
    } else if ($(this).hasClass('diskon2-po-val')) {
        diskonRP = parent.find(".diskon2-po-val").val() ? parent.find(".diskon2-po-val").val() : 0
        diskonPersen = ((total * diskonRP) / 100) / 100
        parent.find('.diskon-po-val').val(diskonPersen)
    } else {
        diskonRP = total * diskonPersen / 100
        parent.find('.diskon2-po-val').val(diskonRP)
    }
    parent.find('.subtotal-po-val').val(total - diskonRP)

    let totalakhir = 0
    $('.subtotal-po-val').each(function () {
        totalakhir += parseInt($(this).val())
    })
    $('#total-akhir-po').val(totalakhir)
})

$(document).on('keyup', '.jumlah-termin', function () {
    let totalakhir = 0
    $('.jumlah-termin').each(function () {
        totalakhir += parseInt($(this).val())
    })
    $('#total-akhir-termin-po').val(totalakhir)
})


