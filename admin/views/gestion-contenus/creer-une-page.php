<header>
	<div class="inner">
		<h1>Gestion des contenus : </h1>
		<h2>Création d'une page</h2>
	</div>
</header>
<?php include("header.php"); ?>
<?php include("admin/controller/ckeditor.php"); ?>
<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>checkbox/css/style.css">

<div class="inner">
	<section class="contenu modifier-contenu gestion-comptes">
		<h2>Parti concernant la redirection d'url</h2>

		<table>
			<tr>
				<td>Est ce que cette page doit renvoyer vers une page externe au site</td>
				<td>
					<label for="redirect" class="checkbox-perso switched">
						<input type="checkbox" class="test-check" id="redirect">
					</label>
				</td>
			</tr>
		</table>
	</section>
</div>


<form action="<?=ADMWEBROOT?>controller/core/admin/contenus/gestion/creer_page" method="post">
	<button type="submit" class="submit-contenu" type="submit"><i class="fa fa-check"></i>Valider</button>

	<div id="creer-page">
		<div class="inner">
			<section class="contenu modifier-contenu">
				<h2>Partie concernant le référencement SEO</h2>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="balise_title" data-error="Le titre pour le navigateur doit être entre 10 et 70 caractères">Titre pour le navigateur</label>
						<input type="text" name="balise_title" type-val="string" min="10" max="70" value="<?=$balise_title?>" required=""/>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="url" data-error="L'url doit être comprise entre 3 et 92 caractères">Url affichée dans le navigateur</label>
						<input type="text" name="url" type-val="string" min="3" max="92" value="<?=$url?>" <?php if ($id_page_courante == 1): ?>disabled<?php endif; ?> required=""/>
					</div>
				</div>

				<div class="bloc no-input">
					<label class="label label-textarea" for="meta_description" data-error="La description doit être comprise entre 10 et 158 caractères">Description de votre site pour le navigateur (maximum 160 caractères)</label>
					<textarea name="meta_description" type-val="string" min="10" max="158" required=""><?=$meta_description?></textarea>
				</div>
			</section>

			<section class="contenu modifier-contenu">
				<h2>Partie concernant l'affichage dans la navigation</h2>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="titre_page"  data-error="Le titre de la page doit être entre 4 et 20 caractères">Titre de la page (utilisée pour le menu)</label>
						<input type="text" name="titre_page" type-val="string" min="4" max="20" value="<?=$titre_courant?>" required=""/>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="parent">Parent de la page</label>
						<input liste-deroulante="true" multi="false" type="text" name="parent" value="<?=$parent_courant?>"/>
					</div>
					<div class="liste-deroulante">
						<li>test
							<ul>
								<li>tedgf</li>
							</ul>
						</li>
						<li>test 1</li>
					</div>
				</div>
			</section>
		</div>
	</div>
</form>


<form action="<?=ADMWEBROOT?>controller/core/admin/contenus/gestion/creer_page_redirect" method="post">
	<button type="submit" class="submit-contenu cache" type="submit"><i class="fa fa-check"></i>Valider</button>

	<div id="redirect-page" class="cache rotateY90 animate">
		<div class="inner">
			<section class="contenu modifier-contenu">
				<h2>Partie concernant le référencement SEO</h2>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="balise_title" data-error="Le titre pour le navigateur doit être entre 10 et 70 caractères">Titre pour le navigateur</label>
						<input type="text" name="balise_title" type-val="string" min="10" max="70" value="<?=$balise_title?>" required=""/>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="url" data-error="L'url doit être comprise entre 3 et 92 caractères">Url affichée dans le navigateur</label>
						<input type="text" name="url" type-val="string" min="3" max="92" value="<?=$url?>" <?php if ($id_page_courante == 1): ?>disabled<?php endif; ?> required=""/>
					</div>
				</div>
			</section>

			<section class="contenu modifier-contenu">
				<h2>Partie concernant l'affichage dans la navigation</h2>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="titre_page"  data-error="Le titre de la page doit être entre 4 et 20 caractères">Titre de la page (utilisée pour le menu)</label>
						<input type="text" name="titre_page" type-val="string" min="4" max="20" value="<?=$titre_courant?>" required=""/>
					</div>
				</div>
				<div class="colonne">
					<div class="bloc">
						<label class="label" for="parent">Parent de la page</label>
						<input liste-deroulante="true" multi="false" type="text" name="parent" value="<?=$parent_courant?>"/>
					</div>
					<div class="liste-deroulante">
						<li>test
							<ul>
								<li>tedgf</li>
							</ul>
						</li>
						<li>test 1</li>
					</div>
				</div>
			</section>
		</div>
	</div>
</form>

<script src="<?=LIBSWEBROOT?>checkbox/js/anim.js"></script>