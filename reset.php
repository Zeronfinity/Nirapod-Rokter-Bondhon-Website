<?php 
 session_start();
 include_once 'inc/dbconnect.php';
 $currentPage = basename(__FILE__);

 $errorType = "";
 $errorMsg = "";

 if ( isset($_POST['btn-reset']) ) {
  
  // clean user inputs to prevent sql injections  
  $pass = trim($_POST['pass']);
  $pass = strip_tags($pass);
  $pass = htmlspecialchars($pass);
  
   $email = $_SESSION['email'];
    
   $error = false;     
     
  //basic email validation
  if ( !filter_var($email,FILTER_VALIDATE_EMAIL) ) {
   $error = true;
   $emailError = "Please enter valid email address.";
  } else {
       
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
      $temp2 = $_SESSION['hash'];
    $sql = "UPDATE users SET reset = 'None' AND userPass = '$password' WHERE users.userEmail = '$email' AND users.reset = '$temp2'";
      
    echo $sql;
      
    if ($conn->query($sql) === TRUE) {
    $errorType = "success";
    $errorMsg = "Your password has been reset";
    unset($name);
    unset($email);
    unset($pass);
    session_destroy();
   } else {
    $errorType = "danger";
    $errorMsg = "Something went wrong, try again later..."; 
   } 
    
  }
  
  
 }
else 
{
    if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash']) && $_GET['hash'] != 'None'){
    // Verify data
    $email = mysqli_escape_string($conn, $_GET['email']); // Set email variable
    $hash = mysqli_escape_string($conn, $_GET['hash']); // Set hash variable
        
    $_SESSION['email'] = $email; 
    $_SESSION['hash'] = $hash; 
     
    $sqql = "SELECT userEmail, reset FROM users WHERE userEmail='".$email."' AND reset='".$hash."'"; 
    $search = mysqli_query($conn, $sqql); 
     
    $match  = $search->num_rows;
                 
    if($match > 0){
    }else{
        // No match -> invalid url or account has already been activated.
        $errorType = "danger";
        $errorMsg = "The url is either invalid or you already have reset your password";
    }
  }else{
    // Invalid approach
    $errorType = "danger";
    $errorMsg = "Invalid approach, please use the link that has been sent to your email";
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>
    
    <title>Password Reset</title>
<body>

   <div class="wrapper">
   
    <?php include 'inc/navbar.php' ?>

    <?php if ($errorType != "") { ?>
    <div class="container">
        <div class="col-md-2"></div>
        <div class="col-md-8">
         <div class="alert alert-<?php echo ($errorType=="success") ? "success" : $errorType; ?>">                                
            <span class="glyphicon glyphicon-info-sign"></span>
           <?php echo $errorMsg; ?>
         </div>
        </div>
        <div class="col-md-2"></div>
    </div>
    <?php } ?>
    
      <div class="container">   
      
       <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

                        <div class="col-md-2"></div>
                        <div class="col-md-8">

                            <div class="form-group">
                                <h2 class="">Password Reset</h2>
                            </div>

                            <div class="form-group">
                                <hr />
                            </div>

                                   
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                                            <input type="password" name="pass" class="form-control" placeholder="Enter New Password" maxlength="15" />
                                        </div>
                                        <?php if (isset($passError) == true) { ?>
                                        <span class="text-danger"><?php echo $passError; ?></span> <?php } ?>
                                    </div>

                                    <div class="form-group">
                                        <hr />
                                    </div>

                                    <div class="form-group">
                                        <button type="submit" class="btn btn-block btn-primary" name="btn-reset">Reset</button>
                                    </div>

           </div>
           <div class="col-md-2"></div>
       </form>
       </div>
       
    <div class="push"></div>
    </div>

    <footer class="container-fluid text-center">
        <p>All rights reserved</p>
    </footer>



</body>

</html>


