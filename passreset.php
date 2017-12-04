<?php
 ob_start();
 session_start();
 include_once 'inc/dbconnect.php';

 $currentPage = basename(__FILE__);


 $error = false;

 $name = $email = $nameError = $emailError = $passError = "";

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  } else {

      // check email exist or not 
      
  $sql = "SELECT users.userEmail FROM users WHERE userEmail='$email'";
 
    $result = mysqli_query($conn, $sql);

    if($result == false) 
    { 
       user_error("Query failed: <br />\n"); 
       return false; 
    } 

   if($result->num_rows == 0){
    $error = true;
    $emailError = "Provided Email does not exist.";
       
// implement resend verification here 
       
   }
  }

  if( !$error ) {
   $reset_hash = hash('sha256', rand(0, 1000)); 
      
    $to      = $email; // Send email to our user
    $subject = 'Password Reset'; // Give the email a subject 
    $body = '
    <br/><br/>
    A request to change your password has been received. If you did not make the request, ignore it.
    <br/><br/>
    Please click this link to reset your password:
    http://localhost/Project/reset.php?email='.$email.'&hash='.$reset_hash.'

    '; // Our message above including the link

    include 'sendmail.php';
      
    echo $to." ".$subject." ".$message." ".$headers."\n";
      
    $sql = "UPDATE users SET reset = '$reset_hash' WHERE userEmail = '$email'";
    if ($conn->query($sql) === TRUE) {
    $errTyp = "success";
    $errMSG = "A mail has been sent to you for resetting password. Follow the instructions there to continue.";
    unset($name);
    unset($email);
    unset($pass);
   } else {
    $errTyp = "danger";
    $errMSG = "Something went wrong, try again later..."; 
   } 
    
  }
  
  
 }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
    <?php include 'inc/head.php' ?>
        <title>Reset Password</title>
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
                                <h2 class="text-center">Enter your information below to reset password</h2>
                            </div>

                            <div class="form-group">
                                <hr />
                            </div>

                            <?php
                               if ( isset($errMSG) ) {

                                ?>
                                <div class="form-group">
                                    <div class="alert alert-<?php echo ($errTyp==" success ") ? "success " : $errTyp; ?>">
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
                                            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php if(isset($email)){echo $email;} ?>" />
                                        </div>
                                        <span class="text-danger"><?php echo $emailError; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <hr />
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Reset</button>
                                    </div>

                                    <div class="form-group">
                                        <hr />
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

    <?php ob_end_flush(); ?>
