function OpenSupprimerPopup(lien) {
    $(".popup").addClass("visible");

    $(".popup").find("a.valider").attr("href", lien);
}

$(document).ready(function() {
    $(".popup .fermer").click(function() {
        $(".popup").removeClass("visible");
    });
    $(".popup .annuler").click(function() {
        $(".popup").removeClass("visible");
        $(".popup").find("a.valider").attr("href", "");
    });

    //popup qui s'ouvre pour valider suppression article bloc
    $(".popup-delete").click(function(e) {
        e.preventDefault();
        OpenSupprimerPopup($(this).attr("href"));
    });

    //popup qui s'ouvre pour valider suppression article bloc
    $(".popup-delete-1").click(function(e) {
        e.preventDefault();
        OpenSupprimerPopup($(this).attr("href"));
    });
});