<?php 
 session_start();
 include_once 'inc/dbconnect.php';
 $currentPage = basename(__FILE__);


$tbl_name = "fquestions";

$tried_to_submit = false;
$error = false;
$errmsg = "Your topic was posted successfully!";

if (isset($_POST['Submit']))
{
    $tried_to_submit = true;
    // get data that sent from form 
    $topic=trim($_POST['topic']);
    $topic=strip_tags($topic);
    $topic=htmlspecialchars($topic);
    
    if ($topic == "")
    {
        $errmsg = "Topic title can not be empty!";
        $error = 1;
    }
    else {
        $detail=$_POST['detail'];

        $uid = $_SESSION['user'];
        $res = mysqli_query($conn, "SELECT * FROM users WHERE userId = '$uid'");
        $row = mysqli_fetch_array($res);   
        $name = $row['userName'];
        $email= $row['userEmail'];

        $datetime=date("d/m/y h:i:s"); //create date time

        $sql="INSERT INTO $tbl_name(topic, detail, name, email, datetime)VALUES('$topic', '$detail', '$name', '$email', '$datetime')";
        $result=mysqli_query($conn, $sql);

        $sql="SELECT id FROM $tbl_name WHERE '$datetime' = datetime";
        $res=mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $insid = $row['id'];

        if($result){
            $errmsg = "Your topic was posted successfully! Click <a href='view_topic.php?id=$insid'>here</a> to view it.";
        }
        else {
            $error = 1;
            $errmsg = "Something went wrong. Try again, or contact admin.";
        }
    }
}

$sql="SELECT * FROM fquestions ORDER BY id DESC";
// OREDER BY id DESC is order result by descending

$result=mysqli_query($conn, $sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'inc/head.php' ?>
    <title>Forum</title>
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>


    <body>

        <div class="wrapper">

            <?php include 'inc/navbar.php' ?>

           <?php if ($tried_to_submit == true) { ?>
            <!-- success message -->
            <div class="form-group">
                <div class="alert <?php if ($error == 1) echo "alert-danger"; else echo "alert-success"; ?>">
                    <span class="glyphicon glyphicon-info-sign"></span>
                    <?php echo $errmsg; ?>
                </div>
            </div>
            <?php } ?>
       
            <?php if (isset($_SESSION['user'])) { ?>
            <!--create new topic -->
            <center>
                <h3><b>Create New Topic</b></h3>
            </center>
            <div class="container-fluid">
                <table class="table table-responsive" width="400" border="0" align="center" cellpadding="0" cellspacing="1">
                    <tr>
                        <form id="form1" name="form1" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                            <td>
                                <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                                    <tr>
                                        <td width="10%"><strong>Topic Title</strong></td>
                                        <td width="2%">:</td>
                                        <td width="88%"><input name="topic" type="text" id="topic" size="50" /></td>
                                        
                                    </tr>
                                    <tr>
                                        <td valign="center"><br/><strong>Topic Details</strong></td>
                                        <td valign="center"><br/>:</td>
                                        <td><br/>
                                           <textarea name="detail" cols="5" rows="3" id="detail"></textarea>
                                            <script>
                                                CKEDITOR.replace('detail');

                                            </script>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td><br/><center><input type="submit" name="Submit" value="Submit" /></center></td>
                                    </tr>
                                </table>
                            </td>
                        </form>
                    </tr>
                </table>

            </div>

            <hr>
            <?php } ?>

            <div class="container-fluid">
                <center>
                    <h3><b>List of Topics</b></h3>
                </center>

                <table class="table table-stripped table-hover table-responsive" align="center">
                    <thead>
                        <tr>
                            <td width="25%" align="center"><strong>Author</strong></td>
                            <td width="43%" align="center"><strong>Topic Titles</strong></td>
                            <td width="7%" align="center"><strong>Views</strong></td>
                            <td width="12%" align="center"><strong>Replies</strong></td>
                            <td width="13%" align="center"><strong>Date/Time</strong></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php   while($rows = mysqli_fetch_array($result)){ ?>
                        <tr>
                            <td align="center">
                                <?php if (isset($rows['name'])) echo $rows['name']; ?>
                            </td>
                            <td>
                                <a href="view_topic.php?id=<?php echo $rows['id']; ?>">
                                    <?php echo $rows['topic']; ?>
                                </a>
                                <br/>
                            </td>
                            <td align="center">
                                <?php echo $rows['view']; ?>
                            </td>
                            <td align="center">
                                <?php echo $rows['reply']; ?>
                            </td>
                            <td align="center">
                                <?php echo $rows['datetime']; ?>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>

            </div>




            <div class="push"></div>
        </div>

        <footer class="container-fluid text-center">
            <p>All rights reserved</p>
        </footer>



    </body>

</html>
