<?php
// Create connection
$DBUSER = 'hmif';
$DBPASS = 'hmif';

$con=mysqli_connect('db', $DBUSER,$DBPASS, 'sqli_db');

// Check connection
if (mysqli_connect_errno($con))
  {
  echo "<font style=\"color:#FF0000\">Could not connect:". mysqli_connect_error()."</font\>";
  }
?>