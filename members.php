<?php 
 session_start();
 include_once 'inc/dbconnect.php';
 $currentPage = basename(__FILE__);

 if (isset($_POST['btn-add']))
 {
     $take = trim($_POST['name']);
     $take = strip_tags($take);
     $name = htmlspecialchars($take);
     
     $take = trim($_POST['roll']);
     $take = strip_tags($take);
     $roll = htmlspecialchars($take);
     
     $take = trim($_POST['designation']);
     $take = strip_tags($take);
     $designation = htmlspecialchars($take);
     
     $sql = "INSERT INTO members VALUES('$name', '$roll', '$designation')";
     $res = mysqli_query($conn, $sql);
 }

 if (isset($_POST['btn-del']))
 {
     $take = trim($_POST['name']);
     $take = strip_tags($take);
     $name = htmlspecialchars($take);
     
     $take = trim($_POST['roll']);
     $take = strip_tags($take);
     $roll = htmlspecialchars($take);
     
     $take = trim($_POST['designation']);
     $take = strip_tags($take);
     $designation = htmlspecialchars($take);

     
     $sql = "DELETE FROM members WHERE name='$name' && roll= '$roll' && designation = '$designation'";
     $res = mysqli_query($conn, $sql);     
 }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>
    <title>Members</title>
    
<body>

   <div class="wrapper">
   
    <?php include 'inc/navbar.php' ?>
    
    <div class="push"></div>
    
    <div class="container">
    <div class="col-md-2"></div>
    <div class="col-md-8">
    <table class="table table-stripped table-hover table-responsive">
    <thead>
    <tr>
        <th>Name</th>
        <th>Roll</th>
        <th>Designaton</th>
    </tr>        
    </thead>
    <tbody>
       <?php $res=mysqli_query($conn, "SELECT * FROM members");
    
        while($row = mysqli_fetch_assoc($res)) { ?>
        <tr>
            <td><?php echo $row['name']; ?></td>
            <td><?php echo $row['roll']; ?></td>
            <td><?php echo $row['designation']; ?></td>
        </tr>
        <?php } ?>
    </tbody>
    </table>
    </div>
    <div class="col-md-2"></div>
    </div>
    
      <?php if (isset($_SESSION['type']) && $_SESSION['type'] == 'Admin') { ?>
        <br/> <br/> <br/> <br/>
        <hr>
      <div class="container">
       <form class="form-inline" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
        <table style="width:100%"> <tr>
        <td width=30% align="center">
         <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name">
          </div>
        </td>
         <td width = 30% align="center">
         <div class="form-group">
            <label for="roll">Roll:</label>
            <input type="text" class="form-control" name="roll">
          </div>
        </td>
         <td width = 30% align="center">
         <div class="form-group">
            <label for="designation">Designation:</label>
            <input type="text" class="form-control" name="designation">
          </div>
        </td>
         <td width = 10% align="center">
            <button type="submit" class="btn btn-primary" name="btn-add">Add</button> 
            </td> 
            </tr>
        </table></form>
    </div>

        <hr>
      <div class="container">
       <form class="form-inline" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">
        <table style="width:100%"> <tr>
        <td width=30% align="center">
         <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" class="form-control" name="name">
          </div>
        </td>
         <td width = 30% align="center">
         <div class="form-group">
            <label for="roll">Roll:</label>
            <input type="text" class="form-control" name="roll">
          </div>
        </td>
         <td width = 30% align="center">
         <div class="form-group">
            <label for="designation">Designation:</label>
            <input type="text" class="form-control" name="designation">
          </div>
        </td>
         <td width = 10% align="center">
            <button type="submit" class="btn btn-primary" name="btn-del">Delete</button> 
            </td> 
            </tr>
        </table></form>
    </div>
   <?php } ?>
    
    </div>

    <footer class="container-fluid text-center">
        <p>All rights reserved</p>
    </footer>

</body>

</html>
