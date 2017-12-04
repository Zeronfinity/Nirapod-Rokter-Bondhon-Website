<?php
 ob_start();
 session_start();
 require_once 'inc/dbconnect.php';
  
 $currentPage = basename(__FILE__);


 $error = false;
 $emailError = $passError = "";
 
 if( isset($_POST['btn-login']) ) { 
  
  // prevent sql injections/ clear user invalid inputs
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  // prevent sql injections / clear user invalid inputs
  
  if(empty($email)){
   $error = true;
   $emailError = "Please enter your email address.";
  } else if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  }
  
  if(empty($pass)){
   $error = true;
   $passError = "Please enter your password.";
  }
  
//  echo $error;
     
  // if there's no error, continue to login
  if (!$error) {
   $password = hash('sha256', $pass); // password hashing using SHA256
  
   $res=mysqli_query($conn, "SELECT userId, userName, userPass, activation, userType FROM users WHERE userEmail='$email'");
   $row=mysqli_fetch_array($res);
   $count = mysqli_num_rows($res); // if uname/pass correct it returns must be 1 row
   
  //  echo $row['activation'];  
      
   if( $count == 1 && $row['userPass']==$password && $row['activation']=="activated") {
    $_SESSION['user'] = $row['userId'];
    $_SESSION['type'] = $row['userType'];
    header("Location: index.php");
   } else {
    if ($row['activation']!="activated")
        $errMSG = "Your account is not activated yet, please check your email inbox or spam folder";
    else $errMSG = "Incorrect Credentials, try again...";
   }
    
  }
  
 }
?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
    <?php include 'inc/head.php' ?>
        <title>Sign In</title>   
    </head>

    <body>

        <div class="wrapper">

            <?php include 'inc/navbar.php' ?>

            <div class="container">

                <div id="login-form">
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

                        <div class="col-md-2"></div>
                        <div class="col-md-8">

                            <div class="form-group">
                                <h2 class="">Sign In</h2>
                            </div>

                            <div class="form-group">
                                <hr />
                            </div>

                            <?php
                               if ( isset($errMSG) ) {

                                ?>
                                <div class="form-group">
                                    <div class="alert alert-danger">
                                        <span class="glyphicon glyphicon-info-sign"></span>
                                        <?php echo $errMSG; ?>
                                    </div>
                                </div>
                                <?php
                                   }
                                   ?>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                            <input type="email" name="email" class="form-control" placeholder="Your Email" value="<?php 
                                            if (isset($email)) echo $email; ?>" maxlength="40" />
                                        </div>
                                        <span class="text-danger"><?php echo $emailError; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                            <input type="password" name="pass" class="form-control" placeholder="Your Password" maxlength="15" />
                                        </div>
                                        <span class="text-danger"><?php echo $passError; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <hr />
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-primary" name="btn-login">Sign In</button>
                                    </div>

                                    <div class="form-group">
                                        <hr />
                                    </div>

                                    <div class="form-group">
                                        <a href="register.php">Sign up here...</a>
                                    </div>

                                    <div class="form-group">
                                        <a href="passreset.php">Reset password here...</a>
                                    </div>

                        </div>
                        <div class="col-md-2"></div>

                    </form>
                </div>

            </div>



            <div class="push"></div>
        </div>

        <footer class="container-fluid text-center">
            <p>All rights reserved</p>
        </footer>



    </body>

    </html>
