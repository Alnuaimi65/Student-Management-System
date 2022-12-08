<!DOCTYPE html>
<?php
    require_once "config.php";
?>
<html lang="en">
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
        <link rel="stylesheet" href="teacherList.css">
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
<body>
	<div class="container">
        <h1>Teachers List</h1>
		<br />
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>email</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = $db->query("SELECT * FROM `teacher` ORDER BY `id` ASC");
					$count = 1;
					while($fetch = $query->fetch_array()){
				?>
				<tr>
					<td><?php echo $count++?></td>
					<td><?php echo $fetch['name']?></td>
					<td><?php echo $fetch['email']?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
        <p>Back to Teachers Dashboard <a href="TeacherDashboard.php">Click Here</a>.</p>
	</div>

</body>
</html>