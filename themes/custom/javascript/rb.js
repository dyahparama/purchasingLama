// const formatCur = {
//     decimalCharacter: ",",
//     decimalCharacterAlternative: ",",
//     decimalPlaces: 0,
//     digitGroupSeparator: ".",
//     unformatOnSubmit: true,
//     unformatOnHover: false
//     // currencySymbolPlacement    : AutoNumeric.options.currencySymbolPlacement.suffix,
//     // roundingMethod             : AutoNumeric.options.roundingMethod.halfUpSymmetric,
// }
const formatCur = {mDec:0, aSep:'.', aDec:','}
let baseURL = $("#baseURL").data("url");
var uri_segment = "rb";
var draftRBDetailID = 0;
var penawaranRow = 0;
// var formatNumber = new AutoNumeric.multiple('.autonumeric', formatCur);

// $('#tgl-draft').datepicker({
//     minDate: new Date()
// })

$(document).ready(function () {
    $('.autonumeric').each(function(){
        $(this).autoNumeric('init', formatCur)
    })
});

$(".add-detail").on("click", function() {
    let parent = $(this)
        .parent()
        .parent();
    parent
        .find("tbody")
        .append("<tr>" + parent.find("tr.table-row:last").html() + "</tr>");
    parent.find("tr.table-row:last td").each(function() {
        $(this).val("");
    });
    parent.find(".row-total").appendTo(parent.find("tbody"));
    parent.find(".typeahead:last").typeahead(
        {
            hint: true,
            highlight: true,
            minLength: 1
        },
        {
            name: "states",
            source: substringMatcher(states)
        }
    );
    // formatNumber.forEach(element => {
    //     element.remove();
    // });
    //console.log(parent.find("tr").last());
    // let indexFormat = [2,3,4];
    // parent.find("tr").last().find("td").each(function (indexInArray, valueOfElement) { 
    //     if (indexFormat.includes(indexInArray)) {
    //         new AutoNumeric($(this).find("input")[0],formatCur);
    //     }
    // });
    $('.autonumeric').each(function(){
        $(this).autoNumeric('init', formatCur)
    })
    //formatNumber = new AutoNumeric.multiple('.autonumeric', formatCur);
    
});

$(document).on("click", ".close-modal", function() {
    $("#" + $(this).attr("data-modal")).modal("hide");
});

$(".add-detail").click(function(e) {
    $(".select2-container").addClass("z-index-1");
    $(".select2-modal")
        .next()
        .removeClass("z-index-1");
    $(".select2-modal")
        .next()
        .css("width", "100%");
});

$(".close-modal").click(function(e) {
    setTimeout(() => {
        $(".select2-container").removeClass("z-index-1");
    }, 500);
});

$(document).on("keyup", ".harga-detail, .jumlah-detail", function() {
   
    let parentRow = $(this)
        .parent()
        .parent();
    let parentTable = $(this)
        .parent()
        .parent()
        .parent();
    // if ($(this).hasClass('jumlah-detail')) {
    //     let jumlahTemp = 0
    //     let jumlahRow = parentRow.find('.jumlah-detail').val() ? parentRow.find('.jumlah-detail').val() : 0
    //     let jumlahTotal = parentRow.find('.total-jumlah').val() ? parentRow.find('.total-jumlah').val() : 0
    //     parentTable.find('.jumlah-detail').each(function(){
    //         jumlahTemp += parseInt($(this).val())
    //     })
    //     if (jumlahTemp > jumlahTotal) {
    //         alert("Jumlah tidak boleh lebih dari " + jumlahTotal)
    //         parentRow.find('.jumlah-detail').val(jumlahTotal - (jumlahTemp - jumlahRow))
    //     }
    // }

    // let jumlah = parentRow.find(".jumlah-detail").val()
    //     ? parentRow.find(".jumlah-detail").val()
    //     : 0;
    // let harga = parentRow.find(".harga-detail").val()
    //     ? parentRow.find(".harga-detail").val()
    //     : 0;
    
    let jumlah = parseFloat(parentRow.find(".jumlah-detail").autoNumeric('get'));
    let harga = parseFloat(parentRow.find(".harga-detail").autoNumeric('get'));
    
        //alert(AutoNumeric.getNumber(parentRow.find(".subtotal-detail")[0]));
    //parentRow.find(".subtotal-detail").val(jumlah * harga);
    AutoNumeric.set(parentRow.find(".subtotal-detail")[0],jumlah * harga);
    console.log(parseFloat(parentRow.find(".subtotal-detail").autoNumeric('get')));
    let subTotalAkhir = 0;
    parentTable.find(".subtotal-detail").each(function() {
        subTotalAkhir += parseInt($(this).autoNumeric('get'));
    });
    parentTable.find(".subtotal-akhir").autoNumeric('set', subTotalAkhir);

    let grandTotal = 0;
    $(document)
        .find(".subtotal-detail")
        .each(function() {
            //grandTotal += parseInt($(this).val());
            grandTotal +=parseFloat(A$(this).autoNumeric('get'))
        });
    //$("#grand-total").val(grandTotal);
    // AutoNumeric.set($("#grand-total")[0],grandTotal);
    
});

$(document).on("change", ".supplier-nama", function() {
    
    if ($(this).val()) {
        let parent = $(this).closest("tr");
        $.ajax({
            url: baseURL + uri_segment + "/getKodeSupplier",
            type: "get", //form method
            data: {
                nama: $(this).val()
            },
            dataType: "text",
            beforeSend: function() {},
            success: function(result) {
                console.log(parent.find(".supplier-kode"));
                parent.find(".supplier-kode").val(result);
            },
            complete: function(result) {},
            error: function(xhr, Status, err) {}
        });
    }
});

