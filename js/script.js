document.getElementById("btn-add").onclick = function() {
		document.getElementById("show").style.visibility = "visible";
		};

const uptForm = (count) => {
	document.getElementById("frm-"+count).style.display = "block";
	document.getElementById("information-"+count).style.display = "none";
}

function file(input) {
	if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e){
			$('#previmage')
			.attr('src', e.target.result)
			.width(200)
			.height(190);
		};
		reader.readAsDataURL(input.files[0]);
	}
}

