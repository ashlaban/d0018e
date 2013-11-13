<html>

<head>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta name="author" content="Kim Albertsson">
	
	<title>D0018E - Test Site</title>

</head>

<!-- Kommentera mig mera -->
<body>

	<?php

	#phpinfo( -1 );

	$db = pg_connect("host=localhost dbname=testdb user=db-man");

	echo pg_get_pid($db) . "\n";
	?>

</body>

</html>