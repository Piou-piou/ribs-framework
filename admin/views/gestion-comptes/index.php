<header>
	<div class="inner">
		<h1>Gestion des comptes</h1>
	</div>
</header>
<div class="inner">
	<?php if ($droit_acces->getDroitAccesAction("CREATION COMPTE ADMIN")):?>
		<a class="submit-contenu" href="<?=ADMWEBROOT?>gestion-comptes/creer-utilisateur"><i class="fa fa-user"></i>Créer un utilisateur</a>
	<?php endif; ?>
	<div class="contenu modifier-contenu gestion-comptes">
		<h2>Comptes actifs sur le site</h2>
		<?php $admin->getAllUser(); ?>

		<table>
			<thead>
				<tr>
					<td>Image du profil</td>
					<td>Prénom Nom</td>
					<td>Pseudo</td>
					<?php if ($config->getValiderInscription() == 1): ?>
						<td>Valider le compte</td>
					<?php endif; ?>
					<td>Réinitialiser le mot de passe</td>
					<td>Archiver le compte</td>
					<td>Supprimer le compte</td>
				</tr>
			</thead>
			<?php for ($i = 0; $i < count($admin->getIdidentite()); $i++):?>
				<tr>
					<td><img src="<?=IMGROOT.$admin->getImg()[$i]?>"></td>
					<td><?=$admin->getPrenom()[$i]?> <?=$admin->getNom()[$i]?></td>
					<td><?=$admin->getPseudo()[$i]?></td>
					<?php if ($config->getValiderInscription() == 1): ?>
						<td><?=$admin->getValide()[$i]?></td>
					<?php endif; ?>
					<td><a href="<?=ADMWEBROOT?>controller/core/admin/comptes/reinitialiser_mdp?id_identite=<?=$admin->getIdidentite()[$i]?>">Réinitialiser le mot de passe</a></td>
					<td><a href="<?=ADMWEBROOT?>controller/core/admin/comptes/archiver_compte?id_identite=<?=$admin->getIdidentite()[$i]?>"  class="supprimer open-popup" popup="popup-archiver-utilisateur">Archiver ce compte</a></td>
					<td><a href="<?=ADMWEBROOT?>controller/core/admin/comptes/supprimer_compte?id_identite=<?=$admin->getIdidentite()[$i]?>" class="supprimer open-popup" popup="popup-supprimer-utilisateur">Supprimer ce compte</a></td>
				</tr>
			<?php endfor; ?>
		</table>
	</div>

	<div class="contenu modifier-contenu gestion-comptes">
		<h2>Comptes archivés sur le site</h2>

		<?php $admin->getAllUser(1); ?>

		<table>
			<thead>
				<tr>
					<td>Image du profil</td>
					<td>Prénom Nom</td>
					<td>Pseudo</td>
					<td>Réinitialiser le mot de passe</td>
					<td>Activer le compte</td>
					<td>Supprimer le compte</td>
				</tr>
			</thead>
			<?php for ($i = 0; $i < count($admin->getIdidentite()); $i++):?>
				<tr>
					<td><img src="<?=IMGROOT.$admin->getImg()[$i]?>"></td>
					<td><?=$admin->getPrenom()[$i]?> <?=$admin->getNom()[$i]?></td>
					<td><?=$admin->getPseudo()[$i]?></td>
					<td><a href="<?=ADMWEBROOT?>controller/core/admin/comptes/reinitialiser_mdp?id_identite=<?=$admin->getIdidentite()[$i]?>">Réinitialiser le mot de passe</a></td>
					<td><a href="<?=ADMWEBROOT?>controller/core/admin/comptes/activer_compte?id_identite=<?=$admin->getIdidentite()[$i]?>"  class="supprimer open-popup" popup="popup-archiver-utilisateur">Activer ce compte</a></td>
					<td><a href="<?=ADMWEBROOT?>controller/core/admin/comptes/supprimer_compte?id_identite=<?=$admin->getIdidentite()[$i]?>" class="supprimer open-popup" popup="popup-supprimer-utilisateur">Supprimer ce compte</a></td>
				</tr>
			<?php endfor; ?>
		</table>
	</div>
</div>

<div class="popup" id="popup-archiver-utilisateur">
	<div class="content">
		<h2>Etes-vous sûr de vouloir archiver cet utilisateur ?</h2>
		<p>Si vous l'archivez, tous ses informations seront conservées mais tous ces accès au site seront suspendus.</p>

		<div class="lien">
			<a class="annuler">Annuler</a>
			<a href="" class="valider">Valider</a>
		</div>
		<div class="clear"></div>
	</div>
</div>

<div class="popup" id="popup-supprimer-utilisateur">
	<div class="content">
		<h2>Etes-vous sûr de vouloir supprimer cet utilisateur ?</h2>
		<p>Si vous le supprimé, tous ses informations seront supprimées ainsi que tous ces accès au site.</p>
		<p>Par contre ses commentaires sur le resteront mais son nom sera remplacé par "utilisateur supprimé".</p>

		<div class="lien">
			<a class="annuler">Annuler</a>
			<a href="" class="valider">Valider</a>
		</div>
		<div class="clear"></div>
	</div>
</div>