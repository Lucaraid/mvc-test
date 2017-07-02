<?php
if(!empty($data)) {
	foreach ($data as $error) {
		echo $error . "<br />";
	}
}
?>
<form action="<?= URL.PUBLICURL.'profile/login' ?>" method="post">
	<div class="field">
		<label for="user_name">Username</label>
		<input type="text" name="user_name" id="user_name" autocomplete="off">
	</div>
	<div class="field">
		<label for="user_pass">Password</label>
		<input type="password" name="user_pass" id="user_pass" autocomplete="off">
	</div>
	<div class="field">
		<label for="remember">
			<input type="checkbox" name="remember" id="remember"> Remember me
		</label>
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Log In">
</form>