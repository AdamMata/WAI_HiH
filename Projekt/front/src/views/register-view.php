<?php require_once("templates/template-head.html"); ?>
<body>
	<div id=flex-container>
		<?php require_once("templates/template-nav.html") ?>
		<div>
			<form id="login-form" method="POST" action="/register">
					<input type="text" required name="login">
					<label for="login">Login</label><br>

					<input type="password" required name="password">
					<label for="password">Hasło</label><br>
					<input type="password" required name="repeat">
					<label for="repeat">Powtórz hasło</label><br>

					<input type="submit" value="Zarejestruj" id="submit-button">
			</form>
			<span id="auth">
				<?=$auth?>
			</span>
		</div>
	</div>
	<?php require_once("templates/template-footer.html") ?>
</body>