<!DOCTYPE html>
<html>
<head>
	<?php
		require_once('funkcije.php');
		Head();
	?>
</head>
</html>

<?php
session_start();

session_unset();
session_destroy();

header("location: zacetna.php");
?>