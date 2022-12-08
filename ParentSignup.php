<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = $name = $semail = $relation = "";
$email_err = $password_err = $name_err = $semail_err = $relation_err = "";
$sID = -1;
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        // Prepare a select statement
        $sql = "SELECT id FROM parent WHERE username = ?";
        
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["email"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm name
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter valid name.";     
    } else{
        $name = trim($_POST["name"]);
    }
    // Validate confirm relation
    if(empty(trim($_POST["relation"]))){
        $relation_err = "Please enter valid relation.";     
    } else{
        $relation = trim($_POST["relation"]);
    }
    
    // Validate confirm semail
    if(empty(trim($_POST["semail"]))){
        $semail_err = "Please enter valid student email.";     
    } else{
        $semail = trim($_POST["semail"]);
    }
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($name_err) && empty($semail_err) && empty($relation_err)){
        
        $sql = "SELECT id FROM student WHERE email = '" . $semail . "'";
        
        $result = $db->query($sql);
        echo "<script type='text/javascript'>console.log('".$semail."');</script>";

        if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
           $sID = $row["id"];
           break; 
        }
        }

        $sql = "INSERT INTO parent (name,student_id,username,relationship,password) VALUES (?, ?, ?,?,?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisss", $param_name,$param_sid,$param_email, $param_relation, $param_password);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_password = $password;
            $param_sid = $sID;
            $param_relation = $relation;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                echo "<script type='text/javascript'>alert('Account Created');</script>";
                header("location: ParentsDashboard.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
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
        <h2>Sign Up New Parent</h2>
        <p>Please fill this form to create a parent account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                <span class="invalid-feedback"><?php echo $name_err; ?></span>
            </div>
            <div class="form-group">
                <label>Relationship</label>
                <input type="text" name="relation" class="form-control <?php echo (!empty($relation_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $relation; ?>">
                <span class="invalid-feedback"><?php echo $relation_err; ?></span>
            </div>
            <div class="form-group">
                <label>Student Email</label>
                <input type="text" name="semail" class="form-control <?php echo (!empty($semail_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $semail; ?>">
                <span class="invalid-feedback"><?php echo $semail_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Back to Parent Dashboard <a href="ParentsDashboard.php">Click Here</a>.</p>
        </form>
    </div>    
    </div>    
</body>
</html>