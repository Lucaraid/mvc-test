This is the Login/index View

<?php

if (Session::exists('home')) {
	echo '<p>' . Session::flash('home') . '</p>';
}
echo "<br />";

$user = new User(); 
if ($user->isLoggedin()) {
?>
	<p>Hello <a href="#"><?php echo escape($user->data()->user_name) ?></a>!</p>

	<ul>
		<li><a href="<?php echo URL . PUBLICURL . "profile/logout" ?>">Logout</a></li>
	</ul>
<?php
} else {
echo '<p>You need to <a href="' . URL . PUBLICURL . "profile/login" . '">Log in</a> or <a href="' . URL . PUBLICURL . "profile/register" . '">Register</a></p>';
}
?>