<?php
include "templete/header.php"; 
include 'connect.php';
session_start();
$emp_id=isset($_GET['id'])? $_GET['id'] : 0;
$stmt=$con->prepare("SELECT *
from employees where id=?");
$stmt->execute(array($emp_id));
// Assign to variable
$rows=$stmt->fetch();
$name=$rows['name'];
$path=$rows['pic'];
include "templete/navbar.php";
?>
	<div class="divider"></div>

<?php
  $stmt=$con->prepare("SELECT * FROM employees where id=?");
  $stmt->execute(array($emp_id));
  $rows=$stmt->fetch();
?>
<!-- <form id = "registration" action="edit.php" method="POST"> -->
<div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1">
                <div class="card-heading"></div>
                <div class="card-body">
                    
                    <form method="POST" action="myprofileup.php?id=<?php echo $emp_id; ?>" enctype="multipart/form-data">
                    <?php
                    if(isset($_SESSION['error1']))
                    {
                      foreach($_SESSION['error1'] as $error)
                      { ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                      <?php }
                    }
                    ?>
                        <div class="input-group ">
                        <h2 class="title" >My Info</h2>
                        </div>
                        <img src="<?php echo $rows['pic']; ?>" class="img-fluid rounded-circle my-4" width="100px" height="100px" alt="">
                        <div class="row row-space">
                            <div class="col-12">
                                <div class="input-group">
                                  <p>Name</p>
                                    <input class="input--style-1" type="text" name="Name" value="<?php echo $rows['name']; ?>">
                                </div>
                            </div>

                        </div>

                        <div class="input-group">
                          <p>Email</p>
                            <input class="input--style-1" type="email"  name="email" value="<?php echo $rows['email']; ?>">
                        </div>

                        <div class="input-group">
                          <p>Password</p>
                            <input type="hidden" name='oldpassword' value="<?php echo $rows['password']; ?>"/>
                            <input class="input--style-1" style="color: #666;" type="password" name='newPassword' class='form-control form-control-lg'/>
                        </div>
                        
                        <div class="row row-space">
                            <div class="col-5">
                                <div class="input-group">
                                  <p>City</p>
                                    <input class="input--style-1" type="text" name="city" value="<?php echo $rows['city']; ?>">
                                
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="input-group">
                                  <p>Gender</p>
                                  <input class="input--style-1" type="text" name="gender" value="<?php echo $rows['gender']; ?>" >
                                </div>
                            </div>
                        </div>
                        
                        <div class="input-group">
                          <p>Phone Number</p>
                            <input class="input--style-1" type="number" name="phone" value="<?php echo $rows['phone']; ?>">
                        </div>

                        <div class="input-group">
                          <input class="input--style-1" Value="<?php echo $rows['birthday']; ?>" type="date" placeholder="date" name="birthday" required="required">
                        </div>

                        <div class="input-group">
                            <input class="custom-file-input" type="file" name="pic" >
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>

                        <input type="hidden" name="id" id="textField" value="" required="required"><br><br>
                        <div class="p-t-20">
                            <button class="btn btn--radius btn--green"  name="send" >Update Info</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


<?php include 'templete/footer.php'; ?>


