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
        <h1>Parent List</h1>
		<br />
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Email</th>
					<th>Relationship</th>
					<th>Student Name</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = $db->query("SELECT * FROM `parent` ORDER BY `id` ASC");
					$count = 1;
					while($fetch = $query->fetch_array()){
                        $studentName = "";

				?>
				<tr>
					<td><?php echo $count++?></td>
					<td><?php echo $fetch['name']?></td>
					<td><?php echo $fetch['username']?></td>
					<td><?php echo $fetch['relationship']?></td>
                    <?php
                        $query1 = $db->query("SELECT * FROM `student` WHERE `id` = " . $fetch['student_id']);
                        while($fetch1 = $query1->fetch_array()){
                            $studentName = $fetch1['name'];          
                        }
                    ?>
					<td><?php echo $studentName?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
        <p>Back to Parent Dashboard <a href="ParentsDashboard.php">Click Here</a>.</p>
	</div>

</body>
</html>