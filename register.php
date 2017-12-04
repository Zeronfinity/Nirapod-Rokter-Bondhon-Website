<?php
 ob_start();
 session_start();
 include_once 'inc/dbconnect.php';

 $currentPage = basename(__FILE__);


 $error = false;

 $name = $email = $nameError = $emailError = $passError = "";

 if ( isset($_POST['btn-signup']) ) {
  
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
  
  $email = trim($_POST['email']);
  $email = strip_tags($email);
  $email = htmlspecialchars($email);
  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
  // basic name validation
  if (empty($name)) {
   $error = true;
   $nameError = "Please enter your full name.";
  } else if (strlen($name) < 3) {
   $error = true;
   $nameError = "Name must have atleat 3 characters.";
  } else if (!preg_match("/^[a-zA-Z ]+$/",$name)) {
   $error = true;
   $nameError = "Name must contain alphabets and space.";
  }
  
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

   if($result->num_rows > 0){
    $error = true;
    $emailError = "Provided Email is already in use.";
       
// implement resend verification here 
       
   }
  }
  // password validation
  if (empty($pass)){
   $error = true;
   $passError = "Please enter password.";
  } else if(strlen($pass) < 6) {
   $error = true;
   $passError = "Password must have atleast 6 characters.";
  }
  
  // password encrypt using SHA256();
  $password = hash('sha256', $pass);
  
  // if there's no error, continue to signup
  if( !$error ) {
   $member = "Member";
   $activation_hash = hash('sha256', rand(0, 1000)); 
      
    $to      = $email; // Send email to our user
    $subject = 'Signup | Verification'; // Give the email a subject 
    $body = '

    Thanks for signing up! <br/>
    Your account has been created, you can login with the following credentials after you have activated your account by pressing the url below.
    <br/><br/>
    ------------------------ <br/>
    Username: '.$name.' <br/>
    Password: '.$pass.' <br/>
    ------------------------ <br/><br/>

    Please click this link to activate your account:<br/>
    http://localhost/Project/verify.php?email='.$email.'&hash='.$activation_hash.'

    '; // Our message above including the link

   // echo "dammit\n".$to." ".$subject."\n$message\n";
    
    $mailError = false;
      
    include 'sendmail.php';
      
    if ($mailError == false)
    {
        $sql = "INSERT INTO users(userName,userEmail,userPass,userType,activation,reset) VALUES('$name','$email','$password','$member', '$activation_hash','None')";
        if ($conn->query($sql) === TRUE) {
        $errTyp = "success";
        $errMSG = "Your account has been made, please verify it by clicking the activation link that has been sent to your email. Check Spam of your email inbox if you can't find it";
        unset($name);
        unset($email);
        unset($pass);
       } else {
        $errTyp = "danger";
        $errMSG = "Something went wrong, try again later..."; 
       } 
    }
    else
    {
        $errTyp = "danger";
        $errMSG = "Mail could not be sent. Please try again later.";
    }
  }
  
  
 }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <?php include 'inc/head.php' ?>
        <title>Sign Up</title>
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
                                <h2 class="text-center">Enter your information below</h2>
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
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                                            <input type="text" name="name" class="form-control" placeholder="Enter Name" maxlength="50" value="<?php if(isset($name)){echo $name;} ?>" />
                                        </div>
                                        <span class="text-danger"><?php echo $nameError; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
                                            <input type="email" name="email" class="form-control" placeholder="Enter Your Email" maxlength="40" value="<?php if(isset($email)){echo $email;} ?>" />
                                        </div>
                                        <span class="text-danger"><?php echo $emailError; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                            <input type="password" name="pass" class="form-control" placeholder="Enter Password" maxlength="15" />
                                        </div>
                                        <span class="text-danger"><?php echo $passError; ?></span>
                                    </div>

                                    <div class="form-group">
                                        <hr />
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-primary" name="btn-signup">Sign Up</button>
                                    </div>

                                    <div class="form-group">
                                        <hr />
                                    </div>

                                    <div class="form-group">
                                        <a href="login.php">Sign in here...</a>
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
