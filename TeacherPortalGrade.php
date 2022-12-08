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
$name = $grade =  "";
$name_err = $grade_err =  "";
 $cID = -1;
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        // Prepare a select statement
        $sql = "SELECT * FROM student WHERE id = ?";
            // Validate password
            if(empty(trim($_POST["grade"]))){
                $grade_err = "Please enter valid score.";     
            } elseif($_POST["grade"] < 0){
                $grade_err = "Please enter valid score.";     
            } elseif($_POST["grade"] > 100){
                $grade_err = "Please enter valid score.";     
            } else{
                $grade = trim($_POST["grade"]);
            }
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

                    if( empty($name_err) && empty($grade_err)){
        
                        $sql = "UPDATE grade SET score = ".$grade." WHERE course_id	= ".$_SESSION['login_course']." and student_id = '" . $param_username . "'";
                        
                        $result = $db->query($sql);
                        echo "<script type='text/javascript'>console.log(".$param_username . ");</script>";
                
                        header("location: TeacherPortal.php");
                        // Close statement
                        mysqli_stmt_close($stmt);
                    }else{
                        $name_err = "This name ıs not found.";
                    }

                } else{
                    $name_err = "This name ıs not found.";
                }
            } else{
                    $name_err = "This name ıs not found.";
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
            // Close statement
                
    
    // Close connection
        }
    


?>
	<div class="container">
        <br/><br/><br/><br/>
        <h1>Student List</h1>
		<br />
		<table class="table">
			<thead>
				<tr>
					<th>Roll#</th>
					<th>Student Name</th>
					<th>Student Email</th>
				</tr>
			</thead>
			<tbody>
				<?php
                    echo "<script type='text/javascript'>console.log(".$_SESSION["login_course"] . ");</script>";

					$query = $db->query("SELECT s.id as sID, s.name as sname, s.email as semail FROM student s INNER JOIN enroll e ON e.student_id = s.id where e.course_id =".$_SESSION['login_course']);
					$count = 1;
					while($fetch = $query->fetch_array()){
				?>
				<tr>
					<td><?php echo $fetch['sID']?></td>
					<td><?php echo $fetch['sname']?></td>
					<td><?php echo $fetch['semail']?></td>
				</tr>
				<?php
					}
				?>
			</tbody>
		</table>
        <br/><br/><br/><br/>
        <h1>Grade A Student</h1>
        <p>Please fill this form to grade a student.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Roll#</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Grade</label>
                <input type="text" name="grade" class="form-control <?php echo (!empty($grade_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $grade; ?>">
                <span class="invalid-feedback"><?php echo $grade_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
        </form>
        <p>Back to Main Menu <a href="logout.php">Click Here</a>.</p>

	</div>
