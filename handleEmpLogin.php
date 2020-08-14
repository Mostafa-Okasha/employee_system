<?php
session_start();
include 'templete/header.php';
include 'connect.php';
$do=isset($_GET['do'])? $_GET['do'] :'myTasks';
$emp_id=isset($_GET['id'])? $_GET['id'] : 0;
$errors=array();


if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $mail=$_POST['email'];
    $pass=$_POST['password'];
    $hashedPass=sha1($pass);
    $mail=htmlspecialchars($mail);
    $stmt=$con->prepare("SELECT email,`password`,`id`
    from employees where
    email=? and `password`=?");
    $stmt->execute(array($mail,$hashedPass));
    // Assign to variable
    $rows=$stmt->fetch();
    $id=$rows[id];
    $count=$stmt->rowCount();
    if($count>0)
    {
        $_SESSION['email']=$mail;
        $_SESSION['pass']=$pass;
        header("location:myTasks.php?do=myTasks&id=$id");
    }
    else
    {
        header("location:empLogin.php");
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