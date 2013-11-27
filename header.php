<div id="header">
	<nav>
		<a href="/"                ><span class="glyphicon glyphicon-home"       ></span> Home</a>
		<a href="?page=browse"     ><span class="glyphicon glyphicon-folder-open"></span> Browse</a>
		<a href="?page=add-project"><span class="glyphicon glyphicon-plus"       ></span> Add Project</a>
	</nav>

	<div class="login-block" id="logged-out">
		<form id="logged-out-form">
			<input type="text"     name="username" placeholder="username" tabindex="1">
			<input type="password" name="password" placeholder="password" tabindex="2">
			<input type="submit" class="non-displayed" hidefocus="true" tabindex="-1">
		</form>
	</div>
	<div class="login-block" id="logged-in">
		<nav>
			<a href="/test">
				<span class="glyphicon glyphicon-user"></span>
				<script>document.write( sessionStorage.username );</script>
			</a>
		</nav>
	</div>

</div>

<script>
$("#logged-out-form").submit( function(e)
{
	e.preventDefault();

	var username = $("input[name='username']").val();
	var password = $("input[name='password']").val();

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
});
</script>