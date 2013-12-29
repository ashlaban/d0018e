<!-- WARNING: Must be included in an environment including knockout-3.0.0 -->

<!-- TODO: Change the width of this component! -->

<div id="project-view">
	<!-- ko foreach: projects -->
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title" data-bind="text: projectname">Project Name</h3>
		</div>
		<div class="panel-body">
				<img class="center-block lazy" data-src="holder.js/300x200" width="300" height="200">
				<dl class="dl-horizontal">
					<dt>Author</dt>
					<dd data-bind="text: owner">Placeholder for owner</dd>
					<dt>Creation Date</dt>
					<dd data-bind="text: createddate">Date placeholder</dd>
					<dt>Description</dt>
					<dd data-bind="text: description">Description placeholder</dd>
				</dl>
		</div>
		<div class="panel-footer">
			<button type="button" class="btn btn-default" data-bind="click: viewDetailsCallback">View Details</button>
			<button type="button" class="btn btn-default">Apply</button>
		</div>
	</div>
	<!-- /ko -->
</div>

<script>

// Knockout - databindings for updating project panels
function ProjectViewModel()
{
	var self = this;
	self.projects = ko.observableArray();

	self.addProjectArray = function( jsonObject )
	{
		for (var iProject = 0; iProject < jsonObject.length; iProject++)
		{
			// TODO: Add some validation on the jsonObject
			self.projects.push( jsonObject[iProject] );
		}
	}
}

var projectViewModel = new ProjectViewModel()
ko.applyBindings( projectViewModel, $('#knockout-projects')[0] );

// End Knockout

function handleRecentProjects( data )
{
	var jsonObject = $.parseJSON( data );
	projectViewModel.addProjectArray( jsonObject );
	Holder.run();
}

$.post( "/api/get-project", { nProjects: 4 }, handleRecentProjects );

//$('.ipsum').lorem({ type: 'paragraphs', amount:'2', ptags:true });

/* Loads the detailed view when button clicked */
function viewDetailsCallback( project )
{
	sessionStorage.currentProject = JSON.stringify( project );
	window.location.href = "/?page=project-details";
}

</script>