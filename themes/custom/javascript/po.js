// const formatCur = {
//     decimalCharacter: ",",
//     decimalCharacterAlternative: ",",
//     decimalPlaces: 0,
//     digitGroupSeparator: ".",
//     unformatOnHover: false,
//     unformatOnSubmit: true,
//     // currencySymbolPlacement    : AutoNumeric.options.currencySymbolPlacement.suffix,
//     // roundingMethod             : AutoNumeric.options.roundingMethod.halfUpSymmetric,
// }

const formatCur = {mDec:0, aSep:'.', aDec:','}

var table;
let baseURL=$("#baseURL").data("url");
var uri_segment = 'po';
var column_name = $(document).find('#datatable1 > thead > tr');
var cur_status = $(document).find('#cur_status').text();
let id_pemohon = 0;
var params = [];

function getData(jenis, status){
    var data = function () {
        var tmp = null;
        $.ajax({
            'async': false,
            'type': "POST",
            'global': false,
            'dataType': 'json',
            'url': baseURL+uri_segment+"/getData",
            'data': {'jenis': jenis, 'cur_status': status},
            'success': function (data) {
                tmp = data.msg;
            }
        });
        return tmp;
    }();

    return data;
}

$(document).ready(function(){
    // new AutoNumeric.multiple('.autonumeric', formatCur)
    $('.autonumeric').each(function(){
        $(this).autoNumeric('init', formatCur)
    })
    // Submit Form
    $('#form_filter').submit(function(evt, ui){
        evt.preventDefault();
        $(document).find('#filterPanel').parent().addClass('is-collapse');
        params = $(this).serialize();

        table.ajax.reload();
    })

    var substringMatcher = function(strs) {
      return function findMatches(q, cb) {
        var matches, substringRegex;

        // an array that will be populated with substring matches
        matches = [];

        // regex used to determine if a string contains the substring `q`
        substrRegex = new RegExp(q, 'i');

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

    // ---- list data ---
    /**get kdrb**/
    var kdrb = getData('kddrb');

    /**get cabang**/
    var cabang = getData('cbg');

    /**get pemohon**/
    var pemohon = getData('pemohon', cur_status);

    /**get jenis barang**/
    var jbarang = getData('jbarang');

    /**get status**/
    var mstatus = getData('mstatus');

    // ---- end of list data ---

    // fill data into form filter
    /**kode draft rb autcomplete**/
    $('#kodeDraftRb').typeahead({
          hint: true,
          highlight: true,
          minLength: 1
        },
        {
          name: 'kdrb',
          source: substringMatcher(kdrb)
    });

    /**fill cabang/jabatan dropdown (select2)**/
    $.each(cabang, function(idx, data){
        var newOption = new Option(data, idx, false, false);
        $('#jabcab').append(newOption).trigger('change');
    });


    /**fill pemohon dropdown**/
    $.each(pemohon, function(idx, data){
        var newOption = new Option(data, idx, false, false);
        $('#pemohon').append(newOption).trigger('change');
        id_pemohon = idx;
    });

    if (cur_status == 'Me') {
        $('#pemohon').val(id_pemohon).trigger('change');
    }

    /**fill jenis barang dropdown**/
    $.each(jbarang, function(idx, data){
        var newOption = new Option(data, idx, false, false);
        $('#jbarang').append(newOption).trigger('change');
    });

    /**fill status dropdown**/
    $.each(mstatus, function(idx, data){
        var newOption = new Option(data, idx, false, false);
        $('#status').append(newOption).trigger('change');
    });


    // end of fill data into form filter

    table = $('#datatable1').DataTable({
        'language': {
            'lengthMenu': 'Tampilkan _MENU_ data per halaman',
            'zeroRecords': 'Maaf data tidak ditemukan',
            'info': 'Menampilkan halaman _PAGE_ dari _PAGES_ halaman',
            'infoEmpty': 'Tidak ada data',
            'processing':  'Sedang memproses permintaan anda...',
            // 'processing':  '<img src="{$ThemeDir}/img/spinner.gif"></img>',
            'infoFiltered': '(filter dari _MAX_ total data)',
            'searchPlaceholder': 'Cari data ?',
            'paginate': {
                'first': 'Pertama',
                'last': 'Terakhir',
                'next': 'Selanjutnya',
                'previous': 'Sebelumnya'
            }
        },
        'dom': '<"top"l>rt<"bottom"ip><"clear">',
        'processing': true,
        'serverSide': true,
        // 'responsive': true,
        'columnDefs': [
        {
            targets: 7,
            render: $.fn.dataTable.render.ellipsis( 25, true )
        },
        {
            targets: [7,9],
            orderable: false
        }
        ],
        // 'order': [[0,'desc']],
        // <%-- 'pagingType': 'full_numbers', --%>
        // <%-- 'lengthMenu'    : [5, 10, 15, 20], --%>
        'paging': true,
        'ajax': {
            'url' : baseURL+uri_segment+"/searchdrb/",
            'data' : function(d){
                d.filter_record = params;
                d.cur_status = cur_status;
            }
        },
        createdRow: function( row, data, dataIndex ) {
            // Set the data-title attribute
            column_name.find('th').each(function (key, val) {
                $(row).find('td:eq('+parseInt(key)+')')
                    .attr('data-title', $(this).text());
            });
        },
        'deferRender': true
    });
});


var no = 1;
$(document).on('click', "#add-detail-termin", function (e) {
      console.log(no);
      e.preventDefault();
        no++;
        $('#table-termin').append(`
            <tr class="table-row-termin no-`+no+`">
                <td>
                    <input class="form-control tgl" id="tgl-termin" name="tgl-termin[]"
                        data-date-format="dd/mm/yyyy" data-now="$dateNow"
                        data-plugin="datepicker" type="text">
                </td>
                <td>
                    <select name="jenis-termin[]"
                        class="form-control required-field">
                        <option>Pilih Jenis</option>
                        <option value="DP">DP</option>
                        <option value="LPB">LPB</option>
                        <option value="Pelunasan">Pelunasan</option>
                    </select>
                </td>
                <td>
                    <textarea class="form-control" name="keterangan-termin[]"></textarea>
                </td>
                <td>
                    <input name="total-termin[]" class="autonumeric form-control jumlah-termin required-field"
                        value="0" autocomplete="off">
                </td>
                <td>
                    <button
                        class="btn btn-danger delete-row-termin btn-xs waves-effect waves-classic modal-select2-show waves-effect waves-classic"
                        type="button" idremove="`+no+`">
                        Delete
                    </button>
                </td>
            </tr>`);
        $('.tgl').datepicker();
        $('.autonumeric').each(function(){
            $(this).autoNumeric('init', formatCur)
        })
});

$(document).on('click', '.delete-row-termin', function () {
  var idremove = $(this).attr('idremove');
   let jumlahAkhir = 0
  if ($('.table-row-termin').length > 1) {
     $(".no-" + idremove).remove();
      no + 1;
      // max++;
      $('.jumlah-termin').each(function(){
            jumlahAkhir += parseInt($(this).autoNumeric('get'))
        })
        $('#total-akhir-termin-po').autoNumeric('set', jumlahAkhir)
  } else {
    alert("Detail harus ada")
  }
});

$(document).on('keyup', '.jumlah-termin', function(){
     let jumlahAkhir = 0
    $('.jumlah-termin').each(function(){
            jumlahAkhir += parseInt($(this).autoNumeric('get'))
        })
        // $('#total-akhir-termin-po').val(AutoNumeric.format(10000, formatCur))
        // AutoNumeric.set($('#total-akhir-termin-po')[0], jumlahAkhir)
        $('#total-akhir-termin-po').autoNumeric('set', jumlahAkhir)
})



$("#submit-po").click(function(e) {
         $('.autonumeric').each(function(){
            $(this).autoNumeric('get', formatCur)
        })
        let pass = true;
        let data = $("#form-po").serializeArray();
        if ($('#total-akhir-termin-po').val() != $('#total-akhir-po').val()) {
            alert("Jumlah termin tidak sesuai")
            pass = false
        }
        data.forEach(element => {
            if ((element.value == "" && !element.name.includes("satuanid"))
                ) {
                pass = false;
            }
        });
        console.log(data);
        if (pass) {
            $("#form-po").submit();
        } else {
            alert("data belum lengkap");
        }
    });

    $(document).on('click', '.print-po', function () {
        //console.log("xxx");
        $("#printPO-"+$(this).data("id")).modal("show");
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


