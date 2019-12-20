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
