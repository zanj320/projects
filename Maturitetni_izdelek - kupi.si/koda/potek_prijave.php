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

echo ' Vaša prijava je potekla!<br/>';
echo ' Preusmerjanje...';
header("refresh:2; url = zacetna.php");
?>