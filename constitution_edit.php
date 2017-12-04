<?php 
 session_start();
 include_once 'inc/dbconnect.php';
 $currentPage = basename(__FILE__);

 if (!(isset($_SESSION['type']) && $_SESSION['type'] != 'Member'))
       header("Location: login.php");

 $sres = mysqli_query($conn, "SELECT * FROM pages WHERE page = 'constitution'");
 $row = mysqli_fetch_assoc($sres);
 $cnt = mysqli_num_rows($sres);

 if (isset($_POST["btn-submit"]))
 {     
     $const = $_POST['edit'];
     if ($cnt > 0)
     {
         $sql = "UPDATE pages SET content = '$const' WHERE page = 'constitution'";
         $res=mysqli_query($conn, $sql);

         if ($res)
         {
             $done = true;
         }
     }
     else
     {
         $sql = "INSERT INTO pages (page,content) VALUES ('constitution', '$const')";
     //    echo $sql;
         $res=mysqli_query($conn, $sql);

         if ($res)
         {
             $done = true;
         }         
     }
 }

 $sres = mysqli_query($conn, "SELECT * FROM pages WHERE page = 'constitution'");
 $row = mysqli_fetch_assoc($sres);
 $cnt = mysqli_num_rows($sres);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>
    <title>Constitution Edit</title>    
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<body>

   <div class="wrapper">
   
    <?php include 'inc/navbar.php' ?>
    
    <div class="container">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" autocomplete="off">

        <div class="form-group">
            <textarea class="form-control" row="500" name="edit" placeholder="Enter Constitution Here"><?php if ($cnt>0) echo $row['content'];?></textarea>
            <script>CKEDITOR.replace('edit');</script>
        </div>
    
         <div class="form-group">
            <br/>
         </div>

       
        <center><button type="submit" class="btn btn-primary" name="btn-submit">Submit</button></center>
        
        <br/>
        
        <?php if (isset($done) && $done==true) { ?>
         <div class="form-group">
            <div class="alert alert-success">
                <span class="glyphicon glyphicon-info-sign"></span> Constitution Updated!
             </div>
         </div>
       <?php } ?>
    </form>
    </div>
    
    <div class="push"></div>
    </div>   
   
    <footer class="container-fluid text-center">
        <p>All rights reserved</p>
    </footer>



</body>

</html>
