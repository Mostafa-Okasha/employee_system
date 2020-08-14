<header>
    <nav>
    <?php if(isset($adm_name)){ ?>
    <h1><?php echo $adm_name ?></h1>
    <?php } ?>

    <?php if(isset($name)){ ?>
    <h1><?php echo $name ?></h1>
    <?php }

    if(isset($path))
    {
    ?>
    <img class="rounded-circle" width="40" height="40" src="<?php echo $path;?>">
    <?php }

    else
    {
    echo "";
    } ?>

        <ul id="navli">
        <?php if(!isset($_SESSION['adm_email'])  && !isset($_SESSION['email']))
        { ?>
            <li><a class="homered" href="index.php">HOME</a></li>
            <li><a class="homeblack" href="empLogin.php">Employee Login</a></li>
            <li><a class="homeblack" href="admLogin.php">Admin Login</a></li>
        <?php } ?>
            <?php if(isset($_SESSION['adm_email']))
            {?>
            <li><a class="homered" href="allTasks.php?do=alltasks">All tasks</a></li>
            <li><a class="homeblack" href="viewEmployees.php?do=allemployee">View employee</a></li>
            <li><a class="homeblack" href="logout.php">Logout</a></li>
            <?php } ?>
            <?php if(isset($_SESSION['email']))
            {?>
            <li><a class="homered" href="myTasks.php?do=myTasks&id=<?php echo $emp_id; ?>">My Tasks</a></li>
            <li><a class="homeblack" href="chat.php?id=<?php echo $emp_id; ?>">Chat</a></li>
            <li><a class="homeblack" href="myProfile.php?id=<?php echo $emp_id; ?>">Profile</a></li>
            <li><a class="homeblack" href="logout.php">Logout</a></li>
            <?php } ?>
        </ul>
    </nav>
</header>

<div class="divider"></div>