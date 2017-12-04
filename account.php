<?php 
 session_start();
 include_once 'inc/dbconnect.php';
 $currentPage = basename(__FILE__);
 
 if ($_SESSION['user']=="")
 {
     header("Location: login.php");
 }

 $user_id = $_SESSION['user'];
 $nameError = "";
 $pass = "";

 $error = false;

 if (isset($_POST['btn-update']))
 {
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);

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

     
  $take = trim($_POST['blood']);
  $take = strip_tags($take);
  $blood = htmlspecialchars($take);
  
  $take = trim($_POST['roll']);
  $take = strip_tags($take);
  $roll = htmlspecialchars($take);
    
  $take = trim($_POST['gender']);
  $take = strip_tags($take);
  $gender = htmlspecialchars($take);

  $take = trim($_POST['dept']);
  $take = strip_tags($take);
  $dept = htmlspecialchars($take);
  
  $take = trim($_POST['age']);
  $take = strip_tags($take);
  $age = htmlspecialchars($take);
  
  $take = trim($_POST['weight']);
  $take = strip_tags($take);
  $weight = htmlspecialchars($take);
  
  $take = trim($_POST['contact']);
  $take = strip_tags($take);
  $contact = htmlspecialchars($take);
    
  $take = trim($_POST['fb']);
  $take = strip_tags($take); 
  $fb = htmlspecialchars($take);
  
  $take = trim($_POST['address']);
  $take = strip_tags($take);
  $address = htmlspecialchars($take);
  
  $take = trim($_POST['pass']);
  $take = strip_tags($take);
  $pass = htmlspecialchars($take);
  
  $take = trim($_POST['city']);
  $take = strip_tags($take);
  $city = htmlspecialchars($take);
  
  $take = trim($_POST['last_donated']);
  $take = strip_tags($take);
  $cdate = $ldate = htmlspecialchars($take);
     
  if ($error == false)
  {
      $sql = "SELECT * FROM bloodlist, users WHERE bloodlist.email_id = users.userEmail AND users.userID = $user_id";
      $result = mysqli_query($conn, $sql);
      $count = mysqli_num_rows($result);

      $sql = "SELECT * FROM users WHERE users.userID = $user_id"; 
      $result = mysqli_query($conn, $sql);
      $res = mysqli_fetch_assoc($result);
      $logMail = $res['userEmail'];

      if ($count > 0)
      {
         $sql = "UPDATE bloodlist SET name='$name', blood_group='$blood', roll='$roll', gender='$gender', dept='$dept', age='$age', weight='$weight', contact_no='$contact', facebook_id='$fb', present_address='$address', city='$city', last_donated='$cdate' WHERE bloodlist.email_id = '$logMail'"; 
         $result = mysqli_query($conn, $sql);
      }
      else
      {
         $sql = "INSERT INTO bloodlist (name, blood_group, roll, gender, dept, age, weight, contact_no, email_id, facebook_id, present_address, city, last_donated) VALUES ('$name', '$blood', '$roll', '$gender', '$dept', '$age', '$weight', '$contact', '$logMail', '$fb', '$address', '$city', '$cdate')";       
         $result = mysqli_query($conn, $sql);
      }
  }
 }

if ($error == false)
{
  if ($pass != "")
  {
     $password = hash('SHA256', $pass);
     $sql = "UPDATE users SET users.userPass='$password' WHERE userEmail='$logMail'"; 
     $result = mysqli_query($conn, $sql);      
  }
}

 $sql = "SELECT * FROM bloodlist, users WHERE bloodlist.email_id = users.userEmail AND users.userID = '$user_id'";
 $result = mysqli_query($conn, $sql);
 $row = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>

    <title>User Account</title>
</head>

