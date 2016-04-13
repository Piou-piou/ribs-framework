<script>
	$(document).ready(function() {
		$(".menu .titre i").click(function() {
			$(this).parent().parent().toggleClass("active");

			$.ajax({
				method: 'POST',
				url:"<?=ADMWEBROOT?>controller/core/admin/navigation/menu/gestion.php",
			});
		});

		$(".menu ul li").click(function() {
			window.location = $(this).find("a").attr("href");
		});
	})
</script>