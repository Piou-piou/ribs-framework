/*-------------------- INDICATIONS --------------------------------------------------------------------------
var effet : définit les effets de transitions entre les slides
	- effet numero 1 : effet basic de slide de gauche à droite
	- effet numero 2 : effet basic de slide de droite à gauche
	- effet numero 3 : effet de transitoin en 3D avec scale -1 + rotate 90
	- effet numero 4 : effet basic de slide fadein() et fadeout()
	- effet numero 5 : effet basic de slide en diagonnale de gauche à droite
	- effet numero 6 : effet basic de slide de gauche à gauche
	
var positionTexte : définit les effet d'apparssion des textes
	- definit effet apparision texte (ease, easein, easeout, ...)voir : http://easings.net/fr
	
var positionTexte : définit la position de la div de texte
	- position numero 1 : effet de texte qui vient de la gauche et a 10px du bas
	- position numero 2 : effet de texte qui vient depuis le bas et reste en bas du slide
	- position numero 3 : effet de texte qui vient depuis la gauche et fait toute la hauteur du slide ou pas
	- position numero 4 : effet de texte qui vient depuis le bas et fait toute la hauteur du slide ou pas
	
var delaySlide : définit le temps d'affichage de chauque slide (1000 = 1s)

var delayTxt : définit le temps après lequel apparait le texte après le changement de slide

var tailleSlider : definit le taille du slider en px
var heightSlider : definit le hauteur du slider en px

var tailletxt : définit la taille de la div txt en px
var heightTxt : définit la hauteur de la div txt en px (not use for 1 et 2)

-------------------- FIN INDICATIONS -----------------------------------------------------------------------------*/
jQuery(function ($) {
	"use strict";
	/*----------------- INIT --------------------------------------------------------------------------------*/
	//var de config
	var effet = 6; /*definit effet entre les différents slides*/
	var effetTexte = "easeInOutExpo"; /*definit effet apparision texte (ease, easein, easeout, ...)voir : http://easings.net/fr*/
	var positionTexte = 3; /*definit la position du texte (droite, gauche, haut, bas)*/
	var delaySlide = 5000; /*temps de chaque slide 1000 == 1s*/
	var delayTxt = 1000; /*Temps apres changement slide pour afficher txt */
	var tailleSlider = 1000; /*definition de la taille du slider en px*/
	var heightSlider = 480; /*definition de la hauteur du slider en px*/
	var tailleTxt = 300; /*definition taille div qui contient txt en px*/
	var heightTxt = 480; /*definition hauteur div qui contient txt en px (not use for 1 et 2)*/
	
	
	
	$('#slider').addClass("slider");
	
	posTxt(positionTexte, tailleTxt); 
	$('.courant').each(function(event) {
		slideCourant($(this), effet);
		slideCouranttexte($(this), effetTexte, positionTexte);	
	});
	$('.apres').each(function(event){
		slideSuivant($(this), effet);
	});
	$(".slider > .contenu-slider  div  div").addClass("txtslider");
	/*----------------- FIN INIT -----------------------------------------------------------------------------------*/
	
	
	
	/*------------------ FONCTION PASSAGE SLIDE SUIVANT (appellee dans suivant()) --------------------------------*/
	function changeslide(slide) {
		//metrre l'icone du slider actif et clique en orange
		//$("#navigationSlide>li").removeClass();
		//liClick.parent().toggleClass("click");
		
		//changement de slide enelve la classe courant
		$(".slider > .contenu-slider > div").removeClass();
		
		// Class CSS à l'élément "courant"
		slide.addClass("courant");
		
		$('.courant').each(function(event) {
			slideCourant($(this), effet);
			slideCouranttexte($(this), effetTexte, positionTexte);	
		});
		// Class CSS aux éléments "avant"
		slide.prevAll().each(function(index) {
			slidePrecedent($(this), effet);
			slideAprestexte($(this), effetTexte, positionTexte);
		});
		// Class CSS aux éléments "apres"
		slide.nextAll().each(function(index) {
			slideSuivant($(this), effet);
			slideAprestexte($(this), effetTexte, positionTexte);	
		});
		
	}
	/*------------------ FIN FONCTION PASSAGE SLIDE SUIVANT --------------------------------*/

	
	
	/*------------------ FONCTION INIT PASSAGE SLIDE SUIVANT AUTO --------------------------------*/
	function suivant(){
		var courant = $('#slider').find('.courant');
		if (!courant.is(':last-child')) {
			var slideapres = courant.next();
			changeslide(slideapres);	
		}
		else {
			var courant=$('#slide1');
			changeslide(courant);
		}
		//pour faire suivant auto sans click
	}
	var timer = setInterval(suivant,delaySlide);
	/*------------------ FIN FONCTION INIT PASSAGE SLIDE SUIVANT AUTO --------------------------------*/
	
	
	
	/*----------------------- FONCTIONS QUI APPLIQUES LES STYLES AUX SLIDES POUR LES TRANISTIONS -----------------------------*/
	/*fonction pour les styles appliques au slides situés avant le courant*/
	function slidePrecedent(slide, effet) {
		//pour transition normale de gauche a droite ++ gauche à gauche
		if ((effet == 1) || (effet == 6)) {
			slide.css({
				"-webkit-transform": "translateX("+(-tailleSlider)+"px)",
				"-moz-transform": "translateX("+(-tailleSlider)+"px)",
				"-o-transform": "translateX("+(-tailleSlider)+"px)",
				"-ms-transform": "translateX("+(-tailleSlider)+"px)",
				"transform": "translateX("+(-tailleSlider)+"px)"
			});
		}
		//pour transition normale de droite a gauche
		else if (effet == 2) {
			slide.css({
				"-webkit-transform": "translateX("+(tailleSlider)+"px)",
				"-moz-transform": "translateX("+(tailleSlider)+"px)",
				"-o-transform": "translateX("+(tailleSlider)+"px)",
				"-ms-transform": "translateX("+(tailleSlider)+"px)",
				"transform": "translateX("+(tailleSlider)+"px)"
			});
		}
		//pour transition avec scale +rotate de plus a moins
		else if (effet == 3) {
			slide.css({
				"transform": "rotateX(90deg) scale(0)",
				"transition-duration":  "0.50s",
				"-webkit-transform": "rotateX(90deg) scale(0)",
				"-webkit-transition-duration":  "0.50s"
			});
		}
		//pour transition avec fade
		else if (effet == 4) {
			slide.fadeOut(1000);
		}
		//pour transition normale en diagonale de gauche a droite
		else if (effet == 5) {
			slide.css({
				"-webkit-transform": "translateX("+(tailleSlider)+"px) translateY("+(heightSlider)+"px)",
				"-moz-transform": "translateX("+(tailleSlider)+"px) translateY("+(heightSlider)+"px)",
				"-o-transform": "translateX("+(tailleSlider)+"px) translateY("+(heightSlider)+"px)",
				"-ms-transform": "translateX("+(tailleSlider)+"px) translateY("+(heightSlider)+"px)",
				"transform": "translateX("+(tailleSlider)+"px) translateY("+(heightSlider)+"px)"
			});
		}
	}
	
	
	/*fonction pour les styles appliques au slide courant*/
	function slideCourant(slide, effet) {
		//pour transition normale de gauche a droite ++ droite à gauche ++ diagonale ++ gauche à gauche
		if ((effet == 1) || (effet == 2) || (effet == 5) || (effet == 6)) {
			slide.css({
				"-webkit-transform": "translateX(0) translateY(0)",
				"-moz-transform": "translateX(0) translateY(0)",
				"-o-transform": "translateX(0) translateY(0)",
				"-ms-transform": "translateX(0) translateY(0)",
				"transform": "translateX(0) translateY(0)"
			});
		}
		//pour transition avec scale +rotate de plus a moins
		else if (effet == 3) {
			slide.css({
				"transition-duration":  "1s",
				"transform": "rotateX(0deg) scale(1)",
				"-webkit-transition-duration":  "1s",
				"-webkit-transform": "rotateX(0deg) scale(1)",
				"visibility": "visible"
			});
		}
		//pour transition avec fade
		else if (effet == 4) {
			slide.fadeIn(1000);
		}
	}
	
	
	
	/*fonction pour les styles appliques au slides situés apres le courant*/
	function slideSuivant(slide, effet) {
		//pour transition normale de gauche a droite
		if (effet == 1) {
			slide.css({
				"-webkit-transform": "translateX("+(tailleSlider)+"px)",
				"-moz-transform": "translateX("+(tailleSlider)+"px)",
				"-o-transform": "translateX("+(tailleSlider)+"px)",
				"-ms-transform": "translateX("+(tailleSlider)+"px)",
				"transform": "translateX("+(tailleSlider)+"px)"
			});
		}
		//pour transition normale de droite a gauche ++ gauche à gauche
		else if ((effet == 2) || (effet == 6)) {
			slide.css({
				"-webkit-transform": "translateX("+(-tailleSlider)+"px)",
				"-moz-transform": "translateX("+(-tailleSlider)+"px)",
				"-o-transform": "translateX("+(-tailleSlider)+"px)",
				"-ms-transform": "translateX("+(-tailleSlider)+"px)",
				"transform": "translateX("+(-tailleSlider)+"px)"
			});
		}
		//pour transition avec scale de plus a moins
		else if (effet == 3) {
			slide.css({
				"transform": "rotateX(90deg) scale(0)",
				"transition-duration":  "0.50s",
				"-webkit-transform": "rotateX(90deg) scale(0)",
				"-webkit-transition-duration":  "0.50s"
			});
		}
		//pour transition avec fade
		else if (effet == 4) {
			slide.fadeOut(1000);
		}
		//pour transition normale de droite a gauche
		else if (effet == 5) {
			slide.css({
				"-webkit-transform": "translateX("+(-tailleSlider)+"px) translateY("+(-heightSlider)+"px)",
				"-moz-transform": "translateX("+(-tailleSlider)+"px) translateY("+(-heightSlider)+"px)",
				"-o-transform": "translateX("+(-tailleSlider)+"px) translateY("+(-heightSlider)+"px)",
				"-ms-transform": "translateX("+(-tailleSlider)+"px) translateY("+(-heightSlider)+"px)",
				"transform": "translateX("+(-tailleSlider)+"px) translateY("+(-heightSlider)+"px)"
			});
		}
	}
	
	
	
	/*----------------------- FONCTIONS QUI APPLIQUES LES STYLES AUX TEXTES -----------------------------*/
	/*fonction qui cree une classe dans la balise style pour le placement de la div sui contient le/les texte(s)*/
	function posTxt(positionTexte, tailleTxt) {
		/*a gauche vers le bas du slider*/
		if (positionTexte == 1) {
			var pos = "<style>.txtslider{top: 400px;left: -215px;width:"+tailleTxt+"px;}</style>";
		}
		else if (positionTexte == 2) {
			var pos = "<style>.txtslider{bottom: -100px;width:"+tailleTxt+"px;}</style>";
		}
		else if (positionTexte == 3) {
			var pos = "<style>.txtslider{left: -215px;width:"+tailleTxt+"px;height:"+heightTxt+"px;}</style>";
		}
		else if (positionTexte == 4) {
			var pos = "<style>.txtslider{bottom: -100px;width:"+tailleTxt+"px;height:"+heightTxt+"px;}</style>";
		}
		$("#sliderstyle").append(pos);
	}
	
	/*fonction pour les styles appliques au texte du slide courant*/
	function slideCouranttexte(slide, effetTexte, positionTexte) {
		var txtdiv = $(slide).find('div');
		/*de gauche a droite*/
		if ((positionTexte == 1) || (positionTexte == 3)) {
			$(txtdiv).delay(delayTxt).animate({
				opacity: 1,
				left: "0px"
			},500,effetTexte);
		}
		/*planque en bas -> de bas en haut*/
		else if ((positionTexte == 2) || (positionTexte == 4)) {
			$(txtdiv).delay(delayTxt).animate({
				opacity: 1,
				bottom: "0px"
			},500,effetTexte);
		}
		
	}
	/*fonction pour les styles appliques au texte des slides non courant*/
	function slideAprestexte(slide, effetTexte, positionTexte) {
		var txtdiv = $(slide).find('div');
		if ((positionTexte == 1) || (positionTexte == 3)) {
			$(txtdiv).delay(delayTxt).animate({
				opacity: 0,
				left: "-"+tailleTxt+"px"
			},500,effetTexte);
		}
		/*planque en bas -> de bas en haut*/
		else if ((positionTexte == 2) || (positionTexte == 4)) {
			$(txtdiv).delay(delayTxt).animate({
				opacity: 0,
				bottom: "-100px"
			},500,effetTexte);
		}
	}
})