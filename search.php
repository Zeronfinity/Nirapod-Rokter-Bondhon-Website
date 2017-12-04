<?php 
 session_start();
 include_once 'inc/dbconnect.php';

 $currentPage = basename(__FILE__);
 
$name = $roll = $blood = $city = "";

 if ( isset($_POST['btn-search']) ) {
  // clean user inputs to prevent sql injections
  $name = trim($_POST['name']);
  $name = strip_tags($name);
  $name = htmlspecialchars($name);
    
  $take = trim($_POST['roll']);
  $take = strip_tags($take);
  $roll = htmlspecialchars($take);
    
  $take = trim($_POST['city']);
  $take = strip_tags($take);
  $city = htmlspecialchars($take);
    
  $take = trim($_POST['blood']);
  $take = strip_tags($take);
  $blood = htmlspecialchars($take);
     
     
  $sql = "SELECT * FROM bloodlist WHERE 1";

  if ($name != "")
      $sql = $sql . " AND LOWER(bloodlist.name) LIKE LOWER('%$name%')";
  if ($roll != "")
      $sql = $sql . " AND LOWER(bloodlist.roll) LIKE LOWER('%$roll%')";
  if ($city != "")
      $sql = $sql . " AND LOWER(bloodlist.city) LIKE LOWER('%$city%')";
  if ($blood != "unknown")
      $sql = $sql . " AND LOWER(bloodlist.blood_group) LIKE LOWER('%$blood%')";

  $res = mysqli_query($conn, $sql);
 }

$notMember = 0;

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>
    
    <title>Search</title>

</head>

<body>

   <div class="wrapper">
   
    <?php include 'inc/navbar.php' ?>
    
    <div class="container-fluid">
        <center>
        <p><br/>If you are not an admin of this website, you won't be able to see contact numbers of female donors in search list for security purpose. <br/><br/>If you couldn't find your needed blood group from information available here, please go to <a href="request.php">Request Blood</a> and fill up the form there and we will try our utmost to help. Thanks for your understanding.<hr/></p>
       
        <form class="form-inline" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

          <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name" <?php if ($name!="") { ?> value="<?php echo $name; ?>" <?php } ?> >
          </div>
          <div class="form-group">
            <label for="blood">Blood Group:</label>
              <select class="form-control" name="blood">
                <option value="A+" <?php if ($blood=="A+") echo "selected"; ?> >A+</option>
                <option value="A-" <?php if ($blood=="A-") echo "selected"; ?> >A-</option>
                <option value="B+" <?php if ($blood=="B+") echo "selected"; ?> >B+</option>
                <option value="B-" <?php if ($blood=="B-") echo "selected"; ?> >B-</option>
                <option value="AB+" <?php if ($blood=="AB+") echo "selected"; ?> >AB+</option>
                <option value="AB-" <?php if ($blood=="AB-") echo "selected"; ?> >AB-</option>
                <option value="O+" <?php if ($blood=="O+") echo "selected"; ?> >O+</option>
                <option value="O-" <?php if ($blood=="O-") echo "selected"; ?> >O-</option>
                <option value="unknown" <?php if ($blood=="unknown") echo "selected"; ?> >All</option>                
              </select>         
          </div>        
          <div class="form-group">
            <label for="roll">Roll:</label>
            <input type="text" class="form-control" name="roll" <?php if ($roll!="") { ?> value="<?php echo $roll; ?>" <?php } ?> >
          </div>
          <div class="form-group">
            <label for="city">City:</label>
            <input type="text" class="form-control" name="city" <?php if ($city!="") { ?> value="<?php echo $city; ?>" <?php } ?> >
          </div>
          <button type="submit" class="btn btn-primary" name="btn-search">Search</button>
          
        </form>
        </center>
        <hr/>
        
        <?php
         
         if (isset($_SESSION['type']) && $_SESSION['type'] != 'Member')
             $notMember = 1;
       
        if (isset($res) && $res == true)
        { 
            $count = mysqli_num_rows($res);
            if ($count == 0) { ?>
        
        <div class="alert alert-danger">
         <span class="glyphicon glyphicon-info-sign"></span>
        <?php echo "No data found"; ?>        
        </div>
        
        <?php
           } else { ?>
            
            <table class="table table-striped table-hover table-responsive">
            <thead><tr>
            <th>Name</th>
            <th>Blood Group</th>
            <th>Roll</th>
            <th>Department</th>
            <th>Email ID</th>
            <th>Age</th>
            <th>Weight</th>
            <?php if ($notMember == 1) { ?>
            <th>Contact No</th>
            <th>Facebook ID</th>
            <th>Present Address</th> <?php } ?>
            <th>City</th>
            <th>Last Donated On</th>
            </tr></thead>
                
            <tbody>
        <?php    
          
            while($row = mysqli_fetch_assoc($res))   
            {      
        ?>   
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['blood_group']; ?></td>
                <td><?php echo $row['roll']; ?></td>
                <td><?php echo $row['dept']; ?></td>
                <td><?php echo $row['email_id']; ?></td>
                <td><?php echo $row['age']; ?></td>
                <td><?php echo $row['weight']; ?></td>
                <?php if ($notMember == 1) { ?>                
                <td><?php if ($row['gender'] == "Male" || $notMember == 1) echo $row['contact_no']; else echo "Contact numbers of female donors are hidden for security"; ?></td>
                <td><?php echo $row['facebook_id']; ?></td>
                <td><?php echo $row['present_address']; ?></td> <?php } ?>
                <td><?php echo $row['city']; ?></td>                    
                <td><?php echo $row['last_donated']; ?></td>                    
            </tr> 
              
        <?php } ?>             
            </tbody>    
                    
            </table>
            
       <?php     }
        
        } ?>
            

       </div>
    </div>
    
    <div class="push"></div>
    </div>

    <footer class="container-fluid text-center">
        <p>All rights reserved</p>
    </footer>



</body>

</html>
