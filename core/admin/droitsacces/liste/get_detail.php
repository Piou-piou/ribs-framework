<?php
	$id_liste_droit_acces = $_GET['id'];
	$type = $_GET['type'];

	$gestion_droit_acces = new \core\admin\droitsacces\GestionDroitAcces($id_liste_droit_acces);

	//récupération des listes en fonction du bon type
	if ($type == "droit-acces") {
		$gestion_droit_acces->getListeDroitAccesDetailDroit();

		$counter = count($gestion_droit_acces->getDroitAcces());
		$contenu = $gestion_droit_acces->getDroitAcces();
	}
	if ($type == "droit-acces-page") {
		$gestion_droit_acces->getListeDroitAccesDetailPage();

		$counter = count($gestion_droit_acces->getIdPage());
		$contenu = $gestion_droit_acces->getTitrePage();
	}
	if ($type == "droit-acces-user") {
		$gestion_droit_acces->getListeDroitAccesDetailUser();

		$counter = count($gestion_droit_acces->getIdidentite());
		$contenu = $gestion_droit_acces->getPseudo();
	}

	if (($counter == 0) || ($counter == null)) {
		$counter = 1;
		$contenu[] = "Cette liste ne contient pas d'élément dans cette catégorie, modifiez la liste pour en ajouter.";
	}
?>
<?php for ($i = 0; $i < $counter; $i++):?>
	<h4><?=$contenu[$i]?></h4>
<?php endfor; ?>