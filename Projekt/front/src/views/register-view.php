<?php require_once("templates/template-head.html"); ?>
<body>
	<div id=flex-container>
		<?php require_once("templates/template-nav.html") ?>
		<div>
			<form id="login-form" method="POST" action="/register">
				<input type="text" required name="login">
				<input type="password" required name="password">
				<input type="password" required name="repeat">

				<input type="submit" value="Wyślij" id="submit-button">
                <input type="button" value="Wyczyść" id="clear-button">
			</form>
			<span id="auth">
				<?=$auth?>
			</span>
		</div>
	</div>
	<?php require_once("templates/template-footer.html") ?>
</body>