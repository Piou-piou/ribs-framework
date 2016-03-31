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



<?php if (($droit_acces->getModifContenu() == 1) || ($droit_acces->getSuperAdmin() == 1)):?>
	<button type="button" class="submit-contenu"><i class="fa fa-check"></i>Valider</button>
<?php endif; ?>
<input type="hidden" id="id_page" name="id_page" value="<?=$id_page_courante?>">
<button id="supprimer-page-contenu" type="button" class="submit-contenu supprimer-page supprimer open-popup" popup="supprimer-page" href="<?=ADMWEBROOT?>gestion-contenus/modifier-contenu?id=<?=$id_page_courante?>"><i class="fa fa-times"></i>Annuler</button>

<?php if ($config->getResponsive() == 1){?>
	<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>admin/views/template/css/foundation-inline.css">
<?php }?>
<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/page.css">
<div id="admin-page">
	<?=$contenu_page?>
</div>


<script src="<?=LIBSWEBROOT?>ckeditor/ckeditor.js"></script>
<script src="<?=LIBSWEBROOT?>ckfinder/ckfinder.js"></script>

<script>
	CKEDITOR.disableAutoInline = true;
	var editor = CKEDITOR.inline( 'editor1' );
	CKFinder.setupCKEditor( editor, "<?=LIBSWEBROOT?>ckfinder/" );

	var editor2 = CKEDITOR.inline( 'editor2' );
	CKFinder.setupCKEditor( editor2, "<?=LIBSWEBROOT?>ckfinder/" );
</script>
<?php require_once(ROOT."admin/views/gestion-contenus/js/inline.php");?>