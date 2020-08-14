<?php
session_start();
include 'templete/header.php';
include 'connect.php';
$errors=array();


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $mail=$_POST['email'];
    $pass=$_POST['password'];
    $hashedPass=sha1($pass);
    $mail=htmlspecialchars($mail);
    $pass=htmlspecialchars($pass);
    $stmt=$con->prepare("SELECT email,`password`
    from admins where
    email=? and `password`=?");
    $stmt->execute(array($mail,$hashedPass));
    // Assign to variable
    $rows=$stmt->fetchAll();
    $count=$stmt->rowCount();
    if($count>0)
    {
        $_SESSION['adm_email']=$mail;
        $_SESSION['pass']=$pass;
        header("location:allTasks.php?do=alltasks");
    }
    else
    {
        header("location:admLogin.php");
    }
    if(empty($mail) || !filter_var($mail,FILTER_VALIDATE_EMAIL))
    {
      $errors['email']="Enter a valid email";
    }
    if(empty($pass) || !strlen($password)<3)
    {
      $errors['password']="Enter a valid password";
    }

    $_SESSION['errors']=$errors;
}
    ?>