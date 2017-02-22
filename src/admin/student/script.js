$(document).ready(function() {
	getAllDept();
	getstud();
	
	$("#seldept").change(function() {
		getstud();
	});
	
	$("#addstud").click(function(e) {
		$("#frmaddstud")[0].reset();
		$("#studaddmess").hide();
		$("#addpanel").fadeToggle(500);
		$("#txtaddstudschno").focus();
	});
	
	$("#frmaddstud").submit(function(e) {
		addstud(e);
		return false;
	});

	$("#frmviewstud").submit(function(e) {
		$("#frmviewstud")[0].reset();
		var studViewMess = $("studviewmess");
		studViewMess.html('');
		studViewMess.hide();
		$("#viewpanel").fadeOut();
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

function getAllDept() {
	var data = {
		"action" : "getdept"
	};
	
	data = $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "../department/deptajax.php",
		data: data,
		beforeSend: function() {
		},
		error: function() {
		},
		success: function(retData) {
			allDeptJson = JSON.parse(retData);
			var res = allDeptJson["result"];
			allDeptJson = allDeptJson["data"];
			var deptContent = "<option value=\"\">--select department--</option>";
			var selDeptContent = "<option value=\"\">All departments</option>";
			if (res === "success") {
				for (var i = 0; i < allDeptJson.length; i++) {
					deptContent += "<option value=\"" + allDeptJson[i]['dept_no'] + "\">";
					selDeptContent += "<option value=\"" + allDeptJson[i]['dept_no'] + "\">";
					deptContent += allDeptJson[i]['name'] + "</option>";
					selDeptContent += allDeptJson[i]['name'] + "</option>";
				}
			}
			$("#txtaddstuddept").html(deptContent);
			$("#txtupdstuddept").html(deptContent);
			$("#seldept").html(selDeptContent);
		}
	});
	return false;
}

function getstud() {
	data = {
		"action" : "getstud"
	};
	
	if ($("#seldept").val() != "") {
		data["dept_no"] = $("#seldept").val();
	}
	
	data = $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "studajax.php",
		data: data,
		beforeSend: function() {
			var studContent = "";
			studContent += "<tr>";
			studContent += "<td colspan=\"5\" class=\"loading\">Loading...</td>";
			studContent += "</tr>";
			$("#stud").html(studContent);
		},
		error: function() {
			var studContent = "";
			studContent += "<tr><td colspan=\"5\" class=\"error\">Oops! Failed to load Students</td></tr>";
			$("#stud").html(studContent);
		},
		success: function(retData) {
			studJson = JSON.parse(retData);
			var res = studJson["result"];
			studJson = studJson["data"];
			var studContent = "";
			var studTbl = $("#stud");
			
			if (res === "success") {
				studContent += "<thead><tr><th>Scholar No.</th>";
				studContent += "<th>Name</th><th>Degree</th>";
				// studContent += "<th>Date of Birth</th>";
				studContent += "<th>Department</th>";
				// studContent += "<th>Senior Supervisor(Student)</th>";
				studContent += "<th>Options</th></tr></thead><tbody>";
				if (studJson.length === 0)
					studContent += "<tr><td colspan=\"5\" class=\"loading\">There are no Students</td></tr>";
				else {
					for (var i = 0; i < studJson.length; i++) {
						var deptName = studJson[i]['dept'];
						for (var j = 0; j < allDeptJson.length; j++) {
							if (allDeptJson[j]["dept_no"] === deptName) {
								deptName = allDeptJson[j]["name"];
								break;
							}
						}
						
						studContent += "<tr><td>" + studJson[i]['sch_no'] + "</td>";
						studContent += "<td>" + studJson[i]['name'] + "</td>";
						studContent += "<td>" + studJson[i]['degree'] + "</td>";
						//studContent += "<td>" + studJson[i]['dob'] + "</td>";
						studContent += "<td>" + deptName + "</td>";
						//studContent += "<td>" + studJson[i]['senior'] ? studJson[i]['senior'] : "---" + "</td>";
						studContent += "<td><a href=\"#\" class=\"view\">View</a>";
						studContent += "<a href=\"#\" class=\"upd\">Update</a>";
						studContent += "<a href=\"#\" class=\"del\">Delete</a></td></tr>";
					}
				}
				studContent += "</tbody>";
			}
			else {
				studContent += "<tr><td colspan=\"5\" class=\"error\">" + studJson + "</td></tr>";
			}
			
			studTbl.hide();
			studTbl.html(studContent);
			studTbl.fadeIn(500);
			
			if (res === "success") {
				$("#stud tr td .view").click(function(e) {
					$("#frmviewstud")[0].reset();
					$("#studviewmess").hide();
					$("#viewpanel").fadeToggle(500);
					fillViewPopup(e);
				});

				$("#stud tr td .upd").click(function(e) {
					$("#frmupdstud")[0].reset();
					$("#studupdmess").hide();
					$("#updpanel").fadeToggle(500);
					$("#txtupdstudschno").focus();
					fillUpdPopup(e);
				});

				$("#stud tr td .del").click(function(e) {
					$("#frmdelstud")[0].reset();
					$("#fcltdelmess").html("Do you want to delete the student ?");
					$("#fcltdelmess").css('background', 'red');
					$("#fcltdelmess").show();
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
		"action" : "addstud"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "studajax.php",
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
			innerHtml += "Failed to add department";
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
	var txtstudSchNo = $("#txtupdstudschno");
	var txtstudName = $("#txtupdstudname");
	var txtstudDegree = $("#txtupdstuddeg");
	var txtstudDOB = $("#txtupdstuddob");
	var txtstudDept = $("#txtupdstuddept");
	var txtstudSen = $("#txtupdstudsen");

	var txtOldstudSchNo = $("#txtoldstudschno");
	
	var tblRow = e.target.parentNode.parentNode;
	var rows = tblRow.parentNode.childNodes;
	var rowNum = -1;
	
	for (var i = 0; i < rows.length; i++) {
		if (tblRow === rows[i]) {
			rowNum = i;
			break;
		}
	}

	txtstudSchNo.val(studJson[i]["sch_no"]);
	txtstudName.val(studJson[i]["name"]);
	$("#txtupdstuddeg option[value=\"" + studJson[i]["degree"] + "\"]")
		.prop('selected', true);
	txtstudDOB.val(studJson[i]["dob"]);
	// txtstudDept.val(studJson[i]["dept"]);
	$("#txtupdstuddept option[value=\"" + studJson[i]["dept"] + "\"]")
		.prop('selected', true); 
	txtstudSen.val(studJson[i]["senior"]);

	txtOldstudSchNo.val(studJson[i]["sch_no"]);
}

function updstud(e) {
	var data = {
		"action" : "updstud"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "studajax.php",
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
			innerHtml += "Failed to update department";
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
	var txtstudSchNo = $("#txtdelstudschno");
	var txtstudName = $("#txtdelstudname");
	var txtstudDegree = $("#txtdelstuddeg");
	var txtstudDOB = $("#txtdelstuddob");
	var txtstudDept = $("#txtdelstuddept");
	var txtstudSen = $("#txtdelstudsen");

	var tblRow = e.target.parentNode.parentNode;
	var rows = tblRow.parentNode.childNodes;
	var rowNum = -1;
	
	for (var i = 0; i < rows.length; i++) {
		if (tblRow === rows[i]) {
			rowNum = i;
			break;
		}
	}

	txtstudSchNo.val(studJson[i]["sch_no"]);
	txtstudSchNo.prop('readonly', true);
	txtstudName.val(studJson[i]["name"]);
	txtstudName.prop('readonly', true);
	txtstudDegree.val(studJson[i]["degree"]);
	txtstudDegree.prop('readonly', true);
	txtstudDOB.val(studJson[i]["dob"]);
	txtstudDOB.prop('readonly', true);
	
	var deptName = studJson[i]["dept"];
	for (var j = 0; j < allDeptJson.length; j++) {
		if (allDeptJson[j]["dept_no"] === deptName) {
			deptName = allDeptJson[j]["name"];
			break;
		}
	}
	txtstudDept.val(deptName);
	txtstudDept.prop('readonly', true);
	txtstudSen.val(studJson[i]["senior"]);
	txtstudSen.prop('readonly', true);

}

function delstud(e) {
	var data = {
		"action" : "delstud"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "studajax.php",
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
			innerHtml += "Failed to delete department";
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

function fillViewPopup(e) {
	var txtstudSchNo = $("#txtviewstudschno");
	var txtstudName = $("#txtviewstudname");
	var txtstudDegree = $("#txtviewstuddeg");
	var txtstudDOB = $("#txtviewstuddob");
	var txtstudDept = $("#txtviewstuddept");
	var txtstudSen = $("#txtviewstudsen");

	var tblRow = e.target.parentNode.parentNode;
	var rows = tblRow.parentNode.childNodes;
	var rowNum = -1;
	
	for (var i = 0; i < rows.length; i++) {
		if (tblRow === rows[i]) {
			rowNum = i;
			break;
		}
	}

	txtstudSchNo.val(studJson[i]["sch_no"]);
	txtstudSchNo.prop('readonly', true);
	txtstudName.val(studJson[i]["name"]);
	txtstudName.prop('readonly', true);
	txtstudDegree.val(studJson[i]["degree"]);
	txtstudDegree.prop('readonly', true);
	txtstudDOB.val(studJson[i]["dob"]);
	txtstudDOB.prop('readonly', true);
	
	var deptName = studJson[i]["dept"];
	for (var i = 0; i < allDeptJson.length; i++) {
		if (allDeptJson[i]["dept_no"] == deptName) {
			deptName = allDeptJson[i]["name"];
			break;
		}
	}
	txtstudDept.val(deptName);
	txtstudDept.prop('readonly', true);
	txtstudSen.val(studJson[i]["senior"]);
	txtstudSen.prop('readonly', true);
}