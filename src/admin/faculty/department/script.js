$(document).ready(function () {
	getAllDept();
	getDept();
	
	$("#adddept").click(function(e) {
		$("#frmadddept")[0].reset();
		$("#deptaddmess").hide();
		$("#addpanel").fadeToggle(500);
		$("#txtadddeptid").focus();
	});
	
	$("#frmadddept").submit(function(e) {
		addDept(e);
		return false;
	});
	
	$("#frmupddept").submit(function(e) {
		updDept(e);
		return false;
	});
	
	$("#frmdeldept").submit(function(e) {
		delDept(e);
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

function getDept() {
	var data = {
		"action" : "getdept",
		"faculty_id" : fcltId
	};
	data = $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "deptajax.php",
		data: data,
		beforeSend: function() {
			var deptContent = "";
			deptContent += "<tr>";
			deptContent += "<td colspan=\"3\" class=\"loading\">Loading...</td>";
			deptContent += "</tr>";
			$("#dept").html(deptContent);
		},
		error: function() {
			var deptContent = "";
			deptContent += "<tr><td colspan=\"3\" class=\"error\">Oops! Failed to load departments</td></tr>";
			$("#dept").html(deptContent);
		},
		success: function(retData) {
			deptJson = JSON.parse(retData);
			var res = deptJson["result"];
			deptJson = deptJson["data"];
			var deptContent = "";
			var deptTbl = $("#dept");
			
			if (res === "success") {
				deptContent += "<thead><tr><th>Department</th>";
				deptContent += "<th>Time Percent</th>";
				deptContent += "<th>Options</th></tr></thead><tbody>";
				if (deptJson['department'].length === 0)
					deptContent += "<tr><td colspan=\"3\" class=\"loading\">There are no departments</td></tr>";
				else {
					for (var i = 0; i < deptJson['department'].length; i++) {
						var deptName = deptJson['department'][i][0];
						for (var j = 0; j < allDeptJson.length; j++) {
							if (allDeptJson[j]['dept_no'] === deptName) {
								deptName = allDeptJson[j]['name'];
								break;
							}
						}
						
						deptContent += "<tr><td>" + deptName + "</td><td>";
						deptContent += deptJson['department'][i][1] + "</td><td>";
						deptContent += "<a href=\"#\" class=\"upd\">Update</a>";
						deptContent += "<a href=\"#\" class=\"del\">Delete</a></td></tr>";
					}
				}
				deptContent += "</tbody>";
				$("#lblfcltid").html(deptJson['faculty_id']);
				$("#lblfcltname").html(deptJson['name']);
			}
			else if (res === "goback") {
				window.location.href = "..";
			}
			else {
				deptContent += "<tr><td colspan=\"3\" class=\"error\">" + deptJson + "</td></tr>";
			}
			
			deptTbl.hide();
			deptTbl.html(deptContent);
			deptTbl.fadeIn(500);
			
			if (res === "success") {
				
				$("#dept tr td .upd").click(function(e) {
					$("#frmupddept")[0].reset();
					$("#deptupdmess").hide();
					$("#updpanel").fadeToggle(500);
					$("#txtupddeptid").focus();
					fillUpdPopup(e);
				});

				$("#dept tr td .del").click(function(e) {
					$("#frmdeldept")[0].reset();
					$("#deptdelmess").html("Do you want to delete the department ?");
					$("#deptdelmess").css('background', 'red');
					$("#deptdelmess").show();
					$("#delpanel").fadeToggle(500);
					fillDelPopup(e);
				});
			}
		}
	});
	return false;
}

function getAllDept() {
	var data = {
		"action" : "getdept"
	};
	data = $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "../../department/deptajax.php",
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
			if (res === "success") {
				for (var i = 0; i < allDeptJson.length; i++) {
					deptContent += "<option value=\"" + allDeptJson[i]['dept_no'] + "\">";
					deptContent += allDeptJson[i]['name'] + "</option>";
				}
			}
			$("#txtadddeptno").html(deptContent);
			$("#txtupddeptno").html(deptContent);
		}
	});
	return false;
}

