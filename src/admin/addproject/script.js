$(document).ready(function() {
	
	$("#radprojcors").click(function () {
		$("#tblcmmn").hide();
		$("#tblcors").show();
	});
	
	$("#radprojcmmn").click(function () {
		$("#tblcors").hide();
		$("#tblcmmn").show();
	});
	
	$("#frmaddproj").submit(function(e) {
		addProj(e);
		return false;
	});
	
});

function addProj(e) {
	
	var data = {
		"action" : "addproj"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "addprojajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var projAddMess = $("#projaddmess");
			innerHtml += "Adding...";
			projAddMess.html(innerHtml);
			projAddMess.css('background', 'blue');
			projAddMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var projAddMess = $("#projaddmess");
			innerHtml += "Failed to add Project";
			projAddMess.html(innerHtml);
			projAddMess.css('background', 'red');
			projAddMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			/* var */res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var projAddMess = $("#projaddmess");
			projAddMess.html(retJson);
			
			if (res === "success") {
				projAddMess.css('background', 'green');
				setTimeout(function() {
					$("#frmaddproj")[0].reset();
					projAddMess.html('');
					projAddMess.fadeOut();
				}, 2000);
			}
			else if(res === "error") {
				projAddMess.css('background', 'red');
			}
			else {
				projAddMess.css('background', 'red');
			}
			projAddMess.fadeIn(500);
		}
	});
	
}