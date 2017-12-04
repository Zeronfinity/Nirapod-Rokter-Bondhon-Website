<?php 
 session_start();
 include_once 'inc/dbconnect.php';

 $currentPage = basename(__FILE__);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>
    <title>Home</title>    
</head>

<body>
   <div class="wrapper">

    <?php include 'inc/navbar.php' ?>

    <div class="jumbotron container-fluid headerbg">
            <div class="col-sm-12 text-center">
               <div class="headerfont">
                <br/> <br/>
                <h1>Welcome</h1>
                <br/>
                <h3>NiRoB, Nirapod Rokter Bondhon, is a volunteering organization of RUET. Our motto is "Donate Blood, Save Life"</h3>
                <br/>
                <h3>If you are looking for blood, click below</h3>
               </div>
                <br/> <br/>
                <a href="request.php" class="btn btn-primary btn-lg" role="button">Request Blood</a>
            </div>
    </div>

    <div class="container">
        <h3>Some statistics</h3>
        <hr>
        <table class="table table-striped table-hover table-responsive">
        <thead><tr><th width="50%">Blood Group</th><th>Number of donors in website database</th></thead>
        <tbody>
          <?php
           $res=mysqli_query($conn, "SELECT COUNT(blood_group) AS cnt FROM bloodlist WHERE blood_group='A+'");
           $row=mysqli_fetch_assoc($res);
           ?>
            <tr><td>A+</td><td><?php echo $row['cnt']; ?></td></tr>
          <?php
           $res=mysqli_query($conn, "SELECT COUNT(blood_group) AS cnt FROM bloodlist WHERE blood_group='A-'");
           $row=mysqli_fetch_assoc($res);
           ?>
            <tr><td>A-</td><td><?php echo $row['cnt']; ?></td></tr>
          <?php
           $res=mysqli_query($conn, "SELECT COUNT(blood_group) AS cnt FROM bloodlist WHERE blood_group='B+'");
           $row=mysqli_fetch_assoc($res);
           ?>
            <tr><td>B+</td><td><?php echo $row['cnt']; ?></td></tr>
          <?php
           $res=mysqli_query($conn, "SELECT COUNT(blood_group) AS cnt FROM bloodlist WHERE blood_group='B-'");
           $row=mysqli_fetch_assoc($res);
           ?>
            <tr><td>B-</td><td><?php echo $row['cnt']; ?></td></tr>
          <?php
           $res=mysqli_query($conn, "SELECT COUNT(blood_group) AS cnt FROM bloodlist WHERE blood_group='O+'");
           $row=mysqli_fetch_assoc($res);
           ?>
            <tr><td>O+</td><td><?php echo $row['cnt']; ?></td></tr>
          <?php
           $res=mysqli_query($conn, "SELECT COUNT(blood_group) AS cnt FROM bloodlist WHERE blood_group='O-'");
           $row=mysqli_fetch_assoc($res);
           ?>
            <tr><td>O-</td><td><?php echo $row['cnt']; ?></td></tr>
          <?php
           $res=mysqli_query($conn, "SELECT COUNT(blood_group) AS cnt FROM bloodlist WHERE blood_group='AB+'");
           $row=mysqli_fetch_assoc($res);
           ?>
            <tr><td>AB+</td><td><?php echo $row['cnt']; ?></td></tr>
            <?php
           $res=mysqli_query($conn, "SELECT COUNT(blood_group) AS cnt FROM bloodlist WHERE blood_group='AB-'");
           $row=mysqli_fetch_assoc($res);
           ?>
            <tr><td>AB-</td><td><?php echo $row['cnt']; ?></td></tr>
          <?php
           $res=mysqli_query($conn, "SELECT COUNT(blood_group) AS cnt FROM bloodlist");
           $row=mysqli_fetch_assoc($res);
           ?>
            <tr><td>Total</td><td><?php echo $row['cnt']; ?></td></tr>            
        </tbody>
        </table>
        <br/>
        <b>Approximate number of donations managed by us so far:</b> &nbsp;
        <?php
        $resdon=mysqli_query($conn, "SELECT donation_managed from stats");
        $rowdon=mysqli_fetch_assoc($resdon);
        echo $rowdon['donation_managed'];
        ?>
         <br/><br/><br/>
        
        There might be more yet not registered in database here, so do request for blood even if a certain blood group is not in the database.
    </div>
    
    <br/><br/><hr>
    

    <!-- Carousel -->

    <div class="container">
        <hr>
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active">
                            <img src="images/home_carousel1.jpg" alt="image" style="width:100%;">
                        </div>

                        <div class="item">
                            <img src="images/home_carousel2.jpg" alt="image" style="width:100%;">
                        </div>

                        <div class="item">
                            <img src="images/home_carousel3.jpg" alt="New york" style="width:100%;">
                        </div>

                        <div class="item">
                            <img src="images/home_carousel4.jpg" alt="New york" style="width:100%;">
                        </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="right carousel-control" href="#myCarousel" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
    </div>
    
    <br/>

    <div class="push"></div>
    </div>

    <footer class="container-fluid text-center">
        <p>All rights reserved</p>
    </footer>

</body>

</html>
