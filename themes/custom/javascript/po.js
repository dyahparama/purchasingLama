var dataRB = []

$('#add-detail-po').on('click', function () {
    $('#table-body').append('<tr>' + $('#table-body tr.table-row:last').html() + '</tr>')
    $('#table-body tr.table-row:last td').each(function () {
        $(this).val("")
    })
    $('#row-total').appendTo('#table-body')
    $('.jenis-barang').each(function () {
        console.log("aaa")
        // $(this).select2("destroy")
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
    $('#table-termin').append('<tr>' + $('#table-termin tr:last').html() + '</tr>')
    $('#table-termin tr:last td').each(function () {
        $(this).val("")
    })
    $(".tgl").datepicker({ format: "dd/mm/yyyy" })
})

$(document).on('click', '.delete-row-termin', function () {
    // alert($('#table-body tr').length)
    if ($('#table-termin tr').length > 1) {
        // alert("Detailsss")
        $(this).parent().parent().remove()
    }
    else {
        alert("Detail harus ada")
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
                $.each(dataRB, function(key, value){
                    html += '<option value="' + key + '">' + value['Jenis_Nama'] + '</option>'
                })
                $('.jenis-barang').each(function(){
                    $(this).html(html)
                    $(this).select2('destroy')
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
    parent.find('select').each(function(){
        let jenis = $(this).val()
        if (jenis) {
            let jumlah = 0
            $('.jumlah-po').each(function(){
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
