$(document).ready(function() {
   $(".login a").click(function(e) {
       e.preventDefault();

       var div_afficher = $(this).attr("id");

       console.log(div_afficher);

       $(".login .login-form").removeClass("active");

       $(".login #"+div_afficher).addClass("active");
   })
});