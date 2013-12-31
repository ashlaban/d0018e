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

	<script>
	// Global functions

	// Turning ratings into stars
	$.fn.stars = function()
	{
	    return $(this).each(function()
	    {
	        // Get the value
	        var val = parseFloat($(this).html());
	        console.log(val);
	        // Make sure that the value is in 0 - 5 range, multiply to get width
	        var size = Math.max(0, (Math.min(5, val))) * 16;
	        // Create stars holder
	        var $span = $('<span />').width(size);
	        // Replace the numerical value with stars
	        $(this).html($span);
	    });
	};

	function renderStars()
	{
		$('span.stars').stars();
	};

	</script>

</head>

<!-- Kommentera mig mera -->
<body>
	
		
		<?php include 'html/header.html' ?>

		<div class="container">
			<?php

			if ( isset($_GET["page"]) )
			{
				$vaildPages = array( "user-view", "project-view", "project-details", "project-add" );
				$page = $_GET["page"];

				if ( in_array($page, $vaildPages) )
				{
					include 'html/' . $page . '.html';
				}
				else
				{
					include 'html/error.html';
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

		<?php include 'html/footer.html' ?>

	
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

	</script>

</html>