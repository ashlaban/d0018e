<html>

<head>

	<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
	<meta name="author" content="Kim Albertsson">
	
	<title>Code Mercenary</title>

	<!-- jQuery -->
	<script type="text/javascript" src="./js/jquery-2.0.3.js"   ></script>
	<script type="text/javascript" src="./js/jquery.lorem.js"   ></script>
	<script type="text/javascript" src="./js/jquery.lazyload.min.js"></script>

	<!-- Bootstrap -->
	<link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	<script type="text/javascript" src="lib/bootstrap/js/bootstrap.min.js"></script>

	<!-- Knockout -->
	<script type="text/javascript" src="./js/knockout-3.0.0.js"></script>

	<!-- Holder -->
	<script type="text/javascript" src="./js/holder.js"></script>

	<!-- Handrolled -->
	<link rel="stylesheet" type="text/css" href="css/styles.css">

</head>

<!-- Kommentera mig mera -->
<body>
	
		
		<?php include 'header.php' ?>

		<div class="container">
			<?php

			if ( isset($_GET["page"]) )
			{
				$vaildPages = array( "project-view", "project-details", "project-add" );
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
			else
			{
				echo '<div class="jumbotron">';
  				echo '<h1>Hello, world!</h1>';
  				echo '<p>This is a simple hero unit, a simple jumbotron-style component for calling extra attention to featured content or information.</p>';
  				echo '<p><a class="btn btn-primary btn-lg" role="button">Learn more</a></p>';
				echo '</div>';
			}

			?>
		</div>

		<?php include 'footer.php' ?>

	
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