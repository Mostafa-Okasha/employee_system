<?php include "templete/header.php"; 
include "connect.php";
session_start();
include "templete/navbar.php";
?>


<div class="loginbox">
    <img src="assets/avatar.png" class="avatar">
        <h1>Login Here</h1>
        <form action="handleEmpLogin.php" method="post">
        <?php
        if(isset($_SESSION['errors']))
        {
          foreach($_SESSION['errors'] as $error)
          {
        ?>
        <div class="alert alert-danger"><?php echo $error ; ?></div>
        <?php 
          }
      } 
        session_unset();
      ?>
            <p>Email</p>
            <input type="text" name="email" placeholder="Enter Email Address">
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password">
            <input type="submit" name="login-submit" value="Login">
        </form>   
</div>

<?php include "templete/footer.php" ?>