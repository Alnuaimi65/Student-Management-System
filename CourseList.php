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
        <h1>Course List</h1>
		<br />
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Name</th>
					<th>Teacher Name</th>
					<th>Teacher Email</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = $db->query("SELECT * FROM `course` ORDER BY `id` ASC");
					$count = 1;
					while($fetch = $query->fetch_array()){
                        $teacherName = "";
                        $teacherEmail = "";

				?>
				<tr>
					<td><?php echo $count++?></td>
					<td><?php echo $fetch['name']?></td>
                    <?php
                        $query1 = $db->query("SELECT * FROM `teacher` WHERE `id` = " . $fetch['teacher_id']);
                        while($fetch1 = $query1->fetch_array()){
                            $teacherName = $fetch1['name']; 
                            $teacherEmail = $fetch1['email'];

                        }
                    ?>
					<td><?php echo $teacherName?></td>
					<td><?php echo $teacherEmail?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
        <p>Back to Course Dashboard <a href="CoursesDashboard.php">Click Here</a>.</p>
	</div>

</body>
</html>