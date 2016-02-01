<?php
	$message = "
		<html>
			<head>
				<meta charset='utf-8'>
				<style>
					h3, h4 {
						font-family: arial, sans-serif;
						color: #8b8b8b;
					}
					h3 {
						font-weight: normal;
					}
					h4 {
						margin-bottom: 5px;
					}
					p {
						margin-top: 0px;
					}
					strong {
						color: #000;
					}
				</style>
			</head>
			<body>
				<h3>Message laissé depuis ribs pour le nom de domaine : <strong>" .$_SERVER['HTTP_HOST']."</strong></h3>
				<h3>Type du message : <strong>$type</strong></h3>

				<h4>Ci-dessous la demande</h4>
				<p>".nl2br($demande)."</p>
			</body>
		</html>
	";