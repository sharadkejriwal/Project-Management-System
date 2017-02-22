$(document).ready(function() {
	getCont();
	
	$("#addcont").click(function(e) {
		$("#frmaddcont")[0].reset();
		$("#contaddmess").hide();
		$("#addpanel").fadeToggle(500);
		$("#txtaddcontid").focus();
	});
	
	$("#frmaddcont").submit(function(e) {
		addCont(e);
		return false;
	});
	
	$("#frmupdcont").submit(function(e) {
		updCont(e);
		return false;
	});
	
	$("#frmdelcont").submit(function(e) {
		delCont(e);
		return false;
	});
	
	$(".popup > header > .close").click(function(e) {
		$(e.target.parentNode.parentNode.parentNode).fadeToggle(500);
	});
	
	$(document).mouseup(function (e) {
		var popups = $(".popup");

		for (var i = 0; i < popups.length; i++) {
			popup = popups[i];
			if (!$(e.target).is(popup) &&
				!$.contains(popup, e.target)) {
				$(popup.parentNode).fadeOut();
			}
		}
	});
});

function getCont() {
	var data = {
		"action" : "getcont",
		"faculty_id" : fcltId
	};
	data = $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "contajax.php",
		data: data,
		beforeSend: function() {
			var contContent = "";
			contContent += "<tr>";
			contContent += "<td colspan=\"2\" class=\"loading\">Loading...</td>";
			contContent += "</tr>";
			$("#cont").html(contContent);
		},
		error: function() {
			var contContent = "";
			contContent += "<tr><td colspan=\"2\" class=\"error\">Oops! Failed to load contacts</td></tr>";
			$("#cont").html(contContent);
		},
		success: function(retData) {
			contJson = JSON.parse(retData);
			var res = contJson["result"];
			contJson = contJson["data"];
			var contContent = "";
			var contTbl = $("#cont");
			
			if (res === "success") {
				contContent += "<thead><tr><th>Contact Number</th>";
				contContent += "<th>Options</th></tr></thead><tbody>";
				if (contJson['contact'].length === 0)
					contContent += "<tr><td colspan=\"2\" class=\"loading\">There are no contacts</td></tr>";
				else {
					for (var i = 0; i < contJson['contact'].length; i++) {
						contContent += "<tr><td>" + contJson['contact'][i] + "</td><td>";
						contContent += "<a href=\"#\" class=\"upd\">Update</a>";
						contContent += "<a href=\"#\" class=\"del\">Delete</a></td></tr>";
					}
				}
				contContent += "</tbody>";
				$("#lblfcltid").html(contJson['faculty_id']);
				$("#lblfcltname").html(contJson['name']);
			}
			else if (res === "goback") {
				window.location.href = "..";
			}
			else {
				contContent += "<tr><td colspan=\"2\" class=\"error\">" + contJson + "</td></tr>";
			}
			
			contTbl.hide();
			contTbl.html(contContent);
			contTbl.fadeIn(500);
			
			if (res === "success") {
				
				$("#cont tr td .upd").click(function(e) {
					$("#frmupdcont")[0].reset();
					$("#contupdmess").hide();
					$("#updpanel").fadeToggle(500);
					$("#txtupdcontid").focus();
					fillUpdPopup(e);
				});

				$("#cont tr td .del").click(function(e) {
					$("#frmdelcont")[0].reset();
					$("#contdelmess").html("Do you want to delete the contact ?");
					$("#contdelmess").css('background', 'red');
					$("#contdelmess").show();
					$("#delpanel").fadeToggle(500);
					fillDelPopup(e);
				});
			}
		}
	});
	return false;
}

