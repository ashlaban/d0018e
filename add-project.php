<form id="add-project">
	<fieldset>
		<legend>Add project</legend>
		<p>Project name:      <input type="text" id="projectName"     ></input></p>
		<p>Short description: <input type="text" id="shortDescription"></input></p>
		<p>Long description:  <input type="text" id="longDescription" ></input></p>
		<p><input type="submit"></input></p>
	</fieldset>
</form>

<script>
$("#add-project").submit( function(e)
{
	e.preventDefault();

	var name      = $( "input[id='projectName']"     ).val();
	var shortDesc = $( "input[id='shortDescription']").val();
	var longDesc  = $( "input[id='longDescription']" ).val();

	var postData = {};
	postData.username            = sessionStorage.username;
	postData.projectname         = name;
	postData.description         = shortDesc;
	postData.extendedDescription = longDesc;
	
	function handleAddProjectResponse ( data, status )
	{
		console.log( data );
	}
	console.log(postData);

	$.post( "/api/add-project", postData, handleAddProjectResponse );

});
</script>

<!--
	TODO: Layout - size of boxes
	TODO: Add preview on the right
	TODO: Add image
-->