<?php
session_start();

if(isset($_SESSION['adm_email']))
{
    include 'connect.php';
    include 'templete/header.php';
    $do=isset($_GET['do'])? $_GET['do'] :'alltasks';
    $stmt1=$con->prepare("SELECT * FROM admins");
    $stmt1->execute();
    $rows1=$stmt1->fetch();
    $adm_name=$rows1['name'];
    if($do=='alltasks')
    { 
        include "templete/navbar.php";
        ?>
        

        <h2 class="task_title" >Empolyee Leaderboard</h2>
        <a class="btn btn-primary my-5" href="?do=addform">Add new task</a>

        <table>
                <tr bgcolor="#000">
                    <th align = "center">emp_id</th>
                    <th align = "center">emp_name</th>
                    <th align = "center">Task_name</th>
                    <th align = "center">Desc</th>
                    <th align = "center">Status</th>
                    <th align = "center">Deadline</th>
                    <th align = "center">Actions</th>
                </tr>
                <?php
                $stmt1=$con->prepare("SELECT * FROM employees JOIN tasks where employees.id=tasks.emp_id");
                $stmt1->execute();
                $rows1=$stmt1->fetchAll();
                foreach($rows1 as $row)
                { ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['task_name']; ?></td>
                        <td class="w-50"><?php echo $row['desc']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['deadline']; ?></td>
                        <td>
                            <a class="btn btn-info my-1" href="?do=edit&id=<?php echo $row['task_id']; ?>&emp_id=<?php echo $row['emp_id']; ?>">Edit</a>
                            <a class="btn btn-danger my-1" href="?do=delete&id=<?php echo $row['id']; ?>">Delete</a>
                            <a class="btn btn-primary my-1" href="?do=assign&id=<?php echo $row['id'];?>">Assign to</a>
                        </td>
                    </tr>
                <?php } ?>

        </table>
    <?php }
    elseif($do=='addform')
    { 
        include "templete/navbar.php";
        ?>


        <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
            <div class="wrapper wrapper--w680">
                <div class="card card-1">
                    <div class="card-heading"></div>
                        <div class="card-body">
                        <h2 class="title text-center mb-4">Project Info</h2>
                        <form action="handleAddTask.php" method="POST">
                        <?php
                        if(isset($_SESSION['error']))
                        {
                            foreach($_SESSION['error'] as $error)
                            { ?>
                                <div class="alert alert-danger"><?php echo $error; ?></div>
                            <?php
                            }
                        }
                        ?>
                            <div class="input-group">
                                <div class="rs-select2 js-select-simple select--no-search">
                                    <select name="emp_id">
                                        <option disabled="disabled" selected="selected">Select employee</option>
                                        <?php
                                        $stmt2=$con->prepare("SELECT * FROM employees");
                                        $stmt2->execute();
                                        $rows2=$stmt2->fetchAll();
                                        foreach($rows2 as $row)
                                        { ?>
                                            <option name="emp_id" value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php } ?>
                                    </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>

                            <div class="input-group">
                                <input class="input--style-1" type="text" placeholder="task name" name="task_name">
                            </div>

                            <div class="form-group">
                                <label style="color: #666;" for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" name="desc" rows="3"></textarea>
                            </div>

                            <div class="input-group">
                                <div class="rs-select2 js-select-simple select--no-search">
                                <select name="status">
                                    <option disabled="disabled" selected="selected">Task status</option>
                                    <option value="in process">in process</option>
                                    <option value="completed">completed</option>
                                </select>
                                <div class="select-dropdown"></div>
                                </div>
                            </div>


                            <div class="input-group">
                                <input class="input--style-1" style="color: #666;" type="date" placeholder="Deadline" name="deadline">
                            </div>

                            <div class="p-t-20">
                                <button class="btn btn--radius btn--green" type="submit">Add Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    <?php
    }
    elseif($do=='assign')
    {
        $emp_id=isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']) : 0;
        $stmt=$con->prepare("SELECT *
        from employees join tasks ON employees.id = tasks.emp_id where id=?");
        $stmt->execute(array($emp_id));
        // Assign to variable
        $rows=$stmt->fetch();
        $count=$stmt->rowCount();
        if($count>0)
        {
        ?>
        <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
            <div class="wrapper wrapper--w680">
                <div class="card card-1">
                    <div class="card-heading"></div>
                    <div class="card-body">
                        <h2 class="title">Assign Project</h2>
                        <form action="assignTo.php?id=<?php echo $emp_id ?>" method="POST" enctype="multipart/form-data">
                            <div class="input-group rs-select2 js-select-simple select--no-search">

                                <select name="emp_id">
                                        <?php
                                        $stmt2=$con->prepare("SELECT * FROM employees");
                                        $stmt2->execute();
                                        $rows2=$stmt2->fetchAll();
                                        ?>
                                            <option name="emp_id" value="<?php echo $rows['id']; ?>"><?php echo $rows['name']; ?></option>
                                            <?php
                                            foreach($rows2 as $row)
                                            {?>
                                                <option name="emp_id" value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                            <?php 
                                            }
                                            ?>
                                </select>
                                <div class="select-dropdown"></div>

                            </div>

                            <div class="input-group">
                                <input class="input--style-1" Value="<?php echo $rows['task_name']?>" type="text" placeholder="Project Name" name="pname" required="required">
                            </div>

                            <div class="row row-space">
                                <div class="col-5">
                                    <div class="input-group">
                                        <input class="input--style-1" Value="<?php echo $rows['deadline']; ?>" type="date" placeholder="date" name="duedate" required="required">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="p-t-20">
                                <button class="btn btn--radius btn--green" type="submit">Assign To</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
    <?php
        }
    }
    elseif($do=="delete")
    {
        $emp_id=isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']) : 0;
        $stmt1=$con->prepare("SELECT * FROM tasks WHERE emp_id=?");
        $stmt1->execute(array($emp_id));
        $row=$stmt1->fetch();
        $task_id=$row['task_id'];
        $stmt=$con->prepare("DELETE FROM tasks WHERE task_id=?");
        $stmt->execute(array($task_id));
        header("location:allTasks.php");
        // Assign to variable
    }
    elseif($do="edit")
    {
        $task_id=isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']) : 0;
        $emp_id=isset($_GET['emp_id']) && is_numeric($_GET['emp_id'])? intval($_GET['emp_id']) : 0;
        $stmt=$con->prepare("SELECT *
        from tasks WHERE task_id=?");
        $stmt->execute(array($task_id));
        $rows=$stmt->fetch();
        //count number of row in database
        $count=$stmt->rowCount();
        if($count>0)
        { ?>
            <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
            <div class="wrapper wrapper--w680">
                <div class="card card-1">
                    <div class="card-heading"></div>
                        <div class="card-body">
                        <h2 class="title text-center mb-4">Project Info</h2>
                        <form action="update.php?id=<?php echo $task_id; ?>&emp_id=<?php echo $emp_id; ?>" method="POST">
                            <div class="input-group">
                                <div class="rs-select2 js-select-simple select--no-search">

                                <select name="emp_id">
                                        <?php
                                        $stmt2=$con->prepare("SELECT * FROM employees");
                                        $stmt2->execute();
                                        $rows2=$stmt2->fetchAll();
                                        foreach($rows2 as $row)
                                        {
                                        ?>
                                            <option name="emp_id" <?php if($rows['emp_id']==$row['id']) { ?> selected <?php } ?> value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                                        <?php } ?>
                                </select>
                                    <div class="select-dropdown"></div>
                                </div>
                            </div>

                            <div class="input-group">
                                <input class="input--style-1" type="text" value="<?php echo $rows['task_name'] ?>" placeholder="task name" name="task_name">
                            </div>

                            <div class="form-group">
                                <label style="color: #666;" for="exampleFormControlTextarea1">Description</label>
                                <textarea class="form-control" name="desc" rows="3"><?php echo $rows['desc'] ?></textarea>
                            </div>

                            <div class="input-group">
                                <div class="rs-select2 js-select-simple select--no-search">
                                <select name="status">
                                    <option disabled="disabled" selected="selected">Task status</option>
                                    <option <?php if($rows['status'] == 'in process') { ?> selected <?php } ?>  value="in process">in process</option>
                                    <option <?php if($rows['status'] == 'completed') { ?> selected <?php } ?> value="completed">completed</option>
                                </select>
                                <div class="select-dropdown"></div>
                                </div>
                            </div>


                            <div class="input-group">
                                <input class="input--style-1" value="<?php echo $rows['deadline'] ?>" style="color: #666;" type="date" placeholder="Deadline" name="deadline">
                            </div>

                            <div class="p-t-20">
                                <button class="btn btn--radius btn--green" type="submit">Update Task</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <?php 
        }
        
    }
    elseif($do=="update")
    {
        $emp_id=isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']) : 0;
        $task_name=$_POST['task_name'];
        $desc=$_POST['desc'];
        $status=$_POST['status'];
        $deadline=$_POST['deadline'];
        $stmt=$con->prepare("UPDATE tasks SET emp_id=?,task_name=?,desc=?,status=?,deadline=? where emp_id=?");
        $stmt->execute(array($emp_id,$task_name,$desc,$status,$deadline,$emp_id));
        $rows=$stmt->fetch();
    }
}
else
{
    header("location:admLogin.php");
}
?>
<?php include 'templete/footer.php'; ?>