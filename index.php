<?php

include("includes/config.php");

// session_destroy(); // this is for logout

if (isset($_SESSION['userLoggedIn'])) {
	$userLoggedIn = $_SESSION['userLoggedIn'];
} else {
	header("Location: register.php");
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>Hello</title>
</head>

<body>
  Hello world!!!
</body>

</html>