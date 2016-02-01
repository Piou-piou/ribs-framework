<header>
	<div class="inner">
		<h1>Gestion des comptes</h1>
	</div>
</header>
<div class="inner">
	<?php if ($droit_acces->getDroitAccesContenu("CREATION COMPTE ADMIN", "gestion-comptes/index")):?>
		<a class="submit-contenu" href="<?=ADMROOT?>gestion-comptes/creer-utilisateur"><i class="fa fa-user"></i>Créer un utilisateur</a>
	<?php endif;?>
	<div class="contenu gestion-comptes">
		<table>
			<thead>
				<tr>
					<td>Image du profil</td>
					<td>Prénom Nom</td>
					<td>Pseudo</td>
					<?php if ($config->getValiderInscription() == 1): ?>
						<td>Valider le compte</td>
					<?php endif;?>
					<td>Réinitialiser le mot de passe</td>
					<td>Supprimer le compte</td>
				</tr>
			</thead>
			<?php for ($i=0 ; $i<count($id_identite) ; $i++):?>
				<tr>
					<td><img src="<?=IMGROOT.$img_profil[$i]?>"></td>
					<td><?=$prenom[$i]?> <?=$nom[$i]?></td>
					<td><?=$pseudo[$i]?></td>
					<?php if ($config->getValiderInscription() == 1): ?>
						<td><?=$valide[$i]?></td>
					<?php endif;?>
					<td><a href="<?=ADMROOT?>controller/core/admin/comptes/reinitialiser_mdp?id_identite=<?=$id_identite[$i]?>">Réinitialiser le mot de passe</a></td>
					<td><a href="<?=ADMROOT?>controller/core/admin/comptes/supprimer_compte?id_identite=<?=$id_identite[$i]?>" class="supprimer popup-delete">Supprimer ce compte</a></td>
				</tr>
			<?php endfor;?>
		</table>
	</div>
</div>

<div class="popup">
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