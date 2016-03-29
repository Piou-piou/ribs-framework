<script>
	$(document).ready(function() {
		$(".submit-contenu").click(function(e) {
			e.preventDefault();

			var id_page = $("#id_page").val();
			var contenu = $("#admin-page").html();

			$.ajax({
				method: 'GET',
				url:"<?=ADMWEBROOT?>controller/core/admin/contenus/gestion/contenus_inline.php",
				data: "id_page="+id_page+"&contenu="+contenu,
				success: function(){
					window.location.reload(true);
				}
			});
		})
	});
</script>
