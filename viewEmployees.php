<?php
session_start();
if(isset($_SESSION['adm_email']))
{
    include 'templete/header.php';
    include 'connect.php';
    $do=isset($_GET['do'])? $_GET['do'] :'viewEmployees';
    if($do=="allemployee")
    {
        include "templete/navbar.php";
?>
        
        <h2 class="task_title" >Empolyees</h2>
        <a class="btn btn-primary my-5" href="viewEmployees.php?do=addEmployee">Add new employee</a>

            <table>
                    <th align = "center">Emp. ID</th>
            <th align = "center">Picture</th>
                    <th align = "center">Name</th>
                    <th align = "center">Email</th>
                    <th align = "center">Birthday</th>
                    <th align = "center">Gender</th>
            <th align = "center">Options</th>
                </tr>
        <?php
                include 'connect.php';
                $do=isset($_GET['do'])? $_GET['do'] :'viewEmployees';
                $emp_id=isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']) : 0;
                $stmt=$con->prepare("SELECT * from employees");
                $stmt->execute();
                // Assign to variable
                $rows=$stmt->fetchAll();
                $count=$stmt->rowCount();
        ?>
            <?php foreach($rows as $row)
                { ?>
                <tr>
                    <td><?php echo $row['id']?></td>
                    <td><img src="<?php echo $row['pic']?>" class="rounded-circle" width="100" height="100"></td>
                    <td><?php echo $row['name']?></td>
                    <td><?php echo $row['email']?></td>
                    <td><?php echo $row['birthday']?></td>
                    <td><?php echo $row['gender']?></td>
                    <td><a href="?do=delete&id=<?php echo $row['id'] ?>" class="btn btn-danger">Delete</a></td>
                </tr>
                <?php } ?>
            </table>

        <?php
    }
        elseif($do=="delete")
        {
        $emp_id=isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']) : 0;
        $stmt=$con->prepare("DELETE FROM employees WHERE id=?");
        $stmt->execute(array($emp_id));
        header("location:viewEmployees.php?do=allemployee");
        }
        elseif($do=="addEmployee")
        { ?>
            <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
            <div class="wrapper wrapper--w680">
                <div class="card card-1">
                    <div class="card-heading"></div>
                    <div class="card-body">
                        <h2 class="title mb-5 text-center">Registration Info</h2>
                        <form action="?do=insert" method="POST" enctype="multipart/form-data">
                            <div class="input-group">
                                <input class="input--style-1" type="text" placeholder="Name" name="name">
                            </div>
                            <div class="input-group">
                                <input class="input--style-1" type="email" placeholder="Email" name="email">
                            </div>
                            <div class="input-group">
                                <input class="input--style-1" style="color: #666;" type="password" placeholder="Password" name="password">
                            </div>
                            <div class="row row-space">
                                <div class="col-5">
                                    <div class="input-group">
                                        <input class="input--style-1" type="text" placeholder="City" name="city">
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="input-group">
                                        <div class="rs-select2 js-select-simple select--no-search">
                                            <select name="gender">
                                                <option disabled="disabled" selected="selected">GENDER</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                                <option value="Other">Other</option>
                                            </select>
                                            <div class="select-dropdown"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="input-group">
                                <input class="input--style-1" type="number" placeholder="Phone Number" name="phone" >
                            </div>
                            <div class="input-group">
                                <input class="input--style-1" type="date" placeholder="Birthday" name="birthday" >
                            </div>

                            <div class="input-group">
                                <input class="custom-file-input" type="file" name="pic" >
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>

                            <div class="p-t-20">
                                <button class="btn btn--radius btn--green" type="submit">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php }
        elseif($do=="insert")
        {
            $name=$_POST['name'];
            $mail=$_POST['email'];
            $pass=$_POST['password'];
            $city=$_POST['city'];
            $gender=$_POST['gender'];
            $phone=$_POST['phone'];
            $date=$_POST['birthday'];
            $pic=$_FILES['pic'];
            $imageName=$pic['name'];
            $targetFolder="images/";
            $imgTmp=$pic['tmp_name'];
            $path=$targetFolder.time()."-".$imageNmae;
            move_uploaded_file($imgTmp,$path);

            $emp_id=isset($_GET['id']) && is_numeric($_GET['id'])? intval($_GET['id']) : 0;
            $stmt=$con->prepare("INSERT INTO employees 
            (`name`, `email`, `password` ,`city`,`gender`, `phone`, `birthday`,pic)
            VALUES (?,?,?,?,?,?,?,?)");
            $stmt->execute(array($name,$mail,$pass,$city,$gender,$phone,$date,$path));
            header("location:viewEmployees.php?do=allemployee");
        }
}
    ?>
    
<?php include 'templete/footer.php'; ?>