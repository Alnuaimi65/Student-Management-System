<?php
// Include config file
require_once "config.php";
 
// Define variables and initialize with empty values
$email = $password = $name = $address = $mobile = $city = $state = $code = "";
$email_err = $password_err = $name_err = $mobile_err = $city_err = $state_err = $code_err =  "";
$cID = $sID = $dID = -1;
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
        // Prepare a select statement
        $sql = "SELECT id FROM student WHERE email = ?";
        
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
    
        $query = $db->query("SELECT id FROM `cities` WHERE `name` = '" . trim($_POST["city"]) . "'");
        while($fetch = $query->fetch_array()){
            $cID = $fetch['id'];   
        }
        if($cID==-1){
            $city_err = "City Not Found.";
        }else{
            $city = trim($_POST["city"]);
        }

        $query = $db->query("SELECT id FROM `state` WHERE `name` = '" . trim($_POST["state"]) . "'");
        while($fetch = $query->fetch_array()){
            $sID = $fetch['id'];   
        }
        if($sID==-1){
            $state_err = "City Not Found.";
        }else{
            $state = trim($_POST["state"]);
        }

        $query = $db->query("SELECT id FROM `degree` WHERE `code` = '" . trim($_POST["code"]) . "'");
        while($fetch = $query->fetch_array()){
            $dID = $fetch['id'];   
        }
        if($dID==-1){
            $code_err = "City Not Found.";
        }else{
            $code = trim($_POST["code"]);
        }


    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["name"]))){
        $name_err = "Please enter valid name.";     
    } else{
        $name = trim($_POST["name"]);
    }
    if(empty(trim($_POST["address"]))){
        $address_err = "Please enter valid address.";     
    } else{
        $address = trim($_POST["address"]);
    }
    
    if(empty(trim($_POST["mobile"]))){
        $mobile_err = "Please enter valid mobile.";     
    } elseif(strlen(trim($_POST["mobile"])) != 11){
        $mobile_err = "Password must have 11 characters.";
    } else{
        $mobile = trim($_POST["mobile"]);
    }
    
    // Check input errors before inserting in database
    if(empty($email_err) && empty($password_err) && empty($name_err) && empty($mobile_err) && empty($address_err) && empty($city_err) && empty($state_err) && empty($code_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO student (name,email, password,mobile,
        city_id,
        state_id,
        address,
        degree_id) VALUES (?, ?, ?,?,?, ?,?,?)";
         
        if($stmt = mysqli_prepare($db, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssiiisi", $param_name, $param_email, $param_password,$param_mobile,$param_cID,$param_sID,$param_address,$param_dID);
            
            // Set parameters
            $param_name = $name;
            $param_email = $email;
            $param_password = $password;
            $param_mobile = $mobile;
            $param_cID = $cID;
            $param_sID = $sID;
            $param_address = $address;
            $param_dID = $dID;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: StudentsDashboard.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Close connection
    mysqli_close($db);
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
        <h2>Sign Up New Student</h2>
        <p>Please fill this form to create a student account.</p>
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
                <label>Mobile</label>
                <input type="text" name="mobile" class="form-control <?php echo (!empty($mobile_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $mobile; ?>">
                <span class="invalid-feedback"><?php echo $mobile_err; ?></span>
            </div>
            <div class="form-group">
                <label>Address</label>
                <input type="text" name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $address; ?>">
                <span class="invalid-feedback"><?php echo $address_err; ?></span>
            </div>
            <div class="form-group">
                <label>City Name</label>
                <input type="text" name="city" class="form-control <?php echo (!empty($city_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $city; ?>">
                <span class="invalid-feedback"><?php echo $city_err; ?></span>
            </div>
            <div class="form-group">
                <label>State Name</label>
                <input type="text" name="state" class="form-control <?php echo (!empty($state_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $state; ?>">
                <span class="invalid-feedback"><?php echo $state_err; ?></span>
            </div>
            <div class="form-group">
                <label>Degree Code</label>
                <input type="text" name="code" class="form-control <?php echo (!empty($code_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $code; ?>">
                <span class="invalid-feedback"><?php echo $code_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
            </div>
            <p>Back to Student Dashboard <a href="StudentsDashboard.php">Click Here</a>.</p>
        </form>
    </div>    
    </div>    
</body>
</html>