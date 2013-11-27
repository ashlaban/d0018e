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

			#phpinfo( -1 );
			#$db = pg_connect("host=localhost dbname=testdb user=db-man");
			#echo pg_get_pid($db) . "\n";
			#pg_close( $db );

			include 'project.php';
			include 'project.php';
			include 'project.php';

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

		function submitOnEnter( event )
		{
	    	var keypressed = event.keyCode || event.which;
	    	if (keypressed == 13) {
	        	// $(this).closest("form").submit();
	        	loginForm();
	    	};
	    }
	    function loginForm()
		{

			var username = $("input[name='username']").val();
			var password = $("input[name='password']").val();
			login( username, password );
		}
		function login( username, password )
		{
			function respond( data, status )
			{
				//Call a function when the state changes.
				if( status )
				{
					var json = JSON.parse( data );
					if (json.sessionid)
					{
						sessionStorage.sessionid = json.sessionid;
					 	sessionStorage.username  = username;
					}

					window.location.reload(true);
				}
			}

			$.post( "/login-handler.php", {username: username, password: password}, respond )
		};

		$(document).ready( loginTest() );
		$(document).ready( $("input[name=username]").keydown( submitOnEnter ) );
		$(document).ready( $("input[name=password]").keydown( submitOnEnter ) );

		function respondTest( data, status )
		{
			//alert(data);
			var items = $('.project-view .desc');
			for (var i = items.length - 1; i >= 0; i--) {
				items[i].innerHTML = data;
			};
		}
		$(document).ready($.post( "/project-handler.php", {projectid: 1}, respondTest ) );

	</script>

</html>