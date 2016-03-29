<header>
	<div class="inner">
		<h1>Gestion des contenus : </h1>
		<h2>Modification de la page <?=$titre_courant?></h2>
	</div>
</header>
<?php include("header.php"); ?>
<?php require_once("admin/controller/ckeditor.php"); ?>
<?php $droit_acces->getDroitAccesContenu("GESTION CONTENU PAGE", $_GET['id']); ?>
<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>popup/css/style.css">
<script src="<?=LIBSWEBROOT?>popup/js/popup.js"></script>


<form action="<?=ADMWEBROOT?>controller/core/admin/contenus/gestion/modifier_contenus" method="post">
	<?php if (($droit_acces->getModifSeo() == 1) || ($droit_acces->getModifNavigation() == 1) || ($droit_acces->getModifContenu() == 1) || ($droit_acces->getSuperAdmin() == 1)):?>
		<button type="submit" class="submit-contenu" type="submit"><i class="fa fa-check"></i>Valider</button>
	<?php endif; ?>
	<input type="hidden" name="id_page" value="<?=$id_page_courante?>">
	<?php if (($_GET['id'] != 1) && (($droit_acces->getSupprimerPage() == 1) || ($droit_acces->getSuperAdmin() == 1))):?>
		<button id="supprimer-page-contenu" type="button" class="submit-contenu supprimer-page supprimer open-popup" popup="supprimer-page" href="<?=ADMWEBROOT?>controller/core/admin/contenus/gestion/supprimer_page?id=<?=$id_page_courante?>"><i class="fa fa-times"></i>Supprimer cette page</button>
	<?php endif; ?>

	<?php require_once(ROOT."app/views/".$url.".php");?>
</form>

<script src="<?=LIBSWEBROOT?>ckeditor_new/ckeditor.js"></script>
<script src="<?=LIBSWEBROOT?>ckfinder/ckfinder.js"></script>

<script>
	CKEDITOR.disableAutoInline = true;
	var editor = CKEDITOR.inline( 'editor1' );
	CKFinder.setupCKEditor( editor, "<?=LIBSWEBROOT?>ckfinder/" );

	var editor2 = CKEDITOR.inline( 'editor2' );
	CKFinder.setupCKEditor( editor2, "<?=LIBSWEBROOT?>ckfinder/" );
</script>