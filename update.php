<?php
    include 'connect.php';
    $emp_id=isset($_GET['emp_id']) && is_numeric($_GET['emp_id'])? intval($_GET['emp_id']) : 0;
    echo $emp_id;
    $task_name=$_POST['task_name'];
    $desc=$_POST['desc'];
    $status=$_POST['status'];
    $deadline=$_POST['deadline'];
    $stmt=$con->prepare("UPDATE tasks SET emp_id=?,task_name=?, `desc` =?,`status`=?,deadline=?
    where emp_id=?");
    $stmt->execute(array($emp_id,$task_name,$desc,$status,$deadline,$emp_id));
    header("location:allTasks.php");
?>