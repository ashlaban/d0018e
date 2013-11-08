<html>

<head>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta name="author" content="Kim Albertsson">
	
	<title>D0018E - Test Site</title>

</head>

<!-- Kommentera mig mera -->
<body style="height:100%; overflow:hidden; margin:0px; padding:0px" >

	<?php
	$db = new SQLite3('database.db');

	$res = $db->query( "SELECT * FROM test" );
	echo(  var_dump( $res->fetchArray() ) );

	$db->close();
	?>

</body>

</html>