<!DOCTYPE html>
<?php
    require_once "config.php";
   session_start();

?>
	<head>
		<link rel="stylesheet" type="text/css" href="css/bootstrap.css"/>
        <link rel="stylesheet" href="teacherList.css">
		<meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1"/>
	</head>
    
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="studentSignup.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = "";
$name_err =  "";
 $cID = -1;
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        // Prepare a select statement
        $sql = "SELECT id FROM course WHERE name = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["name"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){

                    if( empty($name_err) ){
        
                        $sql = "SELECT id FROM course WHERE name = '" . $param_username . "'";
                        
                        $result = $db->query($sql);
                
                        if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {

                           $cID = $row["id"];
                           break; 
                        }
                    }
                    $_SESSION['login_course'] = $cID;
                    header("location: TeacherPortalGrade.php");

                        // Close statement
                        mysqli_stmt_close($stmt);
                } else{
                    $name_err = "This name ıs not found.";
                }
            } else{
                $name_err = "This name ıs not found.";
            }

        }
            // Close statement
        }
    
    
    
    // Close connection
}

?>
	<div class="container">
        <br/><br/><br/><br/>
        <h1>Course List</h1>
		<br />
		<table class="table">
			<thead>
				<tr>
					<th>#</th>
					<th>Course Name</th>
					<th>Teacher Name</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = $db->query("SELECT c.name as name,t.name as tname FROM course c INNER JOIN teacher t on t.id = c.teacher_id WHERE t.id =".$_SESSION['login_user']);
					$count = 1;
					while($fetch = $query->fetch_array()){
                        $teacherName = "";
                        $teacherEmail = "";

				?>
				<tr>
					<td><?php echo $count++?></td>
					<td><?php echo $fetch['name']?></td>
					<td><?php echo $fetch['tname']?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
        <br/><br/><br/><br/>
        <h1>Grade A Course</h1>
        <p>Please fill this form to grade a course.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
        <p>Back to Main Menu <a href="logout.php">Click Here</a>.</p>

	</div>
