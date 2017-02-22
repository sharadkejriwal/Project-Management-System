$(document).ready(function() {
	getCors();
	
	$("#addcors").click(function(e) {
		$("#frmaddcors")[0].reset();
		$("#corsaddmess").hide();
		$("#addpanel").fadeToggle(500);
		$("#txtaddcorsprojno").focus();
	});
	

	$("#frmviewcors").submit(function(e) {
		$("#frmviewcors")[0].reset();
		var corsViewMess = $("corsviewmess");
		corsViewMess.html('');
		corsViewMess.hide();
		$("#viewpanel").fadeOut();
		return false;
	});
	
	$("#frmupdcors").submit(function(e) {
		updCors(e);
		return false;
	});
	
	$("#frmdelcors").submit(function(e) {
		delCors(e);
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

function getCors() {
	var data = {
		"action" : "getcors"
	};
	data = $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "courseajax.php",
		data: data,
		beforeSend: function() {
			var corsContent = "";
			corsContent += "<tr>";
			corsContent += "<td colspan=\"5\" class=\"loading\">Loading...</td>";
			corsContent += "</tr>";
			$("#cors").html(corsContent);
		},
		error: function() {
			var corsContent = "";
			corsContent += "<tr><td colspan=\"5\" class=\"error\">Oops! Failed to load Projects</td></tr>";
			$("#cors").html(corsContent);
		},
		success: function(retData) {
			corsJson = JSON.parse(retData);
			var res = corsJson["result"];
			corsJson = corsJson["data"];
			var corsContent = "";
			var corsTbl = $("#cors");
			
			if (res === "success") {
				corsContent += "<thead><tr><th>Project No.</th>";
				corsContent += "<th>Title</th><th>Department</th>";
				corsContent += "<th>Investigator</th>";
				corsContent += "<th>Options</th></tr></thead><tbody>";
				if (corsJson.length === 0)
					corsContent += "<tr><td colspan=\"5\" class=\"loading\">There are no Projects</td></tr>";
				else
				{
					for (var i = 0; i < corsJson.length; i++)
					{
						corsContent += "<tr><td>" + corsJson[i]['proj_no'] + "</td>";
						corsContent += "<td>" + corsJson[i]['title'] + "</td>";
						corsContent += "<td>" + (corsJson[i]['dept'] ? corsJson[i]['dept'] : '---'); + "</td>";
						corsContent += "<td>" + (corsJson[i]['investigator'] ? corsJson[i]['investigator'] : '---');
						corsContent += "</td><td><a href=\"addstud/?proj_no=" + corsJson[i]['proj_no']
							+ "\" class=\"projno\">Student</a> | ";
						corsContent += "<a href=\"#\" class=\"view\">View</a>";
						corsContent += "<a href=\"#\" class=\"upd\">Update</a>";
						corsContent += "<a href=\"#\" class=\"del\">Delete</a></td></tr>";
					}
				}
				corsContent += "</tbody>";
			}
			else {
				corsContent += "<tr><td colspan=\"5\" class=\"error\">" + corsJson + "</td></tr>";
			}
			
			corsTbl.hide();
			corsTbl.html(corsContent);
			corsTbl.fadeIn(500);
			
			if (res === "success") {
				$("#cors tr td .view").click(function(e) {
					$("#frmviewcors")[0].reset();
					$("#corsviewmess").hide();
					$("#viewpanel").fadeToggle(500);
					fillViewPopup(e);
				});

				$("#cors tr td .upd").click(function(e) {
					$("#frmupdcors")[0].reset();
					$("#corsupdmess").hide();
					$("#updpanel").fadeToggle(500);
					$("#txtupdcorsprojno").focus();
					fillUpdPopup(e);
				});

				$("#cors tr td .del").click(function(e) {
					$("#frmdelcors")[0].reset();
					$("#corsdelmess").html("Do you want to delete the project ?");
					$("#corsdelmess").css('background', 'red');
					$("#corsdelmess").show();
					$("#delpanel").fadeToggle(500);
					fillDelPopup(e);
				});
				
			}
		}
	});
	return false;
}

function fillUpdPopup(e) {
	var txtCorsProjNo = $("#txtupdprojno");
	var txtCorsProjTitle=$("#txtupdprojtitle");
	var txtCorsProjDesc=$("#txtupdprojdesc");
	var txtCorsProjStDate=$("#txtupdprojstartdate");
	var txtCorsProjFnDate=$("#txtupdprojfinishdate");
	var txtCorsProjCompDate=$("#txtupdprojcompdate");
	var txtCorsDept=$("#txtupdcorsdept");
	var txtCorsInvst=$("#txtupdcorsinvst");
	
	var txtOldCorsProjNo = $("#txtoldcorsprojno");

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

	txtCorsProjNo.val(corsJson[i]["proj_no"]);
	txtCorsProjTitle.val(corsJson[i]["title"]);
	txtCorsProjDesc.val(corsJson[i]["description"]);
	txtCorsProjStDate.val(corsJson[i]["start_date"]);
	txtCorsProjFnDate.val(corsJson[i]["finish_date"]);
	txtCorsProjCompDate.val(corsJson[i]["completed_on"]);
	txtCorsDept.val(corsJson[i]["dept"]);
	txtCorsInvst.val(corsJson[i]["investigator"]);
	
	for (var j = 0; j < corsJson[i]['sem'].length; j++) {
		var s = corsJson[i]['sem'][j];
		$("#chkupdsem" + s).prop('checked', true);
	}
	
	txtOldCorsProjNo.val(corsJson[i]["proj_no"]);
	
}

function updCors(e) {
	var data = {
		"action" : "updcors"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "courseajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var corsUpdMess = $("#corsupdmess");
			innerHtml += "Updating...";
			corsUpdMess.html(innerHtml);
			corsUpdMess.css('background', 'blue');
			corsUpdMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var corsUpdMess = $("#corsupdmess");
			innerHtml += "Failed to update project";
			corsUpdMess.html(innerHtml);
			corsUpdMess.css('background', 'red');
			corsUpdMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var corsUpdMess = $("#corsupdmess");
			corsUpdMess.html(retJson);
			
			if (res === "success") {
				corsUpdMess.css('background', 'green');
				setTimeout(function() {
					$("#frmupdcors")[0].reset();
					corsUpdMess.html('');
					corsUpdMess.hide();
					$("#updpanel").fadeOut(500);
					getCors();
				}, 2000);
			}
			else if(res === "failed") {
				corsUpdMess.css('background', 'red');
			}
			else {
				corsUpdMess.css('background', 'red');
			}
			corsUpdMess.fadeIn(500);
		}
	});
}