$(document).on("click", ".delete-row", function() {
    
    // alert($('#table-body tr').length)
    let parent = $(this)
        .parent()
        .parent()
        .parent()
        .parent();
    // console.log(parent.html())
    if (parent.find("tbody tr").length > 1) {
        // alert("Detailsss")
        let c = confirm("Apakah yakin akan menghapus data?");
        if (c)
            $(this)
                .parent()
                .parent()
                .remove();
    } else {
        alert("Detail harus ada");
    }
    
});

var substringMatcher = function(strs) {
    return function findMatches(q, cb) {
        var matches, substringRegex;

        // an array that will be populated with substring matches
        matches = [];

        // regex used to determine if a string contains the substring `q`
        substrRegex = new RegExp(q, "i");

        // iterate through the pool of strings and for any string that
        // contains the substring `q`, add it to the `matches` array
        $.each(strs, function(i, str) {
            if (substrRegex.test(str)) {
                matches.push(str);
            }
        });

        cb(matches);
    };
};

var states = $("#stored-val").data("val");

// console.log($('#stored-val').data('val'))

$(".typeahead").typeahead(
    {
        hint: true,
        highlight: true,
        minLength: 1
    },
    {
        name: "states",
        source: substringMatcher(states)
    }
);

$(document).on("click", ".radio-respond", function() {
    if ($(this).val() == "forward") {
        $("#forward-to").css("display", "");
    } else {
        $("#forward-to").css("display", "none");
    }
});

$(".add-detail-penawaran").on("click", function() {
    
    penawaranRow += 1;
    let parent = $(this)
        .parent()
        .parent();
    parent
        .find("tbody")
        .append("<tr>" + parent.find("tr:last").html() + "</tr>");
    parent.find("tr:last td").each(function() {
        $(this).val("");
    });
    parent.find(".row-total").appendTo(parent.find("tbody"));
    parent.find(".id_tes:last").val(penawaranRow);
    html = '<div class="penawaran-file-div"';
    html +=
        '<button class="btn btn-danger penawaran-file-button btn-xs waves-effect waves-classic modal-select2-show waves-effect waves-classic" type="button" disabled="">';
    html += "Delete";
    html += "</button>";
    html +=
        '<input class="penawaran-file first-only" type="file" name="penawaran_file_' +
        penawaranRow +
        '[]">';
    html += "</div>";
    $(".penawaran-file-td:last .td-input-file").html(html);
    
});

$(document).on("click", ".delete-detail-penawaran", function() {
    
    // alert($('#table-body tr').length)
    let parent = $(this)
        .parent()
        .parent()
        .parent()
        .parent();
    // console.log(parent.html())
    if (parent.find("tbody tr").length > 1) {
        // alert("Detailsss")
        let c = confirm("Apakah yakin akan menghapus data?");
        if (c)
            $(this)
                .parent()
                .parent()
                .remove();
    } else {
        alert("Detail harus ada");
    }
    
});

$(document).on("change", ".penawaran-file", function() {
    if ($(this).val() && $(this).hasClass("first-only")) {
        let html =
            '<div class="penawaran-file-div"><button class="penawaran-file-button btn btn-danger btn-xs waves-effect waves-classic modal-select2-show waves-effect waves-classic" type="button" disabled>Delete</button>';
        html +=
            '<input class="penawaran-file first-only" type="file" name="penawaran_file_' +
            penawaranRow +
            '[]"></div>';

        let parent_td = $(this)
            .parent()
            .parent();
        let parent_div = $(this).parent();

        $(this).removeClass("first-only");
        parent_td.find(".penawaran-file-div").each(function() {
            $(this)
                .find("button")
                .removeAttr("disabled");
        });

        parent_td.append(html);
    }
    
});

$(document).on("click", ".penawaran-file-button", function() {
    let parent_div = $(this).parent();
    parent_div.remove();
});

$("#submit-master").click(function(e) {
    let pass = true;
    let data = $("#form-rb").serializeArray();

    //let jumlahDisetujui = $(".jumlah_total_" + draftRBDetailID).val();
    let jumlahDisetujui = parseFloat($(".jumlah_total_" + draftRBDetailID).autoNumeric('get'))
    let jumlahDisetujuiDetail = 0;
    $(".jumlah-detail-" + draftRBDetailID).each(function(index, element) {
        jumlahDisetujuiDetail+=parseFloat($(this).autoNumeric('get'))
    });

    console.log(jumlahDisetujui,jumlahDisetujuiDetail,jumlahDisetujuiDetail == jumlahDisetujui);
    if (jumlahDisetujuiDetail != jumlahDisetujui) {
        alert("Jumlah detail per supplier tidak sesuai");
    }else{

        data.forEach(element => {
            if (
                element.value == "" &&
                !element.name.includes("kode_supplier") &&
                element.value == "" && !element.name.includes("Pemohon") &&
                element.value == "" && !element.name.includes("user_forward") &&
                element.value == "" && !element.name.includes("keterangan") &&
                element.value == "" && !element.name.includes("note") &&
                element.value == "" && !element.name.includes("inventaris_barang")
            ) {
                pass = false;
            }
        });
        if (pass) {
            $("#form-rb").submit();
        } else {
            console.log(data);
            alert("data belum lengkap");
        }
    }
    
});

$(".view-detail").click(function(e) {
    let id = $(this).data("id");
    draftRBDetailID = id;
});

// $('#penawaran-file').filepond({
//     allowMultiple: true,
//     server: {
//         process: 'rb/doSubmitRB'
//     }
// })

// $(document).find('#form-rb').dropzone({
//     autoProcessQueue: false,
//     parallelUploads: 10,
//     addRemoveLinks: true,
//     // url: "/purchasing/rb/doSubmitRB"
// })
