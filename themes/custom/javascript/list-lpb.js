var table;
let baseURL=$("#baseURL").data("url");
var uri_segment = 'lpb';
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
	var kddrb = getData('kddrb');

	/**get cabang**/
	var kdpo = getData('kdpo');

	/**get kdlpb**/
	var kdlpb = getData('kdlpb');

	/**get kdrb**/
	var kdrb = getData('kdrb');

	/**get vendor**/
	var vendor = getData('vendor');

	// ---- end of list data ---

	// fill data into form filter
	/**kode draft rb autcomplete**/
	$('#kodeDraftRb').typeahead({
		  hint: true,
		  highlight: true,
		  minLength: 1
		},
		{
		  name: 'kddrb',
		  source: substringMatcher(kddrb)
	});

	/**kode lpb autcomplete**/
	$('#kodeLpb').typeahead({
		  hint: true,
		  highlight: true,
		  minLength: 1
		},
		{
		  name: 'kdlpb',
		  source: substringMatcher(kdlpb)
	});

	/**kode po autcomplete**/
	$('#kodePo').typeahead({
		  hint: true,
		  highlight: true,
		  minLength: 1
		},
		{
		  name: 'kdpo',
		  source: substringMatcher(kdpo)
	});

	/**kode rb autcomplete**/
	$('#kodeRb').typeahead({
		  hint: true,
		  highlight: true,
		  minLength: 1
		},
		{
		  name: 'kdrb',
		  source: substringMatcher(kdrb)
	});



	/**fill vendor dropdown (select2)**/
	$.each(vendor, function(idx, data){
		var newOption = new Option(data, idx, false, false);
		$('#vendor').append(newOption).trigger('change');
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
		'columnDefs': [
			{
				targets: 6,
				orderable: false
			}
		],
		// 'responsive': true,
		// 'columnDefs': [{
		// 	targets: 7,
		// 	render: $.fn.dataTable.render.ellipsis( 25, true )
		// }],
		// 'order': [[0,'desc']],
		// <%-- 'pagingType': 'full_numbers', --%>
		// <%-- 'lengthMenu'    : [5, 10, 15, 20], --%>
		'paging': true,
		'ajax': {
			'url' : baseURL+uri_segment+"/searchlpb/",
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
