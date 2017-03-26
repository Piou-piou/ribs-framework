<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?=$arr_page["app"]["contenus"]["balise_title"]?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?=$arr_page["app"]["contenus"]["meta_description"]?>">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
		<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/foundation.css">
		<script src="<?=TPLWEBROOT?>js/nav-responsive.js"></script>
		<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/style.css">
	</head>
	<?=\core\HTML\flashmessage\FlashMessage::getFlash();?>
	<body>
		<?php
			if ($config->getDesactiverNavigation() != 1) {
				echo $twig->render("template/navigation.html", $arr_page);
			}
			
			unset($arr_page["app"]["navigation"]);
		?>

		<?php echo $twig->render($page.".html", array_merge(array_merge(array_merge(array_merge($arr, $constant), $_REQUEST), $_SESSION), $arr_page)); ?>

		<script>
			$(document).ready(function() {
				$("div").each(function() {
					$(this).removeAttr("contenteditable").blur();
				})
			})
		</script>
	</body>
</html>