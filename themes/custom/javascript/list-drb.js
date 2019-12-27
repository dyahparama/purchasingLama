var table;
let baseURL=$("#baseURL").data("url");
var uri_segment = 'list-drb';
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
    // Submit Form
    $('#form_filter').submit(function(evt, ui){
    	evt.preventDefault();
    	$(document).find('#filterPanel').parent().addClass('is-collapse');
		$(document).find('.panel-action').removeClass('md-minus').addClass('md-fullscreen');	

    	params = $(this).serialize();

    	table.ajax.reload();
    })

    $(document).on('click', '.panel-action', function(evt, ui){
    	var is_collapse = $(document).find('#filterPanel').parent().hasClass('is-collapse');
    	var panel_action = $(document).find('.panel-action');
    	if (is_collapse) {
    		// alert('is collapse')
    		panel_action.removeClass('md-minus').addClass('md-fullscreen');	
	    	$(document).find('#filterPanel').parent().addClass('is-collapse');
    	}else{
    		// alert('is maximize')
    		panel_action.removeClass('md-fullscreen').addClass('md-minus');	
	    	$(document).find('#filterPanel').parent().removeClass('is-collapse');
    	}
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
	var kdrb = getData('kddrb', cur_status);

	/**get cabang**/
	var cabang = getData('cbg', cur_status);

	/**get pemohon**/
	var pemohon = getData('pemohon', cur_status);

	/**get jenis barang**/
	var jbarang = getData('jbarang',cur_status);

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
	if (cur_status == "Teams") {
		var select = '';
		$.each(pemohon, function(idx, data){
			select += '<optgroup label="' + idx + '">';
			
			var option = '';
			$.each(data, function(idx_pemohon, data_pemohon){
		        option += '<option value="' + idx_pemohon + '">' + data_pemohon + '</option>';
			});

			select += option;
			select += '</optgroup>';
		});

		$('#pemohon').select2('destroy');
		$('#pemohon').append(select);
		$('#pemohon').select2();
	}else{
		$.each(pemohon, function(idx, data){
			var newOption = new Option(data, idx, false, false);
			$('#pemohon').append(newOption).trigger('change');
			id_pemohon = idx;
		});
	}

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
            // 'processing':  'Sedang memproses permintaan anda...',
            'processing':  '<img src="' + baseURL + 'public/_resources/themes/custom/images/spinner.gif"></img>',
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
				targets: [6,7,10],
				orderable: false
			}
		],
		// 'columnDefs': [{
		// 	targets: 7,
		// 	orderable: false
		// }],
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