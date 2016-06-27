$(document).ready(function() {
    $("#redirect").click(function() {
        if ($(this).is(":checked")) {
            //on cache l'élément actif
            $("#creer-page").addClass("rotateY90 animate");

            setTimeout(function() {
                $("#creer-page").addClass("cache");
            }, 300);

            //on affiche l'élément caché + le button submit
            setTimeout(function() {
                $("#redirect-page").removeClass("cache").addClass("rotateY0");
                $("#redirect-page").parent().find("button").removeClass("cache");
                $("#creer-page").parent().find("button").addClass("cache");

                setTimeout(function() {
                    $("#redirect-page").removeClass("rotateY90");
                }, 100);
            }, 400);
        }
        else {
            //on cache l'élément actif
            $("#redirect-page").addClass("rotateY90 animate");

            setTimeout(function() {
                $("#redirect-page").addClass("cache");
            }, 300);

            //on affiche l'élément caché + le button submit
            setTimeout(function() {
                $("#creer-page").removeClass("cache").addClass("rotateY0");

                $("#creer-page").parent().find("button").removeClass("cache");
                $("#redirect-page").parent().find("button").addClass("cache");

                setTimeout(function() {
                    $("#creer-page").removeClass("rotateY90");
                }, 100);
            }, 400);
        }
    });
})