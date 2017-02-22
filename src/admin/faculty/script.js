$(document).ready(function() {
	getFclt();
	
	$("#addfclt").click(function(e) {
		$("#frmaddfclt")[0].reset();
		$("#fcltaddmess").hide();
		$("#addpanel").fadeToggle(500);
		$("#txtaddfcltid").focus();
	});
	
	$("#frmaddfclt").submit(function(e) {
		addFclt(e);
		return false;
	});
	
	$("#frmviewfclt").submit(function(e) {
		$("#frmviewfclt")[0].reset();
		var fcltViewMess = $("fcltviewmess");
		fcltViewMess.html('');
		fcltViewMess.hide();
		$("#viewpanel").fadeOut();
		return false;
	});
	
	$("#frmupdfclt").submit(function(e) {
		updFclt(e);
		return false;
	});
	
	$("#frmdelfclt").submit(function(e) {
		delFclt(e);
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

function getFclt() {
	var data = {
		"action" : "getfclt"
	};
	data = $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "fcltajax.php",
		data: data,
		beforeSend: function() {
			var fcltContent = "";
			fcltContent += "<tr>";
			fcltContent += "<td colspan=\"6\" class=\"loading\">Loading...</td>";
			fcltContent += "</tr>";
			$("#fclt").html(fcltContent);
		},
		error: function() {
			var fcltContent = "";
			fcltContent += "<tr><td colspan=\"6\" class=\"error\">Oops! Failed to load faculties</td></tr>";
			$("#fclt").html(fcltContent);
		},
		success: function(retData) {
			fcltJson = JSON.parse(retData);
			var res = fcltJson["result"];
			fcltJson = fcltJson["data"];
			var fcltContent = "";
			var fcltTbl = $("#fclt");
			
			if (res === "success") {
				fcltContent += "<thead><tr><th>Faculty ID</th><th>Faculty Name</th>";
				// fcltContent += "<th>Birth Year</th>";
				fcltContent += "<th>Rank</th>";
				// fcltContent += "<th>Research Speciality</th>";
				fcltContent += "<th>Options</th></tr></thead><tbody>";
				if (fcltJson.length === 0)
					fcltContent += "<tr><td colspan=\"6\" class=\"loading\">There are no faculties</td></tr>";
				else {
					for (var i = 0; i < fcltJson.length; i++) {
						fcltContent += "<tr><td>" + fcltJson[i]['faculty_id'] + "</td>";
						fcltContent += "<td>" + fcltJson[i]['name'] + "</td>";
						// fcltContent += "<td>" + fcltJson[i]['birth_year'] + "</td>";
						fcltContent += "<td>" + fcltJson[i]['rank'] + "</td>";
						// fcltContent += "<td>" + fcltJson[i]['research_spec'] + "</td>";
						fcltContent += "<td>";
						fcltContent += "<a href=\"contact/?faculty_id=" + fcltJson[i]['faculty_id']
							+ "\" class=\"cont\">Contact</a>";
						fcltContent += "<a href=\"department/?faculty_id=" + fcltJson[i]['faculty_id']
							+ "\" class=\"cont\">Department</a> | ";
						fcltContent += "<a href=\"#\" class=\"view\">View</a>";
						fcltContent += "<a href=\"#\" class=\"upd\">Update</a>";
						fcltContent += "<a href=\"#\" class=\"del\">Delete</a>";
						fcltContent += "</td></tr>";
					}
				}
				fcltContent += "</tbody>";
			}
			else {
				fcltContent += "<tr><td colspan=\"3\" class=\"error\">" + fcltJson + "</td></tr>";
			}
			
			fcltTbl.hide();
			fcltTbl.html(fcltContent);
			fcltTbl.fadeIn(500);
			
			if (res === "success") {
				$("#fclt tr td .view").click(function(e) {
					$("#frmviewfclt")[0].reset();
					$("#fcltviewmess").hide();
					$("#viewpanel").fadeToggle(500);
					fillViewPopup(e);
				});
				
				$("#fclt tr td .upd").click(function(e) {
					$("#frmupdfclt")[0].reset();
					$("#fcltupdmess").hide();
					$("#updpanel").fadeToggle(500);
					$("#txtupdfcltid").focus();
					fillUpdPopup(e);
				});

				$("#fclt tr td .del").click(function(e) {
					$("#frmdelfclt")[0].reset();
					$("#fcltdelmess").html("Do you want to delete the faculty ?");
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

function addFclt(e) {
	var data = {
		"action" : "addfclt"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "fcltajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var fcltAddMess = $("#fcltaddmess");
			innerHtml += "Adding...";
			fcltAddMess.html(innerHtml);
			fcltAddMess.css('background', 'blue');
			fcltAddMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var fcltAddMess = $("#fcltaddmess");
			innerHtml += "Failed to add faculty";
			fcltAddMess.html(innerHtml);
			fcltAddMess.css('background', 'red');
			fcltAddMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var fcltAddMess = $("#fcltaddmess");
			fcltAddMess.html(retJson);
			
			if (res === "success") {
				fcltAddMess.css('background', 'green');
				setTimeout(function() {
					$("#frmaddfclt")[0].reset();
					fcltAddMess.html('');
					fcltAddMess.hide();
					$("#addpanel").fadeOut();
					getFclt();
				}, 2000);
			}
			else if(res === "failed") {
				fcltAddMess.css('background', 'red');
			}
			else {
				fcltAddMess.css('background', 'red');
			}
			fcltAddMess.fadeIn(500);
		}
	});
}

function fillUpdPopup(e) {
	var txtFcltId = $("#txtupdfcltid");
	var txtFcltName = $("#txtupdfcltname");
	var txtFcltYear = $("#txtupdfcltyear");
	var txtFcltRank = $("#txtupdfcltrank");
	var txtFcltSpec = $("#txtupdfcltspec");
	var txtOldFcltId = $("#txtoldfcltid");
	
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

	txtFcltId.val(fcltJson[i]["faculty_id"]);
	txtFcltName.val(fcltJson[i]["name"]);
	txtFcltYear.val(fcltJson[i]["birth_year"]);
	txtFcltRank.val(fcltJson[i]["rank"]);
	txtFcltSpec.val(fcltJson[i]["research_spec"]);
	txtOldFcltId.val(fcltJson[i]["faculty_id"]);
}

function updFclt(e) {
	var data = {
		"action" : "updfclt"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "fcltajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var fcltUpdMess = $("#fcltupdmess");
			innerHtml += "Updating...";
			fcltUpdMess.html(innerHtml);
			fcltUpdMess.css('background', 'blue');
			fcltUpdMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var fcltUpdMess = $("#fcltupdmess");
			innerHtml += "Failed to update faculty";
			fcltUpdMess.html(innerHtml);
			fcltUpdMess.css('background', 'red');
			fcltUpdMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var fcltUpdMess = $("#fcltupdmess");
			fcltUpdMess.html(retJson);
			
			if (res === "success") {
				fcltUpdMess.css('background', 'green');
				setTimeout(function() {
					$("#frmupdfclt")[0].reset();
					fcltUpdMess.html('');
					fcltUpdMess.hide();
					$("#updpanel").fadeOut(500);
					getFclt();
				}, 2000);
			}
			else if(res === "failed") {
				fcltUpdMess.css('background', 'red');
			}
			else {
				fcltUpdMess.css('background', 'red');
			}
			fcltUpdMess.fadeIn(500);
		}
	});
}

function fillDelPopup(e) {
	var txtFcltId = $("#txtdelfcltid");
	var txtFcltName = $("#txtdelfcltname");
	var txtFcltYear = $("#txtdelfcltyear");
	var txtFcltRank = $("#txtdelfcltrank");
	var txtFcltSpec = $("#txtdelfcltspec");
	
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

	txtFcltId.val(fcltJson[i]["faculty_id"]);
	txtFcltId.prop('readonly', true);
	txtFcltName.val(fcltJson[i]["name"]);
	txtFcltName.prop('readonly', true);
	txtFcltYear.val(fcltJson[i]["birth_year"]);
	txtFcltYear.prop('readonly', true);
	txtFcltRank.val(fcltJson[i]["rank"]);
	txtFcltRank.prop('readonly', true);
	txtFcltSpec.val(fcltJson[i]["research_spec"]);
	txtFcltSpec.prop('readonly', true);
}

function delFclt(e) {
	var data = {
		"action" : "delfclt"
	};
	
	data = $(e.target).serialize() + '&' + $.param(data);
	
	$.ajax({
		type: "POST",
		dataType: "text",
		url: "fcltajax.php",
		data: data,
		beforeSend: function() {
			var innerHtml = "";
			var fcltDelMess = $("#fcltdelmess");
			innerHtml += "Deleting...";
			fcltDelMess.html(innerHtml);
			fcltDelMess.css('background', 'blue');
			fcltDelMess.fadeIn(500);
		},
		error: function() {
			var innerHtml = "";
			var fcltDelMess = $("#fcltdelmess");
			innerHtml += "Failed to delete faculty";
			fcltDelMess.html(innerHtml);
			fcltDelMess.css('background', 'red');
			fcltDelMess.fadeIn(500);
		},
		success: function(retData) {
			retJson = JSON.parse(retData);
			var res = retJson["result"];
			retJson = retJson["data"];
			
			var innerHtml = "";
			var fcltDelMess = $("#fcltdelmess");
			fcltDelMess.html(retJson);
			
			if (res === "success") {
				fcltDelMess.css('background', 'green');
				setTimeout(function() {
					$("#frmdelfclt")[0].reset();
					fcltDelMess.html('');
					fcltDelMess.hide();
					$("#delpanel").fadeOut(500);
					getFclt();
				}, 2000);
			}
			else if(res === "failed") {
				fcltDelMess.css('background', 'red');
			}
			else {
				fcltDelMess.css('background', 'red');
			}
			fcltDelMess.fadeIn(500);
		}
	});
}

function fillViewPopup(e) {
	var txtFcltId = $("#txtviewfcltid");
	var txtFcltName = $("#txtviewfcltname");
	var txtFcltYear = $("#txtviewfcltyear");
	var txtFcltRank = $("#txtviewfcltrank");
	var txtFcltSpec = $("#txtviewfcltspec");
	
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

	txtFcltId.val(fcltJson[i]["faculty_id"]);
	txtFcltId.prop('readonly', true);
	txtFcltName.val(fcltJson[i]["name"]);
	txtFcltName.prop('readonly', true);
	txtFcltRank.val(fcltJson[i]["rank"]);
	txtFcltRank.prop('readonly', true);
	txtFcltYear.val(fcltJson[i]["birth_year"]);
	txtFcltYear.prop('readonly', true);
	txtFcltSpec.val(fcltJson[i]["research_spec"]);
	txtFcltSpec.prop('readonly', true);
}