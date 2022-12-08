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
        <h1>Students List</h1>
		<br />
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Mobile</th>
					<th>Address</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = $db->query("SELECT * FROM `student` ORDER BY `id` ASC");
					$count = 1;
					while($fetch = $query->fetch_array()){
				?>
				<tr>
					<td><?php echo $count++?></td>
					<td><?php echo $fetch['name']?></td>
					<td><?php echo $fetch['email']?></td>
					<td><?php echo $fetch['mobile']?></td>
					<td><?php echo $fetch['address']?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
        <p>Back to Student Dashboard <a href="StudentsDashboard.php">Click Here</a>.</p>
	</div>

</body>
</html>