function addDept(e) {
	var data = {
		"action" : "adddept",
		"txtaddfcltid" : fcltId
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "deptajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var deptAddMess = $("#deptaddmess");
			innerHtml += "Adding...";
			deptAddMess.html(innerHtml);
			deptAddMess.css('background', 'blue');
			deptAddMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var deptAddMess = $("#deptaddmess");
			innerHtml += "Failed to add department";
			deptAddMess.html(innerHtml);
			deptAddMess.css('background', 'red');
			deptAddMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var deptAddMess = $("#deptaddmess");
			deptAddMess.html(retJson);
			
			if (res === "success") {
				deptAddMess.css('background', 'green');
				setTimeout(function() {
					$("#frmadddept")[0].reset();
					deptAddMess.html('');
					deptAddMess.hide();
					$("#addpanel").fadeOut();
					getDept();
				}, 2000);
			}
			else if(res === "failed") {
				deptAddMess.css('background', 'red');
			}
			else {
				deptAddMess.css('background', 'red');
			}
			deptAddMess.fadeIn(500);
		}
	});
}

function fillUpdPopup(e) {
	var txtDeptNo = $("#txtupddeptno");
	var txtTime = $("#txtupdtime");
	var txtOldDeptNo = $("#txtolddeptno");
	
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

	$('#txtupddeptno option[value="' + deptJson['department'][i][0] + '"]')
		.prop('selected', true);
	txtDeptNo.val(deptJson["department"][i][0]);
	txtTime.val(deptJson["department"][i][1]);
	txtOldDeptNo.val(deptJson["department"][i][0]);
}

function updDept(e) {
	var data = {
		"action" : "upddept",
		"txtupdfcltid" : fcltId
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "deptajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var deptUpdMess = $("#deptupdmess");
			innerHtml += "Updating...";
			deptUpdMess.html(innerHtml);
			deptUpdMess.css('background', 'blue');
			deptUpdMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var deptUpdMess = $("#deptupdmess");
			innerHtml += "Failed to update department";
			deptUpdMess.html(innerHtml);
			deptUpdMess.css('background', 'red');
			deptUpdMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var deptUpdMess = $("#deptupdmess");
			deptUpdMess.html(retJson);
			
			if (res === "success") {
				deptUpdMess.css('background', 'green');
				setTimeout(function() {
					$("#frmupddept")[0].reset();
					deptUpdMess.html('');
					deptUpdMess.hide();
					$("#updpanel").fadeOut(500);
					getDept();
				}, 2000);
			}
			else if(res === "failed") {
				deptUpdMess.css('background', 'red');
			}
			else {
				deptUpdMess.css('background', 'red');
			}
			deptUpdMess.fadeIn(500);
		}
	});
}

function fillDelPopup(e) {
	var txtDeptNo = $("#txtdeldeptno");
	var txtTime = $("#txtdeltime");
	
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

	txtDeptNo.val(deptJson["department"][i][0]);
	txtDeptNo.prop('readonly', true);
	txtTime.val(deptJson["department"][i][1]);
	txtTime.prop('readonly', true);
}

function delDept(e) {
	var data = {
		"action" : "deldept",
		"txtdelfcltid" : fcltId
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "deptajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var deptDelMess = $("#deptdelmess");
			innerHtml += "Deleting...";
			deptDelMess.html(innerHtml);
			deptDelMess.css('background', 'blue');
			deptDelMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var deptDelMess = $("#deptdelmess");
			innerHtml += "Failed to delete department";
			deptDelMess.html(innerHtml);
			deptDelMess.css('background', 'red');
			deptDelMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var deptDelMess = $("#deptdelmess");
			deptDelMess.html(retJson);
			
			if (res === "success") {
				deptDelMess.css('background', 'green');
				setTimeout(function() {
					$("#frmdeldept")[0].reset();
					deptDelMess.html('');
					deptDelMess.hide();
					$("#delpanel").fadeOut(500);
					getDept();
				}, 2000);
			}
			else if(res === "failed") {
				deptDelMess.css('background', 'red');
			}
			else {
				deptDelMess.css('background', 'red');
			}
			deptDelMess.fadeIn(500);
		}
	});
}