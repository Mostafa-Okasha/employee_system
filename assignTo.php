<?php
include 'connect.php';
    $id=$_POST['emp_id'];
    $emp_id=isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']) : 0;
    $name=$_POST['emp_id'];
    echo $name;
    $stmt=$con->prepare("UPDATE tasks SET emp_id =? WHERE emp_id=?");
    $stmt->execute(array($id,$emp_id));
    header("location:allTasks.php");
?>