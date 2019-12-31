const formatCur = {mDec:0, aSep:'.', aDec:','}

$(document).ready(function () {
    $('.autonumeric').each(function(){
        $(this).autoNumeric('init', formatCur)
    })
});

$(document).on("click", "[data-toggle='tab']", function() {
    let link = $(this).attr('aria-controls');
    $('.tab-pane').hide();
    $('#'+link).show();
})
$(document).on('click','.viewpo',function(){
	let link = $(this).attr('idnya');
	let show = $(this).attr('shownya');
	if(show==0){
		$('.showdetail'+link).show();
		$(this).attr('shownya','1');
	}
	if (show==1) {
		$('.showdetail'+link).hide();
		$(this).attr('shownya','0');
	}
});

$(document).on('click','.viewlpb',function(){
	let link = $(this).attr('idnya');
	let show = $(this).attr('shownya');
	if(show==0){
		$('.showdetaillpb'+link).show();
		$(this).attr('shownya','1');
	}
	if (show==1) {
		$('.showdetaillpb'+link).hide();
		$(this).attr('shownya','0');
	}
});

$(document).on('click', '.button-tutup-po', function(){
    let c = confirm("Apakah yakin akan menutup po dan membuat rb baru?")
        if (c)
            window.location.href = $(this).data('po')
})
