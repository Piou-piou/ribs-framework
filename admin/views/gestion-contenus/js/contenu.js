function split(url) {
	var split = url.split("?");
	return params = split[1];
}

$(document).ready(function() {
	function OpenSupprimerPopup(lien) {
		event.preventDefault();

		$(".popup").addClass("visible");

		$(".popup").find("a.valider").attr("href", lien);
	}


	//popup qui s'ouvre pour valider suppression article bloc
	$("#supprimer-page-contenu").click(function() {

		event.preventDefault();
		OpenSupprimerPopup($(this).attr("href"));
	});
})