<?php require_once("templates/template-head.html"); ?>
<body>
	<div id=flex-container>
		<?php require_once("templates/template-nav.html") ?>
		<div>
			<?php if (!isset($user)): ?>
				<form id="login-form" method="POST" action="/account">
					<input type="text" required name="login">
					<label for="login">Login</label><br>

					<input type="password" required name="password">
					<label for="password">Hasło</label><br>

					<input type="submit" value="Zaloguj" id="submit-button">
				</form>
				<span id="auth"><?=$auth?></span>
				<a href="/register">Załóż konto</a>
			<?php else: ?>
				<h2>Witaj <?=$user?></h2>
				<a href="/account?perform=logout">Wyloguj</a>				
			<?php endif ?>
		</div>
	</div>
	<?php require_once("templates/template-footer.html") ?>
</body>