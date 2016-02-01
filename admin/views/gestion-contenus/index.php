<header>
	<div class="inner">
		<h1>Gestion des contenus</h1>
	</div>
</header>
<?php include("header.php");?>

<?php if ($droit_acces->getDroitAccesContenu("CREATION PAGE", "gestion-contenus/creer-une-page")):?>
	<a class="submit-contenu" href="<?=ADMROOT?>gestion-contenus/creer-une-page"><i class="fa fa-newspaper-o"></i>Créer une page</a>
<?php endif;?>