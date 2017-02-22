$(document).ready(function() {
	getcmmn();	

	$("#frmviewcmmn").submit(function(e) {
		$("#frmviewcmmn")[0].reset();
		var cmmnViewMess = $("cmmnviewmess");
		cmmnViewMess.html('');
		cmmnViewMess.hide();
		$("#viewpanel").fadeOut();
		return false;
	});
	
	$("#frmupdcmmn").submit(function(e) {
		updcmmn(e);
		return false;
	});
	
	$("#frmdelcmmn").submit(function(e) {
		delcmmn(e);
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

function getcmmn() {
	var data = {
		"action" : "getcmmn"
	};
	data = $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "commonajax.php",
		data: data,
		beforeSend: function() {
			var cmmnContent = "";
			cmmnContent += "<tr>";
			cmmnContent += "<td colspan=\"5\" class=\"loading\">Loading...</td>";
			cmmnContent += "</tr>";
			$("#cmmn").html(cmmnContent);
		},
		error: function() {
			var cmmnContent = "";
			cmmnContent += "<tr><td colspan=\"5\" class=\"error\">Oops! Failed to load Projects</td></tr>";
			$("#cmmn").html(cmmnContent);
		},
		success: function(retData) {
			cmmnJson = JSON.parse(retData);
			var res = cmmnJson["result"];
			cmmnJson = cmmnJson["data"];
			var cmmnContent = "";
			var cmmnTbl = $("#cmmn");
			
			if (res === "success") {
				cmmnContent += "<thead><tr><th>Project No.</th>";
				cmmnContent += "<th>Title</th><th>Department</th>";
				cmmnContent += "<th>Investigator</th>";
				cmmnContent += "<th>Options</th></tr></thead><tbody>";
				if (cmmnJson.length === 0)
					cmmnContent += "<tr><td colspan=\"5\" class=\"loading\">There are no Projects</td></tr>";
				else
				{
					for (var i = 0; i < cmmnJson.length; i++)
					{
						cmmnContent += "<tr><td>" + cmmnJson[i]['proj_no'] + "</td>";
						cmmnContent += "<td>" + cmmnJson[i]['title'] + "</td>";
						cmmnContent += "<td>" + (cmmnJson[i]['dept'] ? cmmnJson[i]['dept'] : '---'); + "</td>";
						cmmnContent += "<td>" + (cmmnJson[i]['investigator'] ? cmmnJson[i]['investigator'] : '---');
						cmmnContent += "</td><td><a href=\"addstud/?proj_no=" + cmmnJson[i]['proj_no']
							+ "\" class=\"projno\">Members</a> | ";
						cmmnContent += "<a href=\"#\" class=\"view\">View</a>";
						cmmnContent += "<a href=\"#\" class=\"upd\">Update</a>";
						cmmnContent += "<a href=\"#\" class=\"del\">Delete</a></td></tr>";
					}
				}
				cmmnContent += "</tbody>";
			}
			else {
				cmmnContent += "<tr><td colspan=\"5\" class=\"error\">" + cmmnJson + "</td></tr>";
			}
			
			cmmnTbl.hide();
			cmmnTbl.html(cmmnContent);
			cmmnTbl.fadeIn(500);
			
			if (res === "success") {
				$("#cmmn tr td .view").click(function(e) {
					$("#frmviewcmmn")[0].reset();
					$("#cmmnviewmess").hide();
					$("#viewpanel").fadeToggle(500);
					fillViewPopup(e);
				});

				$("#cmmn tr td .upd").click(function(e) {
					$("#frmupdcmmn")[0].reset();
					$("#cmmnupdmess").hide();
					$("#updpanel").fadeToggle(500);
					$("#txtupdcmmnprojno").focus();
					fillUpdPopup(e);
				});

				$("#cmmn tr td .del").click(function(e) {
					$("#frmdelcmmn")[0].reset();
					$("#cmmndelmess").html("Do you want to delete the project ?");
					$("#cmmndelmess").css('background', 'red');
					$("#cmmndelmess").show();
					$("#delpanel").fadeToggle(500);
					fillDelPopup(e);
				});
				
			}
		}
	});
	return false;
}

function fillUpdPopup(e) {
	var txtCmmnProjNo = $("#txtupdprojno");
	var txtCmmnProjTitle=$("#txtupdprojtitle");
	var txtCmmnProjDesc=$("#txtupdprojdesc");
	var txtCmmnProjStDate=$("#txtupdprojstartdate");
	var txtCmmnProjFnDate=$("#txtupdprojfinishdate");
	var txtCmmnProjCompDate=$("#txtupdprojcompdate");
	var txtCmmnAmt=$("#txtupdcmmnamt");
	var txtCmmnMjAdv=$("#txtupdcmmnmjadv");
	
	var txtOldCmmnProjNo = $("#txtoldcmmnprojno");

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

	txtCmmnProjNo.val(cmmnJson[i]["proj_no"]);
	txtCmmnProjTitle.val(cmmnJson[i]["title"]);
	txtCmmnProjDesc.val(cmmnJson[i]["description"]);
	txtCmmnProjStDate.val(cmmnJson[i]["start_date"]);
	txtCmmnProjFnDate.val(cmmnJson[i]["finish_date"]);
	txtCmmnProjCompDate.val(cmmnJson[i]["completed_on"]);
	txtCmmnAmt.val(cmmnJson[i]["amount"]);
	txtCmmnMjAdv.val(cmmnJson[i]["major_advisor"]);
	
	
	txtOldCmmnProjNo.val(cmmnJson[i]["proj_no"]);
	
}

function updcmmn(e) {
	var data = {
		"action" : "updcmmn"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "commonajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var cmmnUpdMess = $("#cmmnupdmess");
			innerHtml += "Updating...";
			cmmnUpdMess.html(innerHtml);
			cmmnUpdMess.css('background', 'blue');
			cmmnUpdMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var cmmnUpdMess = $("#cmmnupdmess");
			innerHtml += "Failed to update project";
			cmmnUpdMess.html(innerHtml);
			cmmnUpdMess.css('background', 'red');
			cmmnUpdMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var cmmnUpdMess = $("#cmmnupdmess");
			cmmnUpdMess.html(retJson);
			
			if (res === "success") {
				cmmnUpdMess.css('background', 'green');
				setTimeout(function() {
					$("#frmupdcmmn")[0].reset();
					cmmnUpdMess.html('');
					cmmnUpdMess.hide();
					$("#updpanel").fadeOut(500);
					getcmmn();
				}, 2000);
			}
			else if(res === "failed") {
				cmmnUpdMess.css('background', 'red');
			}
			else {
				cmmnUpdMess.css('background', 'red');
			}
			cmmnUpdMess.fadeIn(500);
		}
	});
}

