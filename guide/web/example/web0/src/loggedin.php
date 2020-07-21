<?php
	ob_start();
	session_start();
	include("connect.php");
	if (!$_SESSION["admin"]){
		header('Location: index.php');
	}
?> 

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>SQLi</title>
</head>
<body>
	<h1>Welcome!</h1>
	<h2>CTFGUIDE{SQLI_l0g1n_w17th0u7_p4ssw0rD}</h2>
</body>
</html>