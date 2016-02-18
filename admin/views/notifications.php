<?php \core\admin\Admin::setNotificationVue(); ?>

<header>
	<div class="inner">
		<h1>Notifications systèmes</h1>
	</div>
</header>

<div class="inner">
	<div class="contenu modifier-contenu gestion-comptes">
		<h2>Notifications concernant un module</h2>

		<?php if ($gestion_module->getListeModuleMettreJour() == true): ?>
			<h3>Modules qui ont besoin d'être mis à jour</h3>


			<table>
				<thead>
					<tr>
						<td>Nom du module</td>
						<td>Version actuelle</td>
						<td>Nouvelle version disponible</td>
					</tr>
				</thead>
				<tbody>
					<?php for ($i=0 ; $i<count($gestion_module->getNom()) ; $i++):?>
						<tr>
							<td><?=$gestion_module->getNom()[$i]?></td>
							<td><?=$gestion_module->getVersion()[$i]?></td>
							<td><?=$gestion_module->getOnlineVersion()[$i]?></td>
						</tr>
					<?php endfor;?>
				</tbody>
			</table>

			<h3>Mettre à jour le/les module(s)</h3>
			<p>Pour mettre à jour le/les module(s) rendez-vous sur la page de configuration des modules. Vous pouvez vous y rendre
				soit par le menu ou en cliquant sur le lien ci-dessous.
			</p>
			<a href="<?=ADMWEBROOT?>configuration/module" class="submit-contenu submit-standard no-shadow inline ml0">Configuration des modules</a>
		<?php endif;?>
	</div>
</div>