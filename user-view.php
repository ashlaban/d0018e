<!-- WARNING: Must be included in an environment including knockout-3.0.0 -->

<link href="css/user-view.css" rel="stylesheet">

<div id="user-view">
	
	<h2 data-bind="text: username">Username</h2>

	<hr>

	<dl class="dl-horizontal">
		<dt>Bio</dt>
		<dd>This space is intended for a short biography for the user. It will not, however, be implemented anytime soon.</dd>
		<dt>Functions</dt>
		<dd>isProvider? isDeveloper?</dd>
		<!-- TODO: Remove the concept of isProvider and isDeveloper altogether. This should always be available to all users. Relevant userdata is instead introduction, image etc. Completed projects? -->
		<dt>Rating</dt>
		<dd><span class="stars" data-bind="text: rating"></span></dd>
	</dl>

	<hr>

	<div id="comments">
		<h4>Comments</h4>
		<!-- ko foreach: comments -->
		<div class="comment">
			<dl class="dl-horizontal">
				<dt><a href="#" data-bind="text: username">Username</a></dt>
				<dd><p data-bind="text: comment">Comment text</p></dd>
			</dl>
		</div>
		<!-- /ko -->

		<div id="add-comment">
			<textarea id="add-comment-area" placeholder="Enter Comment..."></textarea>
			<button id="add-comment-btn" onclick="submitComment()">Post</button>
		</div>
	</div>

</div>

<script>

// Knockout - databindings for updating user panels
function ProjectViewModel()
{
	var self = this;
	self.username = ko.observable(null);
	self.rating   = ko.observable(null);

	self.handleGetUser = function( data )
	{
		var jsonObject = $.parseJSON( data );
		self.username( jsonObject[0].username );
		self.rating(   jsonObject[0].rating   );
		renderStars();
	}
}

var userViewModel = new ProjectViewModel()
ko.applyBindings( userViewModel, $('#knockout-users')[0] );

// End Knockout

var username = "<?php echo $_GET['username']?>";
$.post( "/api/get-user", { username: username }, userViewModel.handleGetUser );

// Privileges for logged in users
// Note that a vaild token is required to post to api so it is ok to disable stuff in browser
if (sessionStorage.username == null)
{
	$('#add-comment-area')[0].disabled = true;
	$('#add-comment-btn' )[0].disabled = true;
}

</script>