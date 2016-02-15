function OpenSupprimerPopup(lien, id_popup) {
    $("#"+id_popup).addClass("visible");

    $("#"+id_popup).find("a.valider").attr("href", lien);
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
    $(".open-popup").click(function(e) {
        e.preventDefault();

        OpenSupprimerPopup($(this).attr("href"), $(this).attr("popup"));
    });
});