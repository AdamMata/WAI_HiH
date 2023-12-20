<?php require_once("templates/template-head.html"); ?>
<body>
	<div id=flex-container>
		<?php require_once("templates/template-nav.html") ?>
		<div>
			<?php if ($account == null): ?>
				<form id="login-form" method="POST" action="/account">
					<input type="text" required name="login">
					<input type="password" required name="password">

					<input type="submit" value="Wyślij" id="submit-button">
                	<input type="button" value="Wyczyść" id="clear-button">
				</form>
				<a href="/register">Załóż konto</a>
			<?php else: ?>
				<h2>Witaj <?=$account?></h2>
			<?php endif ?>
		</div>
	</div>
	<?php require_once("templates/template-footer.html") ?>
</body>