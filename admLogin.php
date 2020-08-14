<?php include 'templete/header.php';
session_start();
include "templete/navbar.php";
?>

<div class="loginbox">
    <img src="assets/admin.png" class="avatar">
        <h1>Login Here</h1>
        <form action="handleAdmLogin.php" method="post">
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
            <input type="text" name="email" placeholder="Enter Email Address" >
            <p>Password</p>
            <input type="password" name="password" placeholder="Enter Password">
            <input type="submit" name="login-submit" value="Login">
        </form>
</div>
<?php session_destroy(); ?>
<?php 
include 'templete/footer.php';?>