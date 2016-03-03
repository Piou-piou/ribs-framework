<header>
	<div class="inner">
		<h1>Gestion des droits d'accès | toutes les listes</h1>
	</div>
</header>
<?php include("header.php"); ?>

<div class="inner">
	<div class="droit-acces">
		<?php for ($i = 0; $i < count($gestion_droit_acces->getIdListeDroitAcces()); $i++):?>
			<div class="bloc">
				<h2><?=$gestion_droit_acces->getNomListe()[$i]?></h2>

				<h4 class="droit" id="droit-acces-<?=$gestion_droit_acces->getIdListeDroitAcces()[$i]?>"><i class="fa fa-lock animated animated activate swing infinite"></i><?=$gestion_droit_acces->getNbDroitAcces()[$i]?> droits d'accès pour cette liste</h4>
				<h4 class="droit" id="droit-acces-page-<?=$gestion_droit_acces->getIdListeDroitAcces()[$i]?>"><i class="fa fa-pencil-square-o animated activate swing infinite"></i><?=$gestion_droit_acces->getNbDroitAccesPage()[$i]?> pages peuvent être modifiées et/ou supprimées par ce groupe</h4>
				<h4 class="droit" id="droit-acces-user-<?=$gestion_droit_acces->getIdListeDroitAcces()[$i]?>"><i class="fa fa-users animated activate swing infinite"></i><?=$gestion_droit_acces->getNbUser()[$i]?> utilisateurs sont dans cette liste</h4>

				<div class="separation"></div>

				<div class="liste-droit">
					<p>Cliquez sur une des parties ci-dessus afin d'afficher la liste complète des droits en question.</p>

					<div id="droit-acces-<?=$gestion_droit_acces->getIdListeDroitAcces()[$i]?>-detail">
						<h2>Liste des droits d'acces</h2>
						<?php for ($j = 0; $j < count($gestion_droit_acces->getDroitAcces()); $j++):?>
							<h4><?=$gestion_droit_acces->getDroitAcces()[$j]?></h4>
						<?php endfor; ?>
					</div>
					<div id="droit-acces-page-<?=$gestion_droit_acces->getIdListeDroitAcces()[$i]?>-detail">
						<h2>Liste des droits d'acces pour les pages</h2>
						<?php for ($j = 0; $j < count($gestion_droit_acces->getIdPage()); $j++):?>
							<h4><?=$gestion_droit_acces->getTitrePage()[$j]?></h4>
						<?php endfor; ?>
					</div>
					<div id="droit-acces-user-<?=$gestion_droit_acces->getIdListeDroitAcces()[$i]?>-detail">
						<h2>Liste utilisateurs dans cette liste</h2>
						<?php for ($j = 0; $j < count($gestion_droit_acces->getIdidentite()); $j++):?>
							<h4><?=$gestion_droit_acces->getPseudo()[$j]?></h4>
						<?php endfor; ?>
					</div>
				</div>

				<a href="<?=ADMWEBROOT?>gestion-droits-acces/modifier-liste?id_liste=<?=$gestion_droit_acces->getIdListeDroitAcces()[$i]?>" titre="" class="modifier">Modifier cette liste</a>
				<a href="controller/core/admin/droitacces/liste/supprimer?id_liste=<?=$gestion_droit_acces->getIdListeDroitAcces()[$i]?>" class="supprimer popup-delete">Supprimer cette liste</a>
			</div>
		<?php endfor; ?>
	</div>
</div>