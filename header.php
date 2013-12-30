<div id="header">
	<nav class="navbar navbar-default">
		<ul class="nav navbar-nav">
			<li class="active"><a href="/"      ><span class="glyphicon glyphicon-home"       ></span> Home</a>       </li>
			<li class="active"><a href="/user"  ><span class="glyphicon glyphicon-home"       ></span> Users</a>      </li>
			<li class="active"><a href="/browse"><span class="glyphicon glyphicon-folder-open"></span> Browse</a>     </li>
			<li class="active"><a href="?page=project-add" ><span class="glyphicon glyphicon-plus"       ></span> Add Project</a></li>
		</ul>

		<!-- Log in  -->
		<div class="login-block" id="logged-out">
			<form class="navbar-form navbar-right" id="logged-out-form">
				<div class="form-group"> <input class="form-control"  type="text"     name="username" placeholder="username" tabindex="1"> </div>
				<div class="form-group"> <input class="form-control"  type="password" name="password" placeholder="password" tabindex="2"> </div>
				<div class="form-group"> <button class="form-control" type="submit" tabindex="3">Log in</button> </div>
				<div class="form-group"> <button class="form-control" tabindex="4" data-toggle="modal" data-target="#sign-up-modal">Sign up</button> </div>
			</form>
		</div>

		<!-- Logged in  -->
		<div class="login-block" id="logged-in">
			<a href="/test">
				<span class="glyphicon glyphicon-user"></span>
				<p class="navbar-text navbar-right">Signed in as <script>document.write( sessionStorage.username );</script></p>
			</a>
			<a href="/" onclick="logout()">Log out</a>
		</div>
	</nav>

	<!-- Modal -->
	<div class="modal fade" id="sign-up-modal" tabindex="-1" role="dialog" aria-labelledby="sign-up-modal-label" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title" id="sign-up-modal-label">Create account</h4>
				</div>
				<div class="modal-body">
					
					<p>
						Do you wish to create an account at this wonderful hideout?
						If so, join our ranks of scurvy free code-pirates, ready to assist you in your project-raids!
					</p>
					
					<form role="form">
						<div class="form-group">
							<label for="sign-up-username-label">Username</label>
							<input type="text" class="form-control" id="signup-username" placeholder="Enter username">
						</div>
						<div class="form-group">
							<label for="sign-up-password-label">Password</label>
							<input type="password" class="form-control" id="signup-password" placeholder="Enter Password">
						</div>
						<div class="form-group">
							<label for="sign-up-password-label">Retype Password</label>
							<input type="password" class="form-control" id="signup-password2" placeholder="Enter password again">
						</div>
						<p>
							Do you wish develop code? Check this box.
						</p>
						<div class="checkbox">
							<label>
								<input type="checkbox" id="signup-developer"> Developer
							</label>
						</div>
						<p>
							Do you wish to propose projects? Check this box.
						</p>
						<div class="checkbox">
							<label>
								<input type="checkbox" id="signup-provider"> Provider
							</label>
						</div>
						<!-- <button type="submit" class="btn btn-primary">Submit</button> -->
					</form>

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					<button type="button" class="btn btn-primary" onclick="signup()">Sign up</button>
				</div>
			</div><!-- /.modal-content -->
		</div><!-- /.modal-dialog -->
	</div><!-- /.modal -->

</div>

<script>
function login( username, password )
{
	function respond( data, status )
	{
		if( !status )
		{
			// Communication failed
			return;
		}

		var json = JSON.parse( data );
		if (json.sessionid)
		{
			// Logged in
			sessionStorage.sessionid = json.sessionid;
			sessionStorage.username  = username;
			window.location.reload(true);
		}
		else
		{
			// Not logged in
		}
	}

	$.post( "/api/login", {username: username, password: password}, respond );
}

function loginForm( e )
{
	e.preventDefault();

	var username = $("input[name='username']").val();
	var password = $("input[name='password']").val();

	login( username, password );

}

function logout()
{
	delete sessionStorage.sessionid;
	delete sessionStorage.username;
}

function signup()
{
	username   = $("#signup-username"  ).val();
	password   = $("#signup-password"  ).val();
	password2  = $("#signup-password2" ).val();
	developer  = $("#signup-developer" ).is(":checked");
	provider   = $("#signup-provider"  ).is(":checked");

	// Error checking
	error = false;
	if ( password !== password2 )
	{
		error = true;
		// TODO: Mark error
		console.log('Passwords do not match');
	}
	if ( password === "" )
	{ 
		error = true;
		// TODO: Mark error
		console.log('Passwords cannot be empty');
	}
	if ( error ) { return; }

	// TODO: Add verification of data
	function signupResponse( data, status )
	{
		json = JSON.parse(data);

		// If sucessful, close modal and log user in.
		// Else update modal with errors.
		if ( json.status === 'success' )
		{
			$('#sign-up-modal').modal('hide');
			$('#sign-up-modal').on('hidden.bs.modal', function (e)
			{
				login( username, password );
			});
			
		}
	}

	obj = {username: username, password: password, isDeveloper: developer, isProvider: provider};
	$.post( "/api/add-user", obj, signupResponse )
}

$("#logged-out-form").submit( loginForm );

</script>