<?php include "templete/header.php";
session_start();
include 'connect.php';
$do=isset($_GET['do'])? $_GET['do'] :'myTasks';
$emp_id=isset($_GET['id'])? $_GET['id'] : 0;


if($do=="myTasks")
{
  $stmt=$con->prepare("SELECT *
  from employees where id=?");
  $stmt->execute(array($emp_id));
  // Assign to variable
  $rows=$stmt->fetch();
  $name=$rows['name'];
  $path=$rows['pic'];
  include "templete/navbar.php";
?>


    <h2 class="task_title" >Empolyee Leaderboard</h2>
      
    <table>
            <tr bgcolor="#000">
                <th align = "center">emp_id</th>
                <th align = "center">Task_name</th>
                <th align = "center">Desc</th>
                <th align = "center">Status</th>
                <th align = "center">Deadline</th>
                <th align = "center">Actions</th>
            </tr>
            <?php
            $stmt1=$con->prepare("SELECT * FROM tasks where emp_id=?");
            $stmt1->execute(array($emp_id));
            $rows1=$stmt1->fetchAll();
            foreach($rows1 as $row)
            { ?>
                <tr>
                    <td><?php echo $row['emp_id']; ?></td>
                    <td><?php echo $row['task_name']; ?></td>
                    <td class="w-50"><?php echo $row['desc']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><?php echo $row['deadline']; ?></td>
                    <?php
                    if($row['status']=='in process')
                    {
                    ?>
                    <td>
                        <a class="btn btn-info my-1" href="myTasks.php?do=done&id=<?php echo $row['emp_id']; ?>">Done</a>
                    </td>
                    <?php 
                    }
                    else
                    { ?>
                      <td>
                      <a class="btn btn-danger my-1" href="myTasks.php?do=back&id=<?php echo $row['emp_id']; ?>">Back</a>
                      </td>
                    <?php
                    }
                    ?>
                </tr>
            <?php } ?>

    </table>
<?php
}
elseif($do=="done")
{
  $stmt=$con->prepare("UPDATE `tasks` SET `status` = 'complete' WHERE `tasks`.`emp_id` = ?");
  $stmt->execute(array($emp_id));
  header("location:myTasks.php?do=myTasks&id=$emp_id");
}
elseif($do=='back')
{
  $stmt=$con->prepare("UPDATE `tasks` SET `status` = 'in process' WHERE `tasks`.`emp_id` = ?");
  $stmt->execute(array($emp_id));
  header("location:myTasks.php?do=myTasks&id=$emp_id");
}
?>
<?php include "templete/footer.php" ?>