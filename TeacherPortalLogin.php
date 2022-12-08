<?php
   include("config.php");
      session_start();
   $error = "";
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($db,$_POST['username']);
      $mypassword = mysqli_real_escape_string($db,$_POST['password']); 
      $query = $db->query("SELECT id FROM teacher WHERE email = '$myusername' and password = '$mypassword'");
        $count = 0;
        while($fetch = $query->fetch_array()){
        $count = $count + 1 ;
                $_SESSION['login_user'] = $fetch['id'];
                header("location: TeacherPortal.php");
            break;
        }
        if($count != 1) {
            $error = "Your Login Name or Password is invalid";
        }
      
      
   }
?>
<html>
   
   <head>
      <title>Login Page</title>
      <link rel="stylesheet" href="adminLogin.css">
      <style type = "text/css">
         body {
            font-family:Arial, Helvetica, sans-serif;
            font-size:14px;
         }
         label {
            font-weight:bold;
            width:100px;
            font-size:14px;
         }
         .box {
            border:#666666 solid 1px;
         }
      </style>
      
   </head>
   
   <body bgcolor = "#34495e" color = "#fff">
	
      <div align = "center">
         <div style = "width:300px; border: solid 1px #fff; " align = "left">
            <div style = "background-color:#333333; color:#FFFFFF; padding:3px;"><b>Login</b></div>
				
            <div style = "margin:30px">
               
               <form action = "" method = "post">
                  <div class="form-group" >
                     <label >Email Address</label>
                     <input type="text" name="username" class="form-control" />
                  </div>
                  <div class="form-group">
                     <label>Password</label>
                     <input type="password" name="password" class="form-control" />
                  </div>
                  <input type = "submit" value = " Submit "/><br />
               </form>
               <div style = "font-size:11px; color:#cc0000; margin-top:10px"><?php echo $error; ?></div>
               <p>Signup New Teacher <a href="TeacherPortalSignup.php">Click Here</a>.</p>
               <p>Back to Main Menu <a href="index.php">Click Here</a>.</p>
					
            </div>
				
         </div>
			
      </div>

   </body>
</html>
