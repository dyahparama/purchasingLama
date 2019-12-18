var table;
var column_name = $(document).find('#datatable1 > thead > tr');

$(document).ready(function(){
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

	var states = ['Alabama', 'Alaska', 'Arizona', 'Arkansas', 'California',
	  'Colorado', 'Connecticut', 'Delaware', 'Florida', 'Georgia', 'Hawaii',
	  'Idaho', 'Illinois', 'Indiana', 'Iowa', 'Kansas', 'Kentucky', 'Louisiana',
	  'Maine', 'Maryland', 'Massachusetts', 'Michigan', 'Minnesota',
	  'Mississippi', 'Missouri', 'Montana', 'Nebraska', 'Nevada', 'New Hampshire',
	  'New Jersey', 'New Mexico', 'New York', 'North Carolina', 'North Dakota',
	  'Ohio', 'Oklahoma', 'Oregon', 'Pennsylvania', 'Rhode Island',
	  'South Carolina', 'South Dakota', 'Tennessee', 'Texas', 'Utah', 'Vermont',
	  'Virginia', 'Washington', 'West Virginia', 'Wisconsin', 'Wyoming'
	];

	$('#kodeDraftRb').typeahead({
	  hint: true,
	  highlight: true,
	  minLength: 1
	},
	{
	  name: 'states',
	  source: substringMatcher(states)
	});

	table = $('#datatable1').DataTable({
		'language': {
            'lengthMenu': 'Tampilkan _MENU_ data per halaman',
            'zeroRecords': 'Maaf data tidak ditemukan',
            'info': 'Menampilkan halaman _PAGE_ dari _PAGES_ halaman',
            'infoEmpty': 'Tidak ada data',
            // <%-- 'processing':  'Sedang memproses permintaan anda...', --%>
            'processing':  '<img src="{$ThemeDir}/img/spinner.gif"></img>',
            'infoFiltered': '(filter dari _MAX_ total data)',
            'searchPlaceholder': 'Cari data ?',
            'paginate': {
		        'first': 'Pertama',
		        'last': 'Terakhir',
		        'next': 'Selanjutnya',
		        'previous': 'Sebelumnya'
		    }
        },
		'processing': true,
		'serverSide': true,
		'responsive': true,
		'columnDefs': [{
			'className': 'dt-center', 'targets': '_all',
			'targets': [4,5],
			'orderable': false
		}],
		'order': [[0,'desc']],
		// <%-- 'pagingType': 'full_numbers', --%>
		// <%-- 'lengthMenu'    : [5, 10, 15, 20], --%>
		'paging': true,
		'ajax': {
			'url' : '{$Link}{$url}'
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