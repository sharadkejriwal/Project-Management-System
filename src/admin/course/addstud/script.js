$(document).ready(function () {
	getstud();
	
	$("#addstud").click(function(e) {
		$("#frmaddstud")[0].reset();
		$("#studaddmess").hide();
		$("#addpanel").fadeToggle(500);
		$("#txtaddstudid").focus();
	});
	
	$("#frmaddstud").submit(function(e) {
		addstud(e);
		return false;
	});
	
	$("#frmupdstud").submit(function(e) {
		updstud(e);
		return false;
	});
	
	$("#frmdelstud").submit(function(e) {
		delstud(e);
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

function getstud() {
	var data = {
		"action" : "getstud",
		"proj_no" : projno
	};
	data = $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "addstudajax.php",
		data: data,
		beforeSend: function() {
			var studContent = "";
			studContent += "<tr>";
			studContent += "<td colspan=\"3\" class=\"loading\">Loading...</td>";
			studContent += "</tr>";
			$("#stud").html(studContent);
		},
		error: function() {
			var studContent = "";
			studContent += "<tr><td colspan=\"3\" class=\"error\">Oops! Failed to load students</td></tr>";
			$("#stud").html(studContent);
		},
		success: function(retData) {
			studJson = JSON.parse(retData);
			var res = studJson["result"];
			studJson = studJson["data"];
			var studContent = "";
			var studTbl = $("#stud");
			
			if (res === "success") {
				studContent += "<thead><tr><th>Scholar Number</th>";
				studContent += "<th>Investigator</th>";
				studContent += "<th>Options</th></tr></thead><tbody>";
				if (studJson['student'].length === 0)
					studContent += "<tr><td colspan=\"3\" class=\"loading\">There are no students</td></tr>";
				else {
					for (var i = 0; i < studJson['student'].length; i++) {
						studContent += "<tr><td>" + studJson['student'][i][0] + "</td><td>";
						studContent += studJson['student'][i][1] + "</td><td>";
						studContent += "<a href=\"#\" class=\"upd\">Update</a>";
						studContent += "<a href=\"#\" class=\"del\">Delete</a></td></tr>";
					}
				}
				studContent += "</tbody>";
				$("#lblprojno").html(studJson['proj_no']);
				$("#lblprojtitle").html(studJson['title']);
			}
			else if (res === "goback") {
				window.location.href = "..";
			}
			else {
				studContent += "<tr><td colspan=\"3\" class=\"error\">" + studJson + "</td></tr>";
			}
			
			studTbl.hide();
			studTbl.html(studContent);
			studTbl.fadeIn(500);
			
			if (res === "success") {
				
				$("#stud tr td .upd").click(function(e) {
					$("#frmupdstud")[0].reset();
					$("#studupdmess").hide();
					$("#updpanel").fadeToggle(500);
					$("#txtupdstudid").focus();
					fillUpdPopup(e);
				});

				$("#stud tr td .del").click(function(e) {
					$("#frmdelstud")[0].reset();
					$("#studdelmess").html("Do you want to delete the student ?");
					$("#studdelmess").css('background', 'red');
					$("#studdelmess").show();
					$("#delpanel").fadeToggle(500);
					fillDelPopup(e);
				});
			}
		}
	});
	return false;
}

function addstud(e) {
	var data = {
		"action" : "addstud",
		"txtaddprojno" : projno
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "addstudajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var studAddMess = $("#studaddmess");
			innerHtml += "Adding...";
			studAddMess.html(innerHtml);
			studAddMess.css('background', 'blue');
			studAddMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var studAddMess = $("#studaddmess");
			innerHtml += "Failed to add student";
			studAddMess.html(innerHtml);
			studAddMess.css('background', 'red');
			studAddMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var studAddMess = $("#studaddmess");
			studAddMess.html(retJson);
			
			if (res === "success") {
				studAddMess.css('background', 'green');
				setTimeout(function() {
					$("#frmaddstud")[0].reset();
					studAddMess.html('');
					studAddMess.hide();
					$("#addpanel").fadeOut();
					getstud();
				}, 2000);
			}
			else if(res === "failed") {
				studAddMess.css('background', 'red');
			}
			else {
				studAddMess.css('background', 'red');
			}
			studAddMess.fadeIn(500);
		}
	});
}

function fillUpdPopup(e) {
	var txtschNo = $("#txtupdschno");
	var txtInvst = $("#txtupdinvst");
	var txtOldschNo = $("#txtoldschno");
	
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

	txtschNo.val(studJson["student"][i][0]);
	txtInvst.val(studJson["student"][i][1]);
	txtOldschNo.val(studJson["student"][i][0]);
}

function updstud(e) {
	var data = {
		"action" : "updstud",
		"txtupdprojno" : projno
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "addstudajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var studUpdMess = $("#studupdmess");
			innerHtml += "Updating...";
			studUpdMess.html(innerHtml);
			studUpdMess.css('background', 'blue');
			studUpdMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var studUpdMess = $("#studupdmess");
			innerHtml += "Failed to update student";
			studUpdMess.html(innerHtml);
			studUpdMess.css('background', 'red');
			studUpdMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var studUpdMess = $("#studupdmess");
			studUpdMess.html(retJson);
			
			if (res === "success") {
				studUpdMess.css('background', 'green');
				setTimeout(function() {
					$("#frmupdstud")[0].reset();
					studUpdMess.html('');
					studUpdMess.hide();
					$("#updpanel").fadeOut(500);
					getstud();
				}, 2000);
			}
			else if(res === "failed") {
				studUpdMess.css('background', 'red');
			}
			else {
				studUpdMess.css('background', 'red');
			}
			studUpdMess.fadeIn(500);
		}
	});
}

function fillDelPopup(e) {
	var txtschNo = $("#txtdelschno");
	var txtInvst = $("#txtdelinvst");
	
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

	txtschNo.val(studJson["student"][i][0]);
	txtschNo.prop('readonly', true);
	txtInvst.val(studJson["student"][i][1]);
	txtInvst.prop('readonly', true);
}

function delstud(e) {
	var data = {
		"action" : "delstud",
		"txtdelprojno" : projno
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "addstudajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var studDelMess = $("#studdelmess");
			innerHtml += "Deleting...";
			studDelMess.html(innerHtml);
			studDelMess.css('background', 'blue');
			studDelMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var studDelMess = $("#studdelmess");
			innerHtml += "Failed to delete student";
			studDelMess.html(innerHtml);
			studDelMess.css('background', 'red');
			studDelMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var studDelMess = $("#studdelmess");
			studDelMess.html(retJson);
			
			if (res === "success") {
				studDelMess.css('background', 'green');
				setTimeout(function() {
					$("#frmdelstud")[0].reset();
					studDelMess.html('');
					studDelMess.hide();
					$("#delpanel").fadeOut(500);
					getstud();
				}, 2000);
			}
			else if(res === "failed") {
				studDelMess.css('background', 'red');
			}
			else {
				studDelMess.css('background', 'red');
			}
			studDelMess.fadeIn(500);
		}
	});
}