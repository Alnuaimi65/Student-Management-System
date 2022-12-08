<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$name = $temail  = "";
$name_err = $temail_err = "";
$tID = -1;
 
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
                    $name_err = "This name is already taken.";
                } else{
                    $name = trim($_POST["name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    

    // Validate confirm temail
    if(empty(trim($_POST["temail"]))){
        $temail_err = "Please enter valid student email.";     
    } else{
        $temail = trim($_POST["temail"]);
    }
    // Check input errors before inserting in database
    if( empty($name_err) && empty($temail_err) ){
        
        $sql = "SELECT id FROM teacher WHERE email = '" . $temail . "'";
        
        $result = $db->query($sql);
        echo "<script type='text/javascript'>console.log('".$temail."');</script>";

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
           $tID = $row["id"];
           break; 
        }
        }

    if($tID != -1){
        $sql = "INSERT INTO course (name,teacher_id) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_name,$param_tID);
            
            // Set parameters
            $param_name = $name;
            $param_tID = $tID;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo "<script type='text/javascript'>alert('Account Created');</script>";
                header("location: CoursesDashboard.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }else{
        $temail_err = "Not Found";
    }
    
    // Close connection
    mysqli_close($db);
}
}
?>
 
<!DOCTYPE html>
<html lang="en">
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
<body>
    <div class="bodyDiv">
    <div class="wrapper">
        <h2>Create New Course</h2>
        <p>Please fill this form to create a course.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Teacher Email</label>
                <input type="text" name="temail" class="form-control <?php echo (!empty($temail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $temail; ?>">
                <span class="invalid-feedback"><?php echo $temail_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Back to Course Dashboard <a href="CoursesDashboard.php">Click Here</a>.</p>
        </form>
    </div>    
    </div>    
</body>
</html>