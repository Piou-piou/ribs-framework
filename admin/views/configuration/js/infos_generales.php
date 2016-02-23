<script>
	$(document).ready(function() {
		$(".test-check").click(function() {
			var option = $(this).attr("id");

			if (this.checked) var activer = 1;
			else var activer = 0;

			$(".progress").css({display: "block"});

			$.ajax({
				method: 'GET',
				url:"<?=ADMWEBROOT?>controller/core/admin/configuration/modifier_option.php",
				data: "option="+option+"&activer="+activer,
				success: function(data){
					if (data == "success") {
						window.location.reload(true);
					}
					else {
						$("body").prepend(data);
					}
				}
			});
		});
	})
</script>