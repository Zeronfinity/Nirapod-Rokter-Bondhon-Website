<?php 
 session_start();
 include_once 'inc/dbconnect.php';
 $currentPage = basename(__FILE__);

 $errorType = "";
 $errorMsg = "";

 if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['hash']) && !empty($_GET['hash'])){
    // Verify data
    $email = mysqli_escape_string($conn, $_GET['email']); // Set email variable
    $hash = mysqli_escape_string($conn, $_GET['hash']); // Set hash variable
                 
    $sqql = "SELECT userEmail, activation FROM users WHERE userEmail='".$email."' AND activation='".$hash."'"; 
    $search = mysqli_query($conn, $sqql); 
     
    $match  = $search->num_rows;
                 
    if($match > 0){
        // We have a match, activate the account
        mysqli_query($conn, "UPDATE users SET activation='activated' WHERE userEmail='".$email."' AND activation='".$hash."'");
        
        $errorType = "success";
        $errorMsg = "Your account has been activated, you can now login";
    }else{
        // No match -> invalid url or account has already been activated.
        $errorType = "danger";
        $errorMsg = "The url is either invalid or you already have activated your account";
    }
  }else{
    // Invalid approach
    $errorType = "danger";
    $errorMsg = "Invalid approach, please use the link that has been sent to your email";
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>
    
    <title>Email Verification</title>

</head>    
<body>

   <div class="wrapper">
   
    <?php include 'inc/navbar.php' ?>

   <div class="push"></div>
    
    <div class="container">
         <div class="alert alert-<?php echo ($errorType=="success") ? "success" : $errorType; ?>">                                
            <span class="glyphicon glyphicon-info-sign"></span>
           <?php echo $errorMsg; ?>
         </div>
    </div>
    
                
    <div class="push"></div>
    </div>

    <footer class="container-fluid text-center">
        <p>All rights reserved</p>
    </footer>



</body>

</html>
