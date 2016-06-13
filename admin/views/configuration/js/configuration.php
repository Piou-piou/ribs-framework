<script>
	$(document).ready(function() {
		//pour détecter si checkbox dans module est checké ou pas
		$(".test-check").click(function() {
			var url_module = $(this).attr("id");

			if (this.checked) var activer = 1;
			else var activer = 0;

			$(".progress").css({display: "block"});

			$.ajax({
				method: 'GET',
				url:"<?=ADMWEBROOT?>controller/core/modules/activation/activer_desactiver.php",
				data: "activer="+activer+"&url_module="+url_module,
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

		//pour supprimer un module
		$("#config-suppress-ajax").click(function(e) {
			e.preventDefault();

			$(".progress").css({display: "block"});

			var href = $(this).attr("href");

			var split = href.split("=");
			var id_module = split[1];

			ajaxDeleteUpdateModule(href, id_module);
		});

		//pour installer un module systeme
		$(".installer-module").click(function(e) {
			e.preventDefault();

			$(".progress").css({display: "block"});

			var href = $(this).attr("href");

			var split = href.split("=");
			var url = split[1];

			ajaxInstallModule(href, url);
		});

		//pour installer un module non systeme
		$("#form-install").submit(function(e) {
			e.preventDefault();

			$(".progress").css({display: "block"});

			var href = $("#form-install").attr("action");

			var url = $("#form-install input").val();

			ajaxInstallModule(href, url);
		});


		function ajaxDeleteUpdateModule(url, id_module) {
			$.ajax({
				method: 'GET',
				url:url,
				data: "id_module="+id_module,
				success: function(data){
					if (data == "success") {
						window.location.reload(true);
					}
					else {
						$("body").prepend(data);
					}
				}
			});
		}



		function ajaxInstallModule(href, url) {
			$.ajax({
				method: 'GET',
				url:href,
				data: "url="+url,
				success: function(data){
					if (data == "success") {
						window.location.reload(true);
					}
					else {
						$("body").prepend(data);
					}
				}
			});
		}
	})
</script>