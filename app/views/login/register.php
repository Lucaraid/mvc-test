<?php
if(!empty($data)) {
	foreach ($data as $error) {
		echo $error . "<br />";
	}
}
?>
<h1><b>Register</b></h1>
<form action="<?= URL.PUBLICURL.'profile/register' ?>" method="post">
	<div class="field">
		<label for="user_name">Username</label>
		<input type="text" name="user_name" id="user_name" value="<?php echo escape(Input::get('user_name')); ?>" autocomplete="off">
	</div>
	<div class="field">
		<label for="user_pass">Password</label>
		<input type="password" name="user_pass" id="user_pass" autocomplete="off">
	</div>
	<div class="field">
		<label for="repeat_user_pass">Repeat Password</label>
		<input type="password" name="repeat_user_pass" id="repeat_user_pass" autocomplete="off">
	</div>
	<div class="field">
		<label for="user_fullname">Name</label>
		<input type="text" name="user_fullname" id="user_fullname" value="<?php echo escape(Input::get('user_fullname')); ?>" autocomplete="off">
	</div>
	<input type="hidden" name="token" value="<?php echo Token::generate(); ?>">
	<input type="submit" value="Register">
</form>