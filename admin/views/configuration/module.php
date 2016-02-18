<header>
	<div class="inner">
		<h1>Configuration | modules</h1>
	</div>
</header>
<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>checkbox/css/style.css">
<script src="<?=LIBSWEBROOT?>checkbox/js/anim.js"></script>
<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>popup/css/style.css">
<script src="<?=LIBSWEBROOT?>popup/js/popup.js"></script>
<?php require_once('header.php');?>

<div class="inner">
	<?php require_once(LIBSROOT."barre_chargement/index.php");?>
	<div class="contenu modifier-contenu">
		<h2>Ajouter un module</h2>
		<form action="<?=ADMWEBROOT?>controller/core/modules/installation/installer" method="get" id="form-install">
			<div class="bloc">
				<label for="url" class="label">Entre ici l'url du fichier zip de votre module à installer</label>
				<input type="text" name="url">
			</div>
			<button type="submit" class="submit-contenu submit-standard no-shadow inline" type="submit"><i class="fa fa-check"></i>Valider</button>
		</form>

	</div>

	<div class="contenu modifier-contenu gestion-comptes configuration">
		<h2>Modules système</h2>
		<table>
			<thead>
				<tr>
					<td>Nom du module</td>
					<td>Activer</td>
					<td>Installer | Supprimer</td>
					<td>Mise à jour</td>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0 ; $i<count($gestion_module_page_syst->getIdModule()) ; $i++):?>
					<tr>
						<td><?=$gestion_module_page_syst->getNom()[$i]?></td>
						<td>
							<label for="<?=$gestion_module_page_syst->getUrl()[$i]?>" class="checkbox-perso switched">
								<input type="checkbox" class="test-check" id="<?=$gestion_module_page_syst->getUrl()[$i]?>" <?php if (\core\modules\GestionModule::getModuleActiver($gestion_module_page_syst->getNom()[$i]) == true): ?>checked<?php endif;?> <?php if (\core\modules\GestionModule::getModuleInstaller($gestion_module_page_syst->getNom()[$i]) == false):?>disabled<?php endif;?>>
							</label>
						</td>
						<td>
							<?php if (\core\modules\GestionModule::getModuleInstaller($gestion_module_page_syst->getNom()[$i]) == true) { ?>
								<a class="open-popup" popup="popup-delete-module" href="<?=ADMWEBROOT?>controller/core/modules/installation/supprimer?id_module=<?=$gestion_module_page_syst->getIdModule()[$i]?>">Supprimer</a>
							<?php }else{ ?>
								<a class="installer-module" href="<?=ADMWEBROOT?>controller/core/modules/installation/installer?url=<?=$gestion_module_page_syst->getUrlTelechargement()[$i]?>">Installer</a>
							<?php }?>
						</td>
						<td>
							<?php if ((\core\modules\GestionModule::getModuleInstaller($gestion_module_page_syst->getNom()[$i]) == true) && (\core\modules\GestionModule::getModuleActiver($gestion_module_page_syst->getNom()[$i]) == true)){ ?>
								<?php if (\core\modules\GestionModule::getModuleAJour($gestion_module_page_syst->getNom()[$i]) != 1) { ?>
									<a href="<?=ADMWEBROOT?>controller/core/modules/installation/update?id_module=<?=$gestion_module_page_syst->getIdModule()[$i]?>" class="open-popup" popup="popup-update-module">Mettre à jour</a>
								<?php } else {?>
									Module à jour
								<?php }?>
							<?php } else {?>
								Module non installé et/ou activé
							<?php }?>
						</td>
					</tr>
				<?php endfor;?>
			</tbody>
		</table>
	</div>

	<div class="contenu modifier-contenu gestion-comptes configuration">
		<h2>Modules ajoutés</h2>
		<table>
			<thead>
				<tr>
					<td>Nom du module</td>
					<td>Activer</td>
					<td>Installer | Supprimer</td>
				</tr>
			</thead>
			<tbody>
				<?php for ($i=0 ; $i<count($gestion_module_page->getIdModule()) ; $i++):?>
					<tr>
						<td><?=$gestion_module_page->getNom()[$i]?></td>
						<td>
							<label for="<?=$gestion_module_page->getUrl()[$i]?>" class="checkbox-perso switched">
								<input type="checkbox" class="test-check" id="<?=$gestion_module_page->getUrl()[$i]?>" <?php if (\core\modules\GestionModule::getModuleActiver($gestion_module_page->getNom()[$i]) == true): ?>checked<?php endif;?>>
							</label>
						</td>
						<td>
							<?php if (\core\modules\GestionModule::getModuleInstaller($gestion_module_page->getNom()[$i]) == true) { ?>
								<a class="supprimer open-popup" popup="popup-delete-module" href="<?=ADMWEBROOT?>controller/core/modules/installation/supprimer?id_module=<?=$gestion_module_page->getIdModule()[$i]?>">Supprimer</a>
							<?php }else{ ?>
								<a href="<?=ADMWEBROOT?>controller/core/modules/installation/installer?url=<?=$gestion_module_page->getUrlTelechargement()[$i]?>">Installer</a>
							<?php }?>
						</td>
					</tr>
				<?php endfor;?>
			</tbody>
		</table>
	</div>
</div>