<?php
   include("config.php");
   session_start();
?>
<link rel="stylesheet" href="studentPortal.css"> 
<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
        <link rel="stylesheet" href="teacherList.css">
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>

<body>
	<div class="container">
        <h1>Student Grades</h1>
		<br />
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Student Name</th>
					<th>Course Name</th>
					<th>Score</th>
				</tr>
			</thead>
			<tbody>
				<?php


					$query = $db->query("Select s.name as sname , c.name as cname, g.score as score FROM parent p INNER JOIN student s on p.student_id = s.id INNER JOIN enroll e on e.student_id = s.id INNER JOIN grade g on e.student_id = g.student_id  AND e.course_id = g.course_id INNER JOIN course c on c.id = e.course_id WHERE p.id = ".$_SESSION['login_user']);
					$count = 1;
					while($fetch = $query->fetch_array()){
                        $studentName = "";

				?>
				<tr>
					<td><?php echo $count++?></td>
					<td><?php echo $fetch['sname']?></td>
					<td><?php echo $fetch['cname']?></td>
					<td><?php echo $fetch['score']?></td>
					<td><?php echo $studentName?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
	</div>

</body>

<div id="navigation">
   <nav>
      <a href="logout.php">Sign Out</a>
      <div class="animation start-home"></div>
   </nav>
</div>