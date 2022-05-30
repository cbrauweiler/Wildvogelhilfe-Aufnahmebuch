<?php

# mySQL Environment
$sql_servername = 'localhost';
$sql_user = 'wildvogelhilfe';
$sql_pass = '4&s9QGDg@3#MSweC';
$sql_db = 'wildvogelhilfe';

# mySQL Connect
$mysqli = new mysqli($sql_servername, $sql_user, $sql_pass, $sql_db);

if ($mysqli->connect_error) {
	$mysql_con = 'Connect Error ('.$mysqli->connect_errno.') - '.$mysqli->connect_error;
	echo $mysql_con;
}
else { $mysql_con = 'Success... '.mysqli_get_host_info($mysqli); }

if (!$mysqli->set_charset("utf8")) {
	
	$mysql_characterset = 'Error loading character set utf8: '.$mysqli->error;
	
}
else {
	
	$mysql_characterset = 'Current character set: '.$mysqli->character_set_name();

}

# PHP Timezone
date_default_timezone_set('Europe/Berlin');

?>