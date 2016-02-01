function split(url) {
	var split = url.split("?");
	return params = split[1];
}

$(document).ready(function() {
	$(".droit-acces h4").click(function() {
		var div = $(this).attr("id");

		var split = div.split("-");

		var id = split.pop();
		var type = split.splice(0, 4).toString().replace(new RegExp("[^(a-zA-Z)]", "g"), '-');

		$.ajax({
			type:"GET",
			data: "type="+type+"&id="+id,
			url:"../../administrator/controller/core/admin/droitsacces/liste/get_detail",
			success: function(data){
				$(".droit-acces .liste-droit #"+div+"-detail").append(data);
			}, error: function(){

			}
		});


		$(".droit-acces .liste-droit #"+div+"-detail").parent().find("p").remove();
		$(".droit-acces .liste-droit #"+div+"-detail").parent().children().removeClass("active");
		$(".droit-acces .liste-droit #"+div+"-detail").addClass("active");
	});
});