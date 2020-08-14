<?php
session_start();
include 'connect.php';

if($_SERVER['REQUEST_METHOD']=='POST')
{
    $emp_name=$_POST['emp_id'];
    $task_name=$_POST['task_name'];
    $desc=$_POST['desc'];
    $status=$_POST['status'];
    $date=$_POST['deadline'];
    $formerrors=array();
    if(empty($emp_name))
    {
        $formerrors[]="username can not be empty";
    }
    if(empty($desc))
    {
        $formerrors[]="Password can not be empty";
    }
    if(empty($status))
    {
        $formerrors[]="Email can not be empty";
    }
    if(empty($date))
    {
        $formerrors[]="Email can not be empty";
    }
    $_SESSION['error']=$formerrors;

    if(empty($_SESSION['error']))
    {
        $stmt=$con->prepare('INSERT INTO tasks
        (emp_id,task_name,`desc`,`status`,deadline)
        VALUES(?,?,?,?,?)');
        $stmt->execute(array($emp_name,$task_name,$desc,$status,$date));
        header("location:allTasks.php");
    }
    else
    {
        header("location:allTasks.php?do=addform");
    }
}
?>