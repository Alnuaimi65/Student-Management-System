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
                        echo "<script type='text/javascript'>console.log(".$param_username . ");</script>";
                
                        if ($result->num_rows > 0) {
                        // output data of each row
                        while($row = $result->fetch_assoc()) {

                           $cID = $row["id"];
                           break; 
                        }
                    }
                    $sql = "INSERT INTO enroll (course_id,student_id) VALUES (?, ?)";
         
                    if($stmt = mysqli_prepare($db, $sql)){
                        // Bind variables to the prepared statement as parameters
                        mysqli_stmt_bind_param($stmt, "ii",$param_cID,$param_sID);
                        
                        // Set parameters
                        $param_sID = $_SESSION['login_user'];
                        $param_cID = $cID;
                        
                        // Attempt to execute the prepared statement
                        if(mysqli_stmt_execute($stmt)){
                            // Redirect to login page
                            $sql = "INSERT INTO grade (course_id,student_id,score) VALUES (".$cID.",".$param_sID.",0)";
                            $result = $db->query($sql);
                            header("location: StudentPortal.php");
                        } else{
                            echo "Oops! Something went wrong. Please try again later.";
                        }
                    }
                        // Close statement
                        mysqli_stmt_close($stmt);
                } else{
                    $name_err = "This name ıs not found.";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
            // Close statement
            mysqli_stmt_close($stmt);
        }
    
    
    
    // Close connection
    mysqli_close($db);
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
        <br/><br/><br/><br/>
        <h1>Enroll New Course</h1>
        <p>Please fill this form to enroll a course.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Back to Student Portal <a href="StudentPortal.php">Click Here</a>.</p>
        </form>
	</div>
   
