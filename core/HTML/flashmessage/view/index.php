<div class="module-flashmessage <?=$_SESSION['flash']['type']?>">
	<div class="notification">
		<div class="left">
			<div class="icone">
				<?=$_SESSION['flash']['icone']?>
			</div>
		</div>
		<div class="right">
			<p><?=$_SESSION['flash']['message']?></p>
		</div>
	</div>
</div>

<link rel="stylesheet" type="text/css" href="<?=$chemin?>css/style.css">
<script src="<?=$chemin?>js/_module_flash_message.js"></script>