$(document).ready(function() {
	// let dateNow = $("#TglLahir").data("now");
	$("#TglLahir").datepicker({ format: "dd/mm/yy" });
	// $("#TglLahir").datepicker("setDate", dateNow);
});

$("#save-detail-profile").click(function(e) {
    $.ajax({
        url: "/prfl/SimpanProfil",
        type: "post", //form method
        data: $("#form-profile").serialize(),
        dataType: "json",
        beforeSend: function() {},
        success: function(result) {
        	location.reload();
        },
        complete: function(result) {},
        error: function(xhr, Status, err) {}
    });
});