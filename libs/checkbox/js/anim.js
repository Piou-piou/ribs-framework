$(document).ready(function() {
    $(".checkbox-perso.rounded").each(function() {
        var $input = $("input", this);

        $input.after('<span></span>');
    })

    $(".checkbox-perso.switched").each(function() {
        var $input = $("input", this);

        $input.hide().wrap('<span class="switch">');
        $input.after('<span class="switch-container"> <span class="on">OUI</span> <span class="mid"></span> <span class="off">NON</span> </span>');
    });
});