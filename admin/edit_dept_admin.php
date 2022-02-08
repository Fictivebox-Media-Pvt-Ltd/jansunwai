<?php
include_once '../configs/includes.php';

if(!isset($_GET['id'])){
    header('location:dept_admin_list.php');
}

if((isset($_FILES['profile_image'])) || (isset($_POST['f_name']) && isset($_POST['admin_email']) && isset($_POST['selected_dept']))){
    $profile_image = isset($_FILES['profile_image']['name']) ? $_FILES['profile_image']['name'] : '';
    $image_upload = '';
    if (!empty($profile_image)) {
        $target_dir = "images/avatar/";
        $image_upload = md5(time().get_client_ip()).'.'.pathinfo($_FILES['profile_image']['name'],PATHINFO_EXTENSION);
        $imageS = $_FILES['profile_image']['size'];
        $ftmp = $_FILES['profile_image']['tmp_name'];
        $store = $target_dir . $image_upload;
        move_uploaded_file($ftmp, $store);
    }
    update_dept_admin($conn,$_GET['id'],$image_upload,$_POST['f_name'],$_POST['l_name'],$_POST['admin_email'],$_POST['selected_dept'],$_POST['update_password']);
    header("Location: dept_admin_list.php"); 
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    $admin_dir_name = dirname($_SERVER['PHP_SELF']);
    $user_id = $_SESSION['user_id'];
    $loginUserData = get_user_details($conn,$user_id);
    $adminName = $loginUserData['f_name'] . ' ' . $loginUserData['l_name'];
    $fName = $loginUserData['f_name'];
    $lName = $loginUserData['l_name'];
    $adminImage = $loginUserData['user_image'];
    $deptId = $loginUserData['department_id'];
    $adminEmail = $loginUserData['email'];
    $userName = $loginUserData['username'];
    $deptName = get_department_details($conn,$deptId);
}

$all_depts = array();
$all_depts = get_all_dept($conn);

$admin_details = get_dept_admin($conn,$_GET['id']);
?>
<!DOCTYPE html>
<html lang="zxx" class="js">
<?php include_once 'head.php'; ?>

<body class="nk-body bg-lighter npc-default has-sidebar">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?php include_once 'sidebar.php'; ?>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php include_once 'header.php'; ?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head" style="padding: 75px 10px 0px 10px;">
                        <div class="nk-block-head-content">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Update Vibhag Admin</h5>
                            </div>
                            <form method="POST" enctype="multipart/form-data" class="gy-3 form-validate">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">Profile Image</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <?php
                                                    $target_dir = "images/avatar/";
                                                    $img_name = $admin_details['user_image'];
                                                    $profile_image = isset($img_name) ? $target_dir.$img_name : $target_dir.'no-user-image.png';
                                                ?>
                                                <img class="form-control" src=<?php echo $profile_image ?> id="output" style="width: 150px; height:170px;  background-color: white;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Update Profile Image</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="custom-file">
                                            <input type="file" name="profile_image" multiple="" class="custom-file-input" id="customFile" accept="image/x-png,image/jpg,image/jpeg" onchange="loadFile(event)">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">First Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter first name" name="f_name" onkeypress="return AvoidSpace(event)" value="<?php echo $admin_details['f_name']?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Last Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter last name" name="l_name" value="<?php echo $admin_details['l_name']?>" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Email Id</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="email" class="form-control" placeholder="Enter e-mail address" name="admin_email" onblur="validateEmail(this)" value="<?php echo $admin_details['email']?>" onkeypress="return AvoidSpace(event)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Select Vibhag</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select name="selected_dept" class="form-control">
                                                    <option value="<?php echo $admin_details['department_id']; ?>" selected disabled hidden><?php echo $admin_details['name']?></option>
                                                    <?php foreach($all_depts as $key => $value){?>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Update Password</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="password" class="form-control" placeholder="Update password" name="update_password" onkeypress="return AvoidSpace(event)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-lg-7 offset-lg-5">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary">Update</button><br><br><br>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- card -->
                </div><!-- .nk-block -->                    
                <!-- content @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
        <?php include_once 'footer.php'; ?>
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script>
        function AvoidSpace(event) {
            var k = event ? event.which : window.event.keyCode;
            if (k == 32) return false;
        }

        function validateEmail(emailField) {
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

            if (reg.test(emailField.value) == false) {
                document.getElementById("admin_email").style.border = "2px solid #ff0000";
                return false;
            }
            document.getElementById("admin_email").style.border = "";
            return true;
        }
        var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>
</html>