<?php
	ob_start();
	session_start();
	include("connect.php");
?> 

<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>SQLi</title>
</head>
<body>
	<h1>Welcome!</h1>
	<h3>Please log in!</h3>
	<form method="POST" autocomplete="off">
		<p>
			Username: <input type="text" id="uid" name="uid"><br /></br />
			Password: <input type="password" id="password" name="password">
		</p>
		<p>
			<input type="submit" value="Submit"/> 
		</p>
	</form>

	<?php
		if (!empty($_REQUEST['uid']))
		{
			$username = ($_REQUEST['uid']);
			$pass = $_REQUEST['password'];

			$q = "SELECT * FROM users WHERE username='".$username."' AND password = '".$pass."'";

			if (!mysqli_query($con, $q)){
				echo 'Error: ' . mysqli_error($con);
			}
			else{
				$result = mysqli_query($con, $q);

				if (mysqli_warning_count($con)){
					$e = mysqli_get_warnings($con);
					if ($e){
						do{
							echo "Warning: $e->errno: $e->message\n";
						}
						while ($e->next());
					}
				}

				echo "<br />";
				$row = mysqli_fetch_array($result);

				if ($row){
					$_SESSION["admin"] = True;
					header('Location: loggedin.php');
				}
				else{
					echo "<font style=\"color:#FF0000\">Invalid password!</font\>";
				}
			}
		}
	?>
</body>
</html>