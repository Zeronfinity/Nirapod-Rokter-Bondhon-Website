<?php 
 session_start();
 include_once 'inc/dbconnect.php';
 $currentPage = basename(__FILE__);

    // get value of id that sent from address bar 
    $id=$_GET['id'];
    $sql="SELECT * FROM fquestions WHERE id='$id'";
    $result=mysqli_query($conn, $sql);
    $rows=mysqli_fetch_array($result);

// view
$sql3="SELECT view FROM fquestions WHERE id='$id'";
$result3=mysqli_query($conn, $sql3);
$rows3=mysqli_fetch_array($result3);
$view=$rows3['view'];

// if have no counter value set counter = 1
if(empty($view)){
$view=1;
$sql4="INSERT INTO fquestions(view) VALUES('$view') WHERE id='$id'";
$result4=mysqli_query($conn, $sql4);
}

// count more value
$addview=$view+1;
$sql5="UPDATE fquestions set view='$addview' WHERE id='$id'";
$result5=mysqli_query($conn, $sql5);


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>
    <title>
        <?php echo $rows['topic']; ?>
    </title>
    <script type="text/javascript" src="ckeditor/ckeditor.js"></script>


    <body>
        <div class="wrapper">
            <?php include 'inc/navbar.php' ?>
            <!-- view topic -->
            <div class="container-fluid">
                <h3> <center><?php echo $rows['topic']; ?></center> </h3>
                <table class="table table-stripped table-hover table-responsive table-bordered" width="100%" cellpadding="3" cellspacing="1">
                    <tr>
                        <td style="height:100px">
                            <?php echo $rows['detail']; ?>
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Written By :</strong>
                            <?php echo $rows['name']; ?>
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Date/time : </strong>
                            <?php echo $rows['datetime']; ?>
                        </td>
                    </tr>
                </table>
            </div>
            
            <hr>
            <br/>

            <!-- view replies -->
            <div class="container-fluid">
                <?php    
            $sql2="SELECT * FROM fanswer WHERE question_id='$id'";
            $result2=mysqli_query($conn, $sql2);
            while($rows=mysqli_fetch_array($result2)){
            ?>
                <table class="table table-stripped table-hover table-responsive table-bordered" width="100%" cellpadding="3" cellspacing="1">
                    <tr>
                        <td style="height:100px">
                            <?php echo $rows['a_answer']; ?>
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Replied By :</strong>
                            <?php echo $rows['a_name']; ?>
                        </td>
                    </tr>

                    <tr>
                        <td><strong>Date/time : </strong>
                            <?php echo $rows['a_datetime']; ?>
                        </td>
                    </tr>
                </table>
                <?php
        }
        ?>
            </div>
            <br/>
            <hr>

           
            <!-- add reply -->
            <div class="container-fluid">

                <form name="form1" method="post" action="add_reply.php">
                    <table class="table table-stripped table-hover table-responsive" width="100%" cellpadding="3" cellspacing="1">
                        <tr>
                            <td><textarea name="a_answer" cols="45" rows="3" id="a_answer"></textarea>
                                <script>
                                    CKEDITOR.replace('a_answer');

                                </script>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <center><input name="id" type="hidden" value="<?php echo $id; ?>"><input type="submit" name="Reply" value="Reply"></center>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>


        </div>



        <div class="push"></div>

        <footer class="container-fluid text-center">
            <p>All rights reserved</p>
        </footer>



    </body>

</html>
