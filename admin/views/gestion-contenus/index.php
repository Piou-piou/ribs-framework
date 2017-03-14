<header>
	<div class="inner">
		<h1>Gestion des contenus</h1>
	</div>
</header>
<?php include("header.php"); ?>

<?php if ($droit_acces->getDroitAcces("CREATION PAGE")):?>
	<a class="submit-contenu" href="<?=ADMWEBROOT?>gestion-contenus/creer-une-page"><i class="fa fa-newspaper-o"></i>Créer une page</a>
<?php endif; ?>