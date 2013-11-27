<div id="header">
	<nav>
		<a href="/"    ><span class="glyphicon glyphicon-home"       ></span> Home</a>
		<a href="/test"><span class="glyphicon glyphicon-folder-open"></span> Browse</a>
		<a href="/test"><span class="glyphicon glyphicon-plus"       ></span> Add Project</a>
	</nav>

	<div class="login_block" id="logged-out">
		<form action="login-handler.php" method="POST">
			<input type="text"     name="username" placeholder="username" tabindex="1">
			<input type="password" name="password" placeholder="password" tabindex="2">
		</form>
	</div>
	<div class="login_block" id="logged-in">
		<nav>
			<a href="/test">
				<span class="glyphicon glyphicon-user"></span>
				<script>document.write( sessionStorage.username );</script>
			</a>
		</nav>
	</div>

</div>