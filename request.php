<?php 
 session_start();
 include_once 'inc/dbconnect.php';


 $currentPage = basename(__FILE__);
 
 $error = false;

 if (isset($_POST["btn-submit"]))
 {
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
     
  $take = trim($_POST['blood']);
  $take = strip_tags($take);
  $blood = htmlspecialchars($take);

  if (empty($blood)) {
   $error = true;
   $bloodError = "Blood group is mandatory";
  }

  
  $take = trim($_POST['contact']);
  $take = strip_tags($take);
  $contact = htmlspecialchars($take);

  if (empty($contact)) {
   $error = true;
   $contactError = "Contact number is mandatory";
  }

  $take = trim($_POST['address']);
  $take = strip_tags($take);
  $address = htmlspecialchars($take);
  
  if (empty($address)) {
   $error = true;
   $locationError = "Location where blood is needed is mandatory";
  }

  $take = trim($_POST['adinfo']);
  $take = strip_tags($take);
  $adinfo = htmlspecialchars($take);
  
     
  if ($error == false)
  {
         $sql = "INSERT INTO requests (name, blood_group, contact_no, location, adinfo) VALUES ('$name', '$blood', '$contact', '$address', '$adinfo')";       
         $result = mysqli_query($conn, $sql);
         $success = true;

         $sql = "SELECT * FROM users WHERE userType != 'Member'";       
         $result = mysqli_query($conn, $sql);
      
        while($row = mysqli_fetch_assoc($result))
        {
            $to      = $row['userEmail']; // Send email to our user
            $subject = 'Blood Request'; // Give the email a subject 
            $body = '
            Someone requested for blood.
            <br/><br/>
            ------------------------
            Name: '.$name.' <br/>
            Blood Group: '.$blood.' <br/>
            Contact Number: '.$contact.' <br/>
            Location: '.$address.' <br/>
            Additional Information: '.$adinfo.' <br/>
            ------------------------
            <br/><br/>
            Please try to help as soon as possible. You can log into the website to search in our database for this blood group.
            '; // Our message above including the link

            include 'sendmail.php';
        }
    }
 }
   

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>
    <title>Request For Blood</title>
</head>

<body>

   <div class="wrapper">
   
    <?php include 'inc/navbar.php' ?>

            <div class="container">

                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">

                        <div class="form-group">
                            <h2 class="text-center">Request for blood group below</h2>
                            <br/>
                        </div>
                        
                        <?php if (isset($success)) { ?>
                        <div class="alert alert-success">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo "Your information has been saved and sent to our volunteers. They will contact you as soon as they can help you."; ?>
                        </div>
                        <?php } ?>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text"  <?php if (isset($_POST["name"]) and $_POST["name"] != "") { $nm = $_POST["name"]; echo "value=\"$nm\"";} else echo "placeholder=\"Enter your name here\""; ?> class="form-control" name="name">
                        </div>

                          <div class="form-group">
                            <label for="blood">Blood Group:</label>
                              <select class="form-control" name="blood">
                                <option value="A+" <?php if (isset($_POST["blood"]) and $_POST["blood"] == "A+") echo "selected"; ?> >A+</option>
                                <option value="A-" <?php if (isset($_POST["blood"]) and $_POST["blood"] == "A-") echo "selected"; ?> >A-</option>
                                <option value="B+" <?php if (isset($_POST["blood"]) and $_POST["blood"] == "B+") echo "selected"; ?> >B+</option>
                                <option value="B-" <?php if (isset($_POST["blood"]) and $_POST["blood"] == "B-") echo "selected"; ?> >B-</option>
                                <option value="AB+" <?php if (isset($_POST["blood"]) and $_POST["blood"] == "AB+") echo "selected"; ?> >AB+</option>
                                <option value="AB-" <?php if (isset($_POST["blood"]) and $_POST["blood"] == "AB-") echo "selected"; ?> >AB-</option>
                                <option value="O+" <?php if (isset($_POST["blood"]) and $_POST["blood"] == "O+") echo "selected"; ?> >O+</option>
                                <option value="O-" <?php if (isset($_POST["blood"]) and $_POST["blood"] == "O-") echo "selected"; ?> >O-</option>
                              </select>         
                          </div>        
                        
                        <?php if (isset($bloodError)) { ?>
                        <div class="alert alert-danger">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo $bloodError; ?>
                        </div>
                        <?php } ?>
                       
                             
                        <div class="form-group">
                            <label for="contact">Contact No:</label>
                            <input type="text" class="form-control" name="contact" <?php if (isset($_POST["contact"]) && isset($contactError) == false) { $nm = $_POST["contact"]; echo "value=\"$nm\"";} else echo "placeholder=\"Enter your contact number here, this field is mandatory\""; ?> >
                        </div>
                        <?php if (isset($contactError)) { ?>
                        <div class="alert alert-danger">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo $contactError; ?>
                        </div>
                        <?php } ?>
                                                        
                        <div class="form-group">
                            <label for="address">Location:</label>
                            <textarea class="form-control" rows="3" name="address" placeholder="Where blood is needed, this field is mandatory"><?php if (isset($_POST["address"]) == true && isset($locationError) == false) { $nm = $_POST["address"]; echo $nm;} ?></textarea>
                        </div>
                        <?php if (isset($locationError)) { ?>
                        <div class="alert alert-danger">
                            <span class="glyphicon glyphicon-info-sign"></span>
                            <?php echo $locationError; ?>
                        </div>
                        <?php } ?>
                        

                        <div class="form-group">
                            <label for="adinfo">Additional info:</label>
                            <textarea class="form-control" rows="3" name="adinfo" placeholder="Put additional information here"><?php if (isset($_POST["adinfo"]) && $_POST["adinfo"] != "") { $nm = $_POST["adinfo"]; echo $nm;}?></textarea>
                        </div>

                        <div class="form-group">
                            <hr/>
                        </div>
                        

                        <button type="submit" class="btn btn-primary" name="btn-submit">Submit</button>

                        <p><br/></p>
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
