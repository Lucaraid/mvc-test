<?php
function ReplaceBadWords($str, $bad_words, $replace_str){
    if (!is_array($bad_words)){ $bad_words = explode(',', $bad_words); }
    for ($x=0; $x < count($bad_words); $x++){
        $fix = isset($bad_words[$x]) ? $bad_words[$x] : '';
        $_replace_str = $replace_str;
        if (strlen($replace_str)==1){ 
            $_replace_str = str_pad($_replace_str, strlen($fix), $replace_str);
        }
        $str = preg_replace('/'.$fix.'/i', $_replace_str, $str);
    }
    return $str;
}
$string = "Ich heisse Luca bad2" . "<br />"; // inputed string
$bad_words = array("bad1", "bad2", "bad3"); // bad words
$replace_str = "@#$*!";
print ReplaceBadWords($string, $bad_words, $replace_str);

	require_once('../config/global.php');
	require_once('../libs/functions.php');
	spl_autoload_register(function($class){
		require_once('../libs/' . $class . '.class.php');
	});
if (isset($_POST['create'])) {
  $con = mysqli_connect(Config::get('mysql/host'), Config::get('mysql/user'), Config::get('mysql/pass'));
  $sql = "
    SET SQL_MODE = " . '"' . "NO_AUTO_VALUE_ON_ZERO" . '"' . ";
    SET time_zone = " . '"' . "+00:00" . '"' . ";

    --
    -- Datenbank: `config`
    --
    CREATE DATABASE IF NOT EXISTS `" . Config::get('mysql/config_db') . "` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
    USE `" . Config::get('mysql/config_db') . "`;

    -- --------------------------------------------------------

    --
    -- Tabellenstruktur für Tabelle `groups`
    --

    CREATE TABLE IF NOT EXISTS `groups` (
      `group_id` int(11) NOT NULL,
        `user_name` varchar(30) NOT NULL,
        `group_permissions` text NOT NULL
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=3 ;

    -- --------------------------------------------------------

    --
    -- Tabellenstruktur für Tabelle `users`
    --

    CREATE TABLE IF NOT EXISTS `users` (
      `user_id` int(11) NOT NULL,
        `user_name` varchar(30) NOT NULL,
        `user_pass` varchar(64) NOT NULL,
        `user_salt` varchar(32) NOT NULL,
        `user_fullname` varchar(50) NOT NULL,
        `user_joined` datetime NOT NULL,
        `user_group` int(11) NOT NULL
    ) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

    -- --------------------------------------------------------

    --
    -- Tabellenstruktur für Tabelle `users_session`
    --

    CREATE TABLE IF NOT EXISTS `users_session` (
      `session_id` int(11) NOT NULL,
        `user_id` int(11) NOT NULL,
        `session_hash` varchar(64) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

    --
    -- Indexes for table `groups`
    --
    ALTER TABLE `groups`
    ADD PRIMARY KEY (`group_id`);

    --
    -- Indexes for table `users`
    --
    ALTER TABLE `users`
    ADD PRIMARY KEY (`user_id`);

    --
    -- Indexes for table `users_session`
    --
    ALTER TABLE `users_session`
    ADD PRIMARY KEY (`session_id`);
    
    --
    -- AUTO_INCREMENT for dumped tables
    --
    --
    -- AUTO_INCREMENT for table `groups`
    --
    ALTER TABLE `groups`
    MODIFY `group_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
    --
    -- AUTO_INCREMENT for table `users`
    --
    ALTER TABLE `users`
    MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
    --
    -- AUTO_INCREMENT for table `users_session`
    --
    ALTER TABLE `users_session`
    MODIFY `session_id` int(11) NOT NULL AUTO_INCREMENT;";

  // Check connection
  if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error() . "<br />";
  }

  // Create database
  if ($con->multi_query($sql)) {
    echo "Database `" . Config::get('mysql/config_db') . "` created successfully" . "<br />";
  } else {
    echo "Error creating database: " . mysqli_error($con) . "<br />";
  }
}
?>
Create Database `<?= Config::get('mysql/config_db') ?>` <form method="post" style="display: inline;"><button name="create">NOW!</button></form>