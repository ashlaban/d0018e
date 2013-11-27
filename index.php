<html>

<head>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta name="author" content="Kim Albertsson">
	
	<title>Code Mercenary</title>

	<!-- jQuery -->
	<script type="text/javascript" src="./js/jquery-2.0.3.js"></script>
	<script type="text/javascript" src="./js/jquery.lorem.js"></script>

	<!-- Bootstrap -->
	<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="lib/bootstrap/js/bootstrap.min.js"></script>

	<!-- Handrolled -->
	<link rel="stylesheet" type="text/css" href="css/styles.css">

</head>

<!-- Kommentera mig mera -->
<body>
	<div id="wrapper">
		
		<?php include 'header.php' ?>

		<div id="content">
			<?php

			if ( isset($_GET["page"]) )
			{
				$vaildPages = array( "browse", "add-project" );
				$page = $_GET["page"];

				if ( in_array($page, $vaildPages) )
				{
					include $page . '.php';
				}
				else
				{
					include 'error.html';
				}
			}

			?>


		</div>

		<?php include 'footer.php' ?>

	</div>
</body>

	<script>
		function loginTest()
		{
			if ( sessionStorage.sessionid )
			{
				document.getElementById("logged-out").style.display = "none";
			}
			else
			{
				document.getElementById("logged-in").style.display = "none";
			};
		}

		$(document).ready( loginTest() );

		function respondTest( data, status )
		{
			//alert(data);
			var items = $('.project-view .desc');
			for (var i = items.length - 1; i >= 0; i--) {
				items[i].innerHTML = data;
			};
		}
		//$(document).ready($.post( "/project-handler.php", {projectid: 1}, respondTest ) );

	</script>

</html>