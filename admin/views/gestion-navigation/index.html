<header>
	<div class="inner">
		<h1>Gestion de la navigation</h1>
	</div>
</header>
<?php include("header.php"); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>

<script>
	$(function() {
		$("#sortable").sortable({
			revert: true,
			update: function() {
				$.ajax({
					type: "POST",
					url: "<?=ADMWEBROOT?>controller/core/admin/navigation/ordre/set.php",
					data: $(this).sortable("serialize"),
					success: function(data) {
						$("body").prepend(data);
					}
				})
			}
		});
		$("#sortable").disableSelection();
	});
</script>


<div class="inner">
	<div class="contenu modifier-contenu gestion-navigation">
		<ul id="sortable">
			<?php foreach (\core\App::getNav()->getNavigation() as $nav):?>
				<li id="lien_<?=$nav[0]?>.<?=$nav[4]?>"><a href="<?=$nav[0]?>" title="<?=$nav[3]?>"=><?=$nav[1]?></a>
					<?php if ((isset($nav[5]) && count($nav[5]) > 0)):?>
						<ul>
							<?php foreach ($nav[5] as $snav):?>
								<li><a href="<?=$snav[0]?>" title="<?=$snav[3]?>"><?=$snav[1]?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
