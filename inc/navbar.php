<!-- navbar -->

<nav class="navbar navbar-inverse <?php echo "navbar-fixed-top"; ?> ">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>                        
                </button>
            <a href="index.php"><img src="images/logo.png"></a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                <li <?php if ($currentPage=="index.php") { ?> class="active"<?php } ?> ><a href="index.php">Home</a></li>
                <li <?php if ($currentPage=="bloodregister.php") { ?> class="active"<?php } ?> ><a href="bloodregister.php">Register Blood Group</a></li>
                <li <?php if ($currentPage=="request.php") { ?> class="active"<?php } ?> ><a href="request.php">Request Blood</a></li>
                <li <?php if ($currentPage=="search.php") { ?> class="active"<?php } ?> ><a href="search.php">Search</a></li>
                <li <?php if ($currentPage=="members.php") { ?> class="active"<?php } ?> ><a href="members.php">Members</a></li>
                <li <?php if ($currentPage=="constitution.php") { ?> class="active"<?php } ?> ><a href="constitution.php">Constitution</a></li>
                <li <?php if ($currentPage=="forum.php") { ?> class="active"<?php } ?> ><a href="forum.php">Forum</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (!isset($_SESSION['user'])) { ?>
                <li <?php if ($currentPage=="register.php") { ?> class="active"<?php } ?> ><a href="register.php"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                <li <?php if ($currentPage=="login.php") { ?> class="active"<?php } ?> ><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Sign In</a></li>
                <?php } 
                            else {
                            ?>

                <li class="dropdown<?php if ($currentPage=="account.php" || $currentPage=="admin.php") echo " active";?>"><a class="dropdown-toggle" data-toggle="dropdown" href="account.php"><span class="glyphicon glyphicon-user"></span> User Account<span class="caret"></span></a>
                    <ul class="dropdown-menu">
                      <li><a href="account.php">User Account</a></li>
                      <li><a href="admin.php">Admin Panel</a></li>
                    </ul>
                </li>
            
                <li <?php if ($currentPage=="logout.php") { ?> class="active"<?php } ?> ><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Sign Out</a></li>

                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

    <div class="push"></div>