function fillDelPopup(e) {
	var txtCmmnProjNo = $("#txtdelprojno");
	var txtCmmnProjTitle=$("#txtdelprojtitle");
	var txtCmmnProjDesc=$("#txtdelprojdesc");
	var txtCmmnProjStDate=$("#txtdelprojstartdate");
	var txtCmmnProjFnDate=$("#txtdelprojfinishdate");
	var txtCmmnProjCompDate=$("#txtdelprojcompdate");
	var txtCmmnAmt=$("#txtdelcmmnamt");
	var txtCmmnMjAdv=$("#txtdelcmmnmjadv");

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

	txtCmmnProjNo.val(cmmnJson[i]["proj_no"]);
	txtCmmnProjNo.prop('readonly', true);
	txtCmmnProjTitle.val(cmmnJson[i]["title"]);
	txtCmmnProjTitle.prop('readonly',true);
	txtCmmnProjDesc.val(cmmnJson[i]["description"]);
	txtCmmnProjDesc.prop('readonly',true);
	txtCmmnProjStDate.val(cmmnJson[i]["start_date"]);
	txtCmmnProjStDate.prop('readonly',true);
	txtCmmnProjFnDate.val(cmmnJson[i]["finish_date"]);
	txtCmmnProjFnDate.prop('readonly',true);
	txtCmmnProjCompDate.val(cmmnJson[i]["completed_on"]);
	txtCmmnProjCompDate.prop('readonly',true);
	txtCmmnAmt.val(cmmnJson[i]["amount"]);
	txtCmmnAmt.prop('readonly', true);
	txtCmmnMjAdv.val(cmmnJson[i]["major_advisor"]);
	txtCmmnMjAdv.prop('readonly', true);
	
	
}

function delcmmn(e) {
	var data = {
		"action" : "delcmmn"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "commonajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var cmmnDelMess = $("#cmmndelmess");
			innerHtml += "Deleting...";
			cmmnDelMess.html(innerHtml);
			cmmnDelMess.css('background', 'blue');
			cmmnDelMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var cmmnDelMess = $("#cmmndelmess");
			innerHtml += "Failed to delete department";
			cmmnDelMess.html(innerHtml);
			cmmnDelMess.css('background', 'red');
			cmmnDelMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var cmmnDelMess = $("#cmmndelmess");
			cmmnDelMess.html(retJson);
			
			if (res === "success") {
				cmmnDelMess.css('background', 'green');
				setTimeout(function() {
					$("#frmdelcmmn")[0].reset();
					cmmnDelMess.html('');
					cmmnDelMess.hide();
					$("#delpanel").fadeOut(500);
					getcmmn();
				}, 2000);
			}
			else if(res === "failed") {
				cmmnDelMess.css('background', 'red');
			}
			else {
				cmmnDelMess.css('background', 'red');
			}
			cmmnDelMess.fadeIn(500);
		}
	});
}

function fillViewPopup(e) {
	var txtCmmnProjNo = $("#txtviewprojno");
	var txtCmmnProjTitle=$("#txtviewprojtitle");
	var txtCmmnProjDesc=$("#txtviewprojdesc");
	var txtCmmnProjStDate=$("#txtviewprojstartdate");
	var txtCmmnProjFnDate=$("#txtviewprojfinishdate");
	var txtCmmnProjCompDate=$("#txtviewprojcompdate");
	var txtCmmnAmt=$("#txtviewcmmnamt");
	var txtCmmnMjAdv=$("#txtviewcmmnmjadv");

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

	txtCmmnProjNo.val(cmmnJson[i]["proj_no"]);
	txtCmmnProjNo.prop('readonly', true);
	txtCmmnProjTitle.val(cmmnJson[i]["title"]);
	txtCmmnProjTitle.prop('readonly',true);
	txtCmmnProjDesc.val(cmmnJson[i]["description"]);
	txtCmmnProjDesc.prop('readonly',true);
	txtCmmnProjStDate.val(cmmnJson[i]["start_date"]);
	txtCmmnProjStDate.prop('readonly',true);
	txtCmmnProjFnDate.val(cmmnJson[i]["finish_date"]);
	txtCmmnProjFnDate.prop('readonly',true);
	txtCmmnProjCompDate.val(cmmnJson[i]["completed_on"]);
	txtCmmnProjCompDate.prop('readonly',true);
	txtCmmnAmt.val(cmmnJson[i]["amount"]);
	txtCmmnAmt.prop('readonly', true);
	txtCmmnMjAdv.val(cmmnJson[i]["major_advisor"]);
	txtCmmnMjAdv.prop('readonly', true);
	
}