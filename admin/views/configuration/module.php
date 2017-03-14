<header>
	<div class="inner">
		<h1>Configuration | modules</h1>
	</div>
</header>
<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>checkbox/css/style.css">
<script src="<?=LIBSWEBROOT?>checkbox/js/anim.js"></script>
<?php require_once(ROOT."admin/views/configuration/js/configuration.php"); ?>
<?php require_once('header.php'); ?>

<div class="inner">
	<?php require_once(LIBSROOT."barre_chargement/index.php"); ?>
	<div class="contenu modifier-contenu">
		<h2>Ajouter un module</h2>
		<p>To come</p>
	</div>

	<div class="contenu modifier-contenu gestion-comptes configuration">
		<h2>Modules ajoutés</h2>
		<table>
			<thead>
				<tr>
					<td>Nom du module</td>
					<td>Activer</td>
					<td>Supprimer</td>
				</tr>
			</thead>
			<tbody>
				<?php for ($i = 0; $i < count($gestion_module_page->getIdModule()); $i++):?>
					<tr>
						<td><?=$gestion_module_page->getNom()[$i]?></td>
						<td>
							<label for="<?=$gestion_module_page->getUrl()[$i]?>" class="checkbox-perso switched">
								<input type="checkbox" class="test-check" id="<?=$gestion_module_page->getUrl()[$i]?>" <?php if (\core\modules\GestionModule::getModuleActiver($gestion_module_page->getNom()[$i]) === true): ?>checked<?php endif; ?>>
							</label>
						</td>
						<td>
							<?php if (\core\modules\GestionModule::getModuleInstaller($gestion_module_page->getNom()[$i]) == 1) { ?>
								<a class="supprimer open-popup" popup="popup-delete-module" href="<?=ADMWEBROOT?>controller/core/modules/installation/supprimer?id_module=<?=$gestion_module_page->getIdModule()[$i]?>">Supprimer</a>
							<?php }?>
						</td>
					</tr>
				<?php endfor; ?>
			</tbody>
		</table>
	</div>
</div>