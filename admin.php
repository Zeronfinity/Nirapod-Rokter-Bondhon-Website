<?php 
 session_start();
 include_once 'inc/dbconnect.php';
 $currentPage = basename(__FILE__);

 if (!isset($_SESSION['type']) || $_SESSION['type'] != 'Admin')
       header("Location: index.php");

if ( isset($_POST['btn-role']) ) {
  // clean user inputs to prevent sql injections
  $take = trim($_POST['role']);
  $take = strip_tags($take);
  $role = htmlspecialchars($take);
    
  $take = trim($_POST['email']);
  $take = strip_tags($take);
  $email = htmlspecialchars($take);
         
  $sql = "UPDATE users SET userType='$role' WHERE userEmail='$email' AND userType!='Admin'";
    
  $res = mysqli_query($conn, $sql);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>

    <title>Admin Panel</title>
</head>    
<body>

   <div class="wrapper">
   
    <?php include 'inc/navbar.php' ?>
    
    <div class="container-fluid">
           <div class="col-md-2"></div>
        <div class="col-md-8">
         <center>
           <div class="form-group">
             <h2 class="text-center">Moderators and Admins</h2>
             <br/>
           </div>
                      
            <table class="table table-striped table-hover table-responsive">
            <thead><tr>
            <th>Username</th>
            <th>Email ID</th>
            <th>User Type</th>
            </tr></thead>
                
            <tbody>
            <?php    
            $sql = "SELECT * FROM users WHERE users.userType != 'Member'"; 
            $res = mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($res))   
            {      
            ?>               
            <tr>
                <td><?php echo $row['userName']; ?></td>
                <td><?php echo $row['userEmail']; ?></td>
                <td><?php echo $row['userType']; ?></td>    
             </tr>
             <?php } ?>
            </tbody>    
                    
            </table>         
        </center>   

       <form class="form-inline" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
        <table style="width:100%"> <tr>
        <td width=33% align="center">
         <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" class="form-control" name="email">
          </div>
        </td>
            <td width = 10%></td>
         <td width = 33% align="center">
          <div class="form-group">
            <label for="role">Role:</label>
              <select class="form-control" name="role">
                <option value="Moderator">Moderator</option>
                <option value="Member">Member</option>
              </select>         
          </div>        
        </td>
         <td width = 24% align="center">
            <button type="submit" class="btn btn-primary" name="btn-role">Submit</button> 
            </td> 
            </tr>
        </table></form>
         
         <br/> <br/> <hr>

         <form class="form-inline" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off"><td>
        <table style="width:100%"><tr><td>
        <label for="donation_managed">Approximate number of donations managed by us so far :</label>
            </td><td>
            <?php
            $resdon=mysqli_query($conn, "SELECT donation_managed from stats");
            $rowdon=mysqli_fetch_assoc($resdon);
            ?>

            <input type="text" class="form-control" name="donation_managed" value="<?php echo $rowdon['donation_managed']; ?>"></td><td>
       
         <button type="submit" class="btn btn-primary" name="btn-donation-managed">Submit</button>
        </td></tr></table>
                </form>

    </div>
        <div class="col-md-2"></div>          
    </div>

    

    
    
    <div class="push"></div>
    </div>

    <footer class="container-fluid text-center">
        <p>All rights reserved</p>
    </footer>



</body>

</html>