<body>

     <div class="wrapper">

     <?php include 'inc/navbar.php' ?>


     <div class="container">

          <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
             <div class="col-md-2"></div>
                 <div class="col-md-8">

                        <div class="form-group">
                            <h2 class="text-center">View or update your information below</h2>
                        </div>

                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" name="name" value="<?php if (isset($row["name"])) {echo $row["name"];} else {echo "";} ?> ">
                        <?php if (isset($nameError)) ?>
                        <span class="text-danger"><?php echo $nameError; ?></span>
                        </div>

                          <div class="form-group">
                            <label for="blood">Blood Group:</label>
                              <select class="form-control" name="blood">
                                <option value="A+" <?php if (isset($row["blood_group"]) == true && $row["blood_group"] == "A+") echo "selected"; ?> >A+</option>
                                <option value="A-" <?php if (isset($row["blood_group"]) == true && $row["blood_group"] == "A-") echo "selected"; ?> >A-</option>
                                <option value="B+" <?php if (isset($row["blood_group"]) == true && $row["blood_group"] == "B+") echo "selected"; ?> >B+</option>
                                <option value="B-" <?php if (isset($row["blood_group"]) == true && $row["blood_group"] == "B-") echo "selected"; ?> >B-</option>
                                <option value="AB+" <?php if (isset($row["blood_group"]) == true && $row["blood_group"] == "AB+") echo "selected"; ?> >AB+</option>
                                <option value="AB-" <?php if (isset($row["blood_group"]) == true && $row["blood_group"] == "AB-") echo "selected"; ?> >AB-</option>
                                <option value="O+" <?php if (isset($row["blood_group"]) == true && $row["blood_group"] == "O+") echo "selected"; ?> >O+</option>
                                <option value="O-" <?php if (isset($row["blood_group"]) == true && $row["blood_group"] == "O-") echo "selected"; ?> >O-</option>
                              </select>         
                          </div>        

                          <div class="form-group">
                            <label for="gender">Gender:</label>
                              <select class="form-control" name="gender">
                                <option value="Male" <?php if ($row["gender"] == "Male") echo "selected"; ?> >Male</option>
                                <option value="Female" <?php if ($row["gender"] == "Female") echo "selected"; ?> >Female</option>
                                <option value="Other" <?php if ($row["gender"] == "Other") echo "selected"; ?> >Other</option>
                              </select>         
                          </div>        
                       
                       
                        <div class="form-group">
                            <label for="roll">Roll:</label>
                            <input type="text" class="form-control" name="roll" value="<?php if (isset($row[ "roll"])) {echo $row[ "roll"];} else {echo "";} ?> ">
                        </div>

                        <div class="form-group">
                            <label for="dept">Department:</label>
                            <input type="text" class="form-control" name="dept" value="<?php if (isset($row[ "dept"])) {echo $row[ "dept"];} else {echo "";} ?> ">
                        </div>

                        <div class="form-group">
                            <label for="age">Age:</label>
                            <input type="text" class="form-control" name="age" value="<?php if (isset($row[ "age"])) {echo $row[ "age"];} else {echo "";} ?> ">
                        </div>

                        <div class="form-group">
                            <label for="weight">Weight (kg):</label>
                            <input type="text" class="form-control" name="weight" value="<?php if (isset($row[ "weight"])) {echo $row[ "weight"];} else {echo "";} ?> ">
                        </div>

                        <div class="form-group">
                            <label for="contact">Contact No:</label>
                            <input type="text" class="form-control" name="contact" value="<?php if (isset($row[ "contact_no"])) {echo $row[ "contact_no"];} else {echo "";} ?> ">
                        </div>

                        <div class="form-group">
                            <label for="fb">Facebook ID:</label>
                            <input type="text" class="form-control" name="fb" value="<?php if (isset($row[ "facebook_id"])) {echo $row[ "facebook_id"];} else {echo "";} ?> ">
                        </div>

                        <div class="form-group">
                            <label for="address">Present Address:</label>
                            <textarea class="form-control" rows="3" name="address" value="<?php if (isset($row[ "present_address"])) {echo $row[ "present_address"];} else {echo "";} ?> "></textarea>
                        </div>

                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" class="form-control" name="city" value="<?php if (isset($row[ "city"])) {echo $row[ "city"];} else {echo "";} ?> ">
                        </div>
                        
                        <div class="form-group">
                            <label for="last_donated">Last Donated:</label>
                            <input type="date" class="form-control" name="last_donated" 
                            
                            <?php if (isset($row["blood_group"]))
                                {
                                $ldate = $row["last_donated"];
                                
                                if ($ldate != "")
                                {
                                    echo "value=\"$ldate\"";
                                }
                            }
                            ?>
                            >
                        </div>
                       
                        <div class="form-group">
                            <hr/>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="text" class="form-control" name="email" value="<?php $sql="SELECT * FROM users WHERE userID = $user_id" ; $result=mysqli_query($conn, $sql); $mailrow=mysqli_fetch_assoc($result); echo $mailrow[ 'userEmail']; ?>" disabled >
                        </div>
                       
                        <div class="form-group">
                            <label for="pass">Password: (leave this empty to not change password)</label>
                            <input type="password" class="form-control" name="pass">
                        </div>

                        <div class="form-group">
                            <hr/>
                        </div>

                        <button type="submit" class="btn btn-primary" name="btn-update">Update</button>

                        <p><br/></p>
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
