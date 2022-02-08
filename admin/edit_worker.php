<?php
include_once '../configs/includes.php';

if((isset($_FILES['user_image'])) || (isset($_POST['f_name']) && $_POST['l_name'] && isset($_POST['worker_email']) && isset($_POST['phone_no']) && isset($_POST['aadhar_no']) && isset($_POST['dob']) && isset($_POST['dom']))){
    $image_upload = '';
    if(isset($_FILES['user_image'])){
        $user_image = isset($_FILES['user_image']['name']) ? $_FILES['user_image']['name'] : '';
        if (!empty($user_image)) {
            $target_dir = "images/avatar/";
            $image_upload = md5(time().get_client_ip()).'.'.pathinfo($_FILES['user_image']['name'],PATHINFO_EXTENSION);
            $imageS = $_FILES['user_image']['size'];
            $ftmp = $_FILES['user_image']['tmp_name'];
            $store = $target_dir . $image_upload;
            move_uploaded_file($ftmp, $store);
        }
    }
    update_worker($conn,$_GET['id'],$image_upload,$_POST['f_name'],$_POST['l_name'],$_POST['worker_email'],$_POST['phone_no'],$_POST['aadhar_no'],$_POST['dob'],$_POST['dom']);
}
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    $worker_dir_name = dirname($_SERVER['PHP_SELF']);
    $user_id = $_SESSION['user_id'];
    $query = "SELECT department_id,f_name,l_name,user_image FROM tbl_admin_users WHERE id=$user_id";
    $loginUserData = get_user_details($conn, $user_id);
    $adminName = $loginUserData['f_name'] . ' ' . $loginUserData['l_name'];
    $adminImage = $loginUserData['user_image'];
    $adminEmail = $loginUserData['email'];
    $deptId = $loginUserData['department_id'];
    $deptName = get_department_details($conn, $deptId);
}
$bjp_worker_details = get_bjp_workers($conn,$_GET['id']);
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
                                <h5 class="card-title">Update Karyakarta Details</h5>
                            </div>
                            <form method="POST" enctype="multipart/form-data" class="gy-3">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">User Image</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <img class="form-control" src=<?php 
                                                $image_file = isset($bjp_worker_details['user_image']) ? $bjp_worker_details['user_image'] : 'no-user-image.png';
                                                echo $worker_dir_name . '/images/avatar/'.$image_file ?> id="output" style="width: 150px; height:170px;  background-color: white;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Update User Image</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="custom-file">
                                                    <input type="file" name="user_image"  multiple="" class="custom-file-input" id="customFile" accept="image/x-png,image/jpg,image/jpeg" onchange="loadFile(event)">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
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
                                            <input type="text" class="form-control" placeholder="Enter first name" name="f_name" onkeypress="return AvoidSpace(event)" value="<?php echo $bjp_worker_details['f_name']?>" required>
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
                                            <input type="text" class="form-control" placeholder="Enter last name" name="l_name" onkeypress="return AvoidSpace(event)" value="<?php echo $bjp_worker_details['l_name']?>">
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
                                            <input type="email" class="form-control" placeholder="Enter e-mail address" name="worker_email" onblur="validateEmail(this)" onkeypress="return AvoidSpace(event)" value="<?php echo $bjp_worker_details['email']?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Phone Number</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="Enter phone number" name="phone_no" onkeypress="return AvoidSpace(event)" value="<?php echo $bjp_worker_details['phone_no']?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Aadhar Card No.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="Enter adhaar number" name="aadhar_no" onkeypress="return AvoidSpace(event)" value="<?php echo $bjp_worker_details['aadhar_no']?>" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Date of Birth</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                                <input value="<?php echo $bjp_worker_details['dob']?>" style="max-height: 35px;" type="text" name="dob" placeholder="Enter birthday date" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress"  onkeypress="return AvoidSpace(event)" id="outlined-date-picker" required data-date-format="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Date of Marriage</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <div class="form-icon form-icon-left">
                                                <em class="icon ni ni-calendar"></em>
                                            </div>
                                                <?php 
                                                $dom = (date('Y',strtotime($bjp_worker_details['dom'])) > '1970') ? date('d-m-Y',strtotime($bjp_worker_details['dom'])) : NULL;
                                                if($dom)
                                                    $dom = $bjp_worker_details['dom'];
                                                else
                                                    $dom = NULL;
                                                ?>
                                                <input value="<?php echo $dom;?>" style="max-height: 35px;" type="text" name="dom" placeholder="Enter marriage date" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress"  onkeypress="return AvoidSpace(event)" id="outlined-date-picker" data-date-format="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                </div>                               
                                <div class="row g-3">
                                    <div class="col-lg-7 offset-lg-5">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary">publish</button><br><br><br>
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
        jQuery(document).ready(function($) {
            $('.disableKeyPress').bind('keypress', function(e) {
                e.preventDefault();
            });
        });

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