<?php
include 'connect.php'; 
$emp_id=isset($_GET['id'])? $_GET['id'] : 0;

$name=$_POST['Name'];
$mail=$_POST['email'];
$pass="";
if(empty($_POST['newPassword']))
{
    $pass=$_POST['oldpassword'];
}
else
{
    $pass=sha1($_POST['newPassword']);
}
$city=$_POST['city'];
$gender=$_POST['gender'];
$phone=$_POST['phone'];
$birthday=$_POST['birthday'];
$pic=$_FILES['pic'];
$imageName=$pic['name'];
$targetFolder="images/";
$imgTmp=$pic['tmp_name'];
$path=$targetFolder.time()."-".$imageName;
move_uploaded_file($imgTmp,$path);
$error1=array();
if(empty($name))
{
    $error1[]="username can not be empty";
}
if(empty($pass) || !strlen($password)<3)
{
    $error1[]="Password can not be empty";
}
if(empty($mail) || !filter_var($mail,FILTER_VALIDATE_EMAIL))
{
    $error1[]="Email can not be empty";
}
if(empty($city))
{
    $error1[]="city can not be empty";
}
if(empty($gender))
{
    $error1[]="gender can not be empty";
}
if(empty($phone))
{
    $error1[]="phone number can not be empty";
}
if(empty($birthday))
{
    $error1[]="birthday can not be empty";
}
if(empty($pic))
{
    $error1[]="picture can not be empty";
}

$types=['images/jpg','images/jpeg','images/png','images/gif'];
if( !in_array($pic['type'],$types))
{
    $error1= "must be an image";
}

$_SESSION['error1']=$error1;

if(empty($_SESSION['error1']))
{
    $stmt=$con->prepare("UPDATE `employees`
    SET `name`=?,`email`=?,`password`=?,`city`=?,`gender`=?,`phone`=?,`birthday` =?,`pic`=?
    WHERE `employees`.`id` = ?");
    $stmt->execute(array($name,$mail,$pass,$city,$gender,$phone,$birthday,$path,$emp_id));
    header("location:myTasks.php?do=myTasks&id=$emp_id");
}
if(isset($_SESSION['error1']))
{
    header("location:myProfile.php?id=$emp_id");
}
?>