function fillDelPopup(e) {
	var txtCorsProjNo = $("#txtdelprojno");
	var txtCorsProjTitle=$("#txtdelprojtitle");
	var txtCorsProjDesc=$("#txtdelprojdesc");
	var txtCorsProjStDate=$("#txtdelprojstartdate");
	var txtCorsProjFnDate=$("#txtdelprojfinishdate");
	var txtCorsProjCompDate=$("#txtdelprojcompdate");
	var txtCorsDept=$("#txtdelcorsdept");
	var txtCorsInvst=$("#txtdelcorsinvst");

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

	txtCorsProjNo.val(corsJson[i]["proj_no"]);
	txtCorsProjNo.prop('readonly', true);
	txtCorsProjTitle.val(corsJson[i]["title"]);
	txtCorsProjTitle.prop('readonly',true);
	txtCorsProjDesc.val(corsJson[i]["description"]);
	txtCorsProjDesc.prop('readonly',true);
	txtCorsProjStDate.val(corsJson[i]["start_date"]);
	txtCorsProjStDate.prop('readonly',true);
	txtCorsProjFnDate.val(corsJson[i]["finish_date"]);
	txtCorsProjFnDate.prop('readonly',true);
	txtCorsProjCompDate.val(corsJson[i]["completed_on"]);
	txtCorsProjCompDate.prop('readonly',true);
	txtCorsDept.val(corsJson[i]["dept"]);
	txtCorsDept.prop('readonly', true);
	txtCorsInvst.val(corsJson[i]["investigator"]);
	txtCorsInvst.prop('readonly', true);
	
	for (var j = 0; j < corsJson[i]['sem'].length; j++) {
		var s = corsJson[i]['sem'][j];
		$("#chkdelsem" + s).prop('checked', true);
	}
	for (var j = 1; j < 11; j++) {
		$("#chkdelsem" + j).click(function() {
			return false;
		});
	}
	
}

function delCors(e) {
	var data = {
		"action" : "delcors"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "courseajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var corsDelMess = $("#corsdelmess");
			innerHtml += "Deleting...";
			corsDelMess.html(innerHtml);
			corsDelMess.css('background', 'blue');
			corsDelMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var corsDelMess = $("#corsdelmess");
			innerHtml += "Failed to delete department";
			corsDelMess.html(innerHtml);
			corsDelMess.css('background', 'red');
			corsDelMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var corsDelMess = $("#corsdelmess");
			corsDelMess.html(retJson);
			
			if (res === "success") {
				corsDelMess.css('background', 'green');
				setTimeout(function() {
					$("#frmdelcors")[0].reset();
					corsDelMess.html('');
					corsDelMess.hide();
					$("#delpanel").fadeOut(500);
					getCors();
				}, 2000);
			}
			else if(res === "failed") {
				corsDelMess.css('background', 'red');
			}
			else {
				corsDelMess.css('background', 'red');
			}
			corsDelMess.fadeIn(500);
		}
	});
}

function fillViewPopup(e) {
	var txtCorsProjNo = $("#txtviewprojno");
	var txtCorsProjTitle=$("#txtviewprojtitle");
	var txtCorsProjDesc=$("#txtviewprojdesc");
	var txtCorsProjStDate=$("#txtviewprojstartdate");
	var txtCorsProjFnDate=$("#txtviewprojfinishdate");
	var txtCorsProjCompDate=$("#txtviewprojcompdate");
	var txtCorsDept=$("#txtviewcorsdept");
	var txtCorsInvst=$("#txtviewcorsinvst");

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

	txtCorsProjNo.val(corsJson[i]["proj_no"]);
	txtCorsProjNo.prop('readonly', true);
	txtCorsProjTitle.val(corsJson[i]["title"]);
	txtCorsProjTitle.prop('readonly',true);
	txtCorsProjDesc.val(corsJson[i]["description"]);
	txtCorsProjDesc.prop('readonly',true);
	txtCorsProjStDate.val(corsJson[i]["start_date"]);
	txtCorsProjStDate.prop('readonly',true);
	txtCorsProjFnDate.val(corsJson[i]["finish_date"]);
	txtCorsProjFnDate.prop('readonly',true);
	txtCorsProjCompDate.val(corsJson[i]["completed_on"]);
	txtCorsProjCompDate.prop('readonly',true);
	txtCorsDept.val(corsJson[i]["dept"]);
	txtCorsDept.prop('readonly', true);
	txtCorsInvst.val(corsJson[i]["investigator"]);
	txtCorsInvst.prop('readonly', true);
	
	for (var j = 0; j < corsJson[i]['sem'].length; j++) {
		var s = corsJson[i]['sem'][j];
		$("#chksem" + s).prop('checked', true);
	}
	
	for (var j = 1; j < 11; j++) {
		$("#chksem" + j).click(function() {
			return false;
		});
	}
}