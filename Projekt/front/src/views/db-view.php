<h1>users</h1>
<pre>
	<?php
		$users = get_db()->users->find();
		foreach ($users as $user) {
			print_r($user);
		}
	?>
</pre>
<h1>images</h1>
<pre>
	<?php
		$screenshots = get_db()->screenshots->find();
		foreach ($screenshots as $screenshot) {
			print_r($screenshot);
		}
	?>
</pre>
<h1>session</h1>
<pre>
	<?php
		print_r($_SESSION);
	?>
</pre>
