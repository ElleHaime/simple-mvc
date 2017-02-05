<h2>Tasks</h2>
<hr>
<table class="table" id="tasksList">
    <thead>
		<tr>
			<th width="10%">User</th>
			<th width="10%">Email</th>
			<th width="65%">Task</th>
			<th width="15%">Status</th>
			</tr>
	</thead>

	<tbody>
	<?php
		foreach ($exercises as $key => $value) {
	?>
		<tr>
			<td>
				<p style="font-weight:bold;"><?= $value -> username; ?></p>
			</td>

			<td><a href='mailto:<?= $value -> email; ?>'><?= $value -> email; ?></a></td>

			<td><?= $value -> exercise; ?></td>
			<td>
				<?php 
					if (!empty($value -> status)) {
				?>
					<p style="color:green;">Done</p>
				<?php			
					} else {
				?>			
					<p style="color:grey;">Pending</p>
				<?php } ?>
			</td>
		</tr>
	<?php
		}
	?>
	</tbody>  
</table>
<p>
	<a class="btn btn-lg btn-primary" href="/add" role="button">add new task</a>
</p>