function addCont(e) {
	var data = {
		"action" : "addcont",
		"txtaddfcltid" : fcltId
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "contajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var contAddMess = $("#contaddmess");
			innerHtml += "Adding...";
			contAddMess.html(innerHtml);
			contAddMess.css('background', 'blue');
			contAddMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var contAddMess = $("#contaddmess");
			innerHtml += "Failed to add contact";
			contAddMess.html(innerHtml);
			contAddMess.css('background', 'red');
			contAddMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var contAddMess = $("#contaddmess");
			contAddMess.html(retJson);
			
			if (res === "success") {
				contAddMess.css('background', 'green');
				setTimeout(function() {
					$("#frmaddcont")[0].reset();
					contAddMess.html('');
					contAddMess.hide();
					$("#addpanel").fadeOut();
					getCont();
				}, 2000);
			}
			else if(res === "failed") {
				contAddMess.css('background', 'red');
			}
			else {
				contAddMess.css('background', 'red');
			}
			contAddMess.fadeIn(500);
		}
	});
}

function fillUpdPopup(e) {
	var txtContNo = $("#txtupdcontno");
	var txtOldContNo = $("#txtoldcontno");
	
	var tblRow = e.target.parentNode.parentNode;
	var rows = tblRow.parentNode.childNodes;
	var rowNum = -1;
	
	for (var i = 0; i < rows.length; i++)
	{
		if (tblRow === rows[i])
		{
			rowNum = i;
			break;
		}
	}

	txtContNo.val(contJson["contact"][i]);
	txtOldContNo.val(contJson["contact"][i]);
}

function updCont(e) {
	var data = {
		"action" : "updcont",
		"txtupdfcltid" : fcltId
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "contajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var contUpdMess = $("#contupdmess");
			innerHtml += "Updating...";
			contUpdMess.html(innerHtml);
			contUpdMess.css('background', 'blue');
			contUpdMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var contUpdMess = $("#contupdmess");
			innerHtml += "Failed to update contact";
			contUpdMess.html(innerHtml);
			contUpdMess.css('background', 'red');
			contUpdMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var contUpdMess = $("#contupdmess");
			contUpdMess.html(retJson);
			
			if (res === "success") {
				contUpdMess.css('background', 'green');
				setTimeout(function() {
					$("#frmupdcont")[0].reset();
					contUpdMess.html('');
					contUpdMess.hide();
					$("#updpanel").fadeOut(500);
					getCont();
				}, 2000);
			}
			else if(res === "failed") {
				contUpdMess.css('background', 'red');
			}
			else {
				contUpdMess.css('background', 'red');
			}
			contUpdMess.fadeIn(500);
		}
	});
}

function fillDelPopup(e) {
	var txtContNo = $("#txtdelcontno");
	
	var tblRow = e.target.parentNode.parentNode;
	var rows = tblRow.parentNode.childNodes;
	var rowNum = -1;
	
	for (var i = 0; i < rows.length; i++)
	{
		if (tblRow === rows[i])
		{
			rowNum = i;
			break;
		}
	}

	txtContNo.val(contJson["contact"][i]);
	txtContNo.prop('readonly', true);
}

function delCont(e) {
	var data = {
		"action" : "delcont",
		"txtdelfcltid" : fcltId
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "contajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var contDelMess = $("#contdelmess");
			innerHtml += "Deleting...";
			contDelMess.html(innerHtml);
			contDelMess.css('background', 'blue');
			contDelMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var contDelMess = $("#contdelmess");
			innerHtml += "Failed to delete contact";
			contDelMess.html(innerHtml);
			contDelMess.css('background', 'red');
			contDelMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var contDelMess = $("#contdelmess");
			contDelMess.html(retJson);
			
			if (res === "success") {
				contDelMess.css('background', 'green');
				setTimeout(function() {
					$("#frmdelcont")[0].reset();
					contDelMess.html('');
					contDelMess.hide();
					$("#delpanel").fadeOut(500);
					getCont();
				}, 2000);
			}
			else if(res === "failed") {
				contDelMess.css('background', 'red');
			}
			else {
				contDelMess.css('background', 'red');
			}
			contDelMess.fadeIn(500);
		}
	});
}