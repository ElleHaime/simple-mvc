<h2>New task</h2>
<hr>

<form class="form-horizontal" action="/add" method="POST" id="newTask" name="newExercise" enctype="multipart/form-data">
	<div class="form-group" id="group-username">
		<label class="control-label col-sm-2" for="username">Your name <span style="color:red; padding-left:3px;">*</span> </label>
		<div class="col-sm-10">
			<input type="username" name="username" class="form-control" id="username" isRequired=1>
		</div>	
	</div>

	<div class="form-group"  id="group-email">
		<label class="control-label col-sm-2" for="email">Email address <span style="color:red; padding-left:3px;">*</span> </label>
		<div class="col-sm-10">
			<input type="email" name="email" class="form-control" id="email" isRequired=1>
		</div>	
	</div>

	<div class="form-group"  id="group-exercise">
		<label class="control-label col-sm-2" for="pwd">Your task <span style="color:red; padding-left:3px;">*</span> </label>
		<div class="col-sm-10">
			<textarea class="form-control" name="exercise" rows="5" id="exercise" isRequired=1></textarea>
		</div>
	</div>

	<div class="form-group"  id="group-image">
		<label class="control-label col-sm-2" for="image">Upload Image </label>
		<div class="col-sm-10">
			<input type="file" id="imageInput" name="image">
		</div>
		<img id="imageUploaded" />
	</div>

	<div class="form-group">
		<div class="col-sm-offset-2 col-sm-10">
			<button class="btn btn-info" id="preview">Preview</button>
			<button type="submit" class="btn btn-success">Save</button>
		</div>
	</div>		
</form>