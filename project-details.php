<!-- WARNING: Must be included in an environment including knockout-3.0.0 -->

<link href="css/project-details.css" rel="stylesheet">

<div id="project-details">

	<h2 data-bind="text: projectname">Project Name</h2>
	<!-- <button type="button" class="btn btn-default">Apply</button> -->
	<hr>

	<div class="row">
		<div class="col-md-6">
			
			<h4>Basic Information</h4>

			<img class="center-block lazy" data-src="holder.js/300x200" width="300" height="200">
			<dl class="dl-horizontal">
				<dt>Author</dt>       <dd data-bind="text: owner">Placeholder for owner</dd>
				<dt>Creation Date</dt><dd data-bind="text: createddate">Date placeholder</dd>
				<dt>Description</dt>  <dd data-bind="text: description">Description placeholder</dd>
			</dl>

		</div>

		<div class="col-md-6">
			
			<h4>Tasks</h4>
			
			<!-- ko foreach: tasks -->
			<div class="panel panel-default">
				<div class="panel-heading">Task Name <!-- Additional buttons, markers? --></div>
				<div class="panel-body">Description - Hidden first?</div>
			</div>
			<!-- /ko -->
		</div>

	</div>
	
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
			<textarea id="add-comment-area">Placeholder?</textarea>
			<button id="add-comment-btn" onclick="submitComment()">Post</button>
		</div>
	</div>

</div>

<script>

// Knockout - databindings for updating project panels
function ProjectDetailsModel()
{
	var currentProject = JSON.parse( sessionStorage.currentProject );

	var self = this;

	// Project data
	self.projectname = currentProject.projectname;
	self.owner       = currentProject.owner;
	self.createddate = currentProject.createddate;
	self.description = currentProject.description

	// Array
	self.tasks      = ko.observableArray();
	self.comments   = ko.observableArray();

	self.addToArray = function( jsonObject, type )
	{
		for (var iItem = 0; iItem < jsonObject.length; iItem++)
		{
			if ( type === "tasks"    ) self.addTask(    jsonObject[iItem] );
			if ( type === "comments" ) self.addComment( jsonObject[iItem] );
		}
	}
	self.addTask = function( jsonObject )
	{
		// TODO: Validation
		self.tasks.push( jsonObject );
	}
	self.addComment = function( jsonObject )
	{
		// TODO: Validation
		self.comments.push( jsonObject );
	}
}

// End Knockout

// Comment actions
function submitComment()
{
	console.log("test");

	var comment   = $('#add-comment-area')[0].value;
	var username  = sessionStorage.username;
	var projectid = JSON.parse(sessionStorage.currentProject).projectid;

	var message = {projectid: projectid, username: username, comment: comment};

	var callback = function(data)
	{
		console.log(data);
	}

	console.log( "Adding comment:" + JSON.stringify(message) );
	$.post( "/api/add-project-comment", message, callback ) 
}
// End Comment actions

function handleProjectsTasks( data )
{
	var jsonObject = $.parseJSON( data );
	projectDetailsModel.addToArray( jsonObject, "tasks" );
	Holder.run();
}

function handleProjectsComments( data )
{
	console.log(data);
	var jsonObject = $.parseJSON( data );
	projectDetailsModel.addToArray( jsonObject, "comments" );
	Holder.run();
}

// Set up knockout and fetch data from database
var currentProject = JSON.parse( sessionStorage.currentProject );
if ( currentProject != null )
{
	console.log("Running modelview")
	var projectDetailsModel = new ProjectDetailsModel()
	ko.applyBindings( projectDetailsModel, $('#project-details')[0] );

	var projectid   = currentProject.projectid;
	var accesstoken = sessionStorage.token; // TODO: use implement this..! 
	$.post( "/api/get-project-tasks"   , { projectid: projectid }, handleProjectsTasks    );
	$.post( "/api/get-project-comments", { projectid: projectid }, handleProjectsComments );
}
else
{
	// TODO: Display error page or default or so
}

// Privileges for logged in users
// Note that a vaild token is required to post to api so it is ok to disable stuff in browser
if (sessionStorage.username == null) $('#add-comment-btn')[0].disabled = true;

</script>