document.getElementById("btn-add").onclick = function() {
		document.getElementById("show").style.visibility = "visible";
		};

// document.getElementById("upt-icon").onclick = function() {
// 		document.getElementById("frm").style.display = "block";
// 		document.getElementById("information").style.display = "none";
// 		};

const uptForm = (count) => {
	document.getElementById("frm-"+count).style.display = "block";
	document.getElementById("information-"+count).style.display = "none";
}
