<!DOCTYPE html>
<html lang="fr">
	<head>
		<title><?=$titre_page?></title>
		<meta charset="utf-8">
		<meta name="description" content="<?=$description_page?>">
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>libs/font_awesome/css/font-awesome.min.css">
		<link rel="stylesheet" type="text/css" href="<?=WEBROOT?>libs/font_awesome/css/animate.css">
		<?php if ($config->getResponsive() == 1){?>
			<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;">
			<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/foundation.css">
			<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/nav-responsive.css">
			<script src="<?=TPLWEBROOT?>js/nav-responsive.js"></script>
		<?php } else {?>
		<link rel="stylesheet" type="text/css" href="<?=LIBSWEBROOT?>reset_css/reset.css">
		<?php } ?>
		<link rel="stylesheet" type="text/css" href="<?=TPLWEBROOT?>css/style.css">
	</head>
	<?=\core\HTML\flashmessage\FlashMessage::getFlash();?>
	<body>
		<?php require_once(ROOT."app/views/template/navigation.php");?>
		<?php if ($config->getResponsive() == 1) require_once(ROOT."app/views/template/nav_responsive.php");?>


		<?php echo $twig->render($page.".html", array_merge($arr, $constant)); ?>

		<script>
			$(document).ready(function() {
				$("div").each(function() {
					$(this).removeAttr("contenteditable").blur();
				})
			})
		</script>
	</body>
</html>