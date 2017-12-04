<?php 
 session_start();
 include_once 'inc/dbconnect.php';
 $currentPage = basename(__FILE__);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>
    <title>Constitution</title>
<body>

   <div class="wrapper">
   
    <?php include 'inc/navbar.php' ?>
    
    
    <div class="container">
        <div class="col-md-1"></div>
        <div class="col-md-10">

   <?php
     
    $sres = mysqli_query($conn, "SELECT * FROM pages WHERE page = 'constitution'");
    $row = mysqli_fetch_assoc($sres);
    $cnt = mysqli_num_rows($sres);

    if ($cnt > 0)
        echo $row['content'];
    else echo "Ask an admin to enter constitution";
    
    ?>
    </div>     
    <div class="col-md-1"></div>

   <?php if (isset($_SESSION['type']) && $_SESSION['type'] != 'Member') ?>
    <center><a href="constitution_edit.php"><button type="button" class="btn btn-primary">Edit Constitution</button></a></center>
   
    </div>
    
    
    <div class="push"></div>
    </div>

    <footer class="container-fluid text-center">
        <p>All rights reserved</p>
    </footer>



</body>

</html>
