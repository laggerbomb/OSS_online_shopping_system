<?php
session_start();
include("../../db.php");
$user_id = $_REQUEST['user_id'];

if (isset($_POST['btn_save'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $user_password = $_POST['password'];

    mysqli_query($con,"update user_info set first_name='$first_name', last_name='$last_name', email='$email', password='$user_password' where user_id='$user_id'") or die("Query 2 is incorrect..........");

    header("location: manageuser.php");
    mysqli_close($con);
}

// Fetch user data
$result = mysqli_query($con, "SELECT * FROM user_info WHERE user_id='$user_id'") or die("Query to fetch user data is incorrect.");
$row = mysqli_fetch_assoc($result);
$first_name = $row['first_name'];
$last_name = $row['last_name'];
$email = $row['email'];
$user_password = $row['password'];

include "sidenav.php";
include "topheader.php";
?>
<!-- End Navbar -->
<div class="content">
    <div class="container-fluid">
        <div class="col-md-5 mx-auto">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h5 class="title">Edit User</h5>
                </div>
                <form action="edituser.php" name="form" method="post" enctype="multipart/form-data">
                    <div class="card-body">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>" />
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label>First name</label>
                                <input type="text" id="first_name" name="first_name" class="form-control" value="<?php echo $first_name; ?>" >
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label>Last name</label>
                                <input type="text" id="last_name" name="last_name" class="form-control" value="<?php echo $last_name; ?>" >
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address</label>
                                <input type="email" id="email" name="email" class="form-control" value="<?php echo $email; ?>">
                            </div>
                        </div>
                        <div class="col-md-12 ">
                            <div class="form-group">
                                <label>Password</label>
                                <input type="text" name="password" id="password" class="form-control" value="<?php echo $user_password; ?>">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" id="btn_save" name="btn_save" class="btn btn-fill btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
include "footer.php";
?>
