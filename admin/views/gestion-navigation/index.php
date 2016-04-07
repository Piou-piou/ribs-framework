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
			revert: true
		});
		$("#sortable").disableSelection();

		$("#sortable > li").draggable({
			connectToSortable: "#sortable",
			revert: "invalid",
			drag: function(event, ui) {
				$(this).css("background-color", "#ebedf1");
				$(this).css("box-shadow", "0 2px 5px 0 rgba(0, 0, 0, 0.16), 0 2px 10px 0 rgba(0, 0, 0, 0.12)");
				$(this).css("z-index", "200");
			},
			stop: function(event, ui) {
				$(this).css("box-shadow", "none");
				$(this).css("z-index", "0");
				$(this).css("background-color", "inherit");
				$(this).css({display: "none"});
				$(this).fadeIn();
			}
		});
	});
</script>


<div class="inner">
	<div class="contenu modifier-contenu gestion-navigation">
		<ul id="sortable">
			<?php foreach (\core\App::getNav()->getNavigation() as $nav):?>
				<li><a href="<?=$nav[0]?>" title="<?=$nav[3]?>" type="<?=$nav[4]?>"><?=$nav[1]?></a>
					<?php if ((isset($nav[5]) && count($nav[5]) > 0)):?>
						<ul>
							<?php foreach ($nav[5] as $snav):?>
								<li><a href="<?=$snav[0]?>" title="<?=$snav[3]?>" type="<?=$snav[4]?>"><?=$snav[1]?></a></li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
