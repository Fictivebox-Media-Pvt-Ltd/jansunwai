<?php
include_once '../configs/includes.php';

$allDepartmentIds = getDepartmentIds($conn);

$valid_form_data = TRUE;

if((isset($_FILES['profile_image'])) || (isset($_POST['f_name']) && isset($_POST['admin_email']) && isset($_POST['admin_username']) && isset($_POST['selected_dept']) && isset($_POST['password']) && isset($_POST['confirm_password']))){

    if (isset($_POST['password']) && isset($_POST['confirm_password'])) {
        if ($_POST['password'] === $_POST['confirm_password']) {
            $password = md5($_POST['password']);
        }else{
            $valid_form_data = FALSE;
        }
    }
    
    if($valid_form_data){
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
        $loksabha = isset($_POST['selected_loksabha']) ? $_POST['selected_loksabha'] : '';
        $vidhansabha = isset($_POST['selected_vidhansabha']) ? $_POST['selected_vidhansabha'] : '';
        $phone_no = isset($_POST['phone_no']) ? $_POST['phone_no'] : NULL;
        $aardhar_no = isset($_POST['aardhar_no']) ? $_POST['aardhar_no'] : NULL;

        add_dept_admin($conn,$image_upload,$_POST['f_name'],$_POST['l_name'],$_POST['admin_email'],$_POST['admin_username'],$_POST['selected_dept'],$password,$loksabha,$vidhansabha,$phone_no,$aardhar_no);
    }
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
$all_loksabhas = array();
$all_loksabhas = get_all_loksabha($conn);
$all_vidhansabhas = array();
$all_vidhansabhas = get_all_vidhansabha($conn);
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
                                <h5 class="card-title">Add Vibhag Admin</h5>
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
                                                <img class="form-control" src=<?php echo $admin_dir_name . '/images/no-user-image.png'?> id="output" style="width: 150px; height:170px;  background-color: white;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Upload Profile Image</label>
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
                                            <input type="text" class="form-control" placeholder="Enter first name" name="f_name" onkeypress="return AvoidSpace(event)" required>
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
                                            <input type="text" class="form-control" placeholder="Enter last name" name="l_name" onkeypress="return AvoidSpace(event)">
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
                                            <input type="email" class="form-control" placeholder="Enter e-mail address" name="admin_email" onblur="validateEmail(this)" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Username</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter username" name="admin_username" onkeypress="return AvoidSpace(event)" required>
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
                                                <select name="selected_dept" class="form-control vibhag">
                                                    <?php foreach($all_depts as $key => $value){?>
                                                        <option value="" selected disabled hidden>Choose here</option>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!------->
                                <div class="box">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Select Loksabha</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select name="selected_loksabha" class="form-control">
                                                    <?php foreach($all_loksabhas as $key => $value){?>
                                                        <option value="" selected disabled hidden>Choose here</option>
                                                        <option value="<?php echo $value['loksabha']; ?>"><?php echo $value['loksabha']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Select Vidhansabha</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select name="selected_vidhansabha" class="form-control">
                                                    <?php foreach($all_vidhansabhas as $key => $value){?>
                                                        <option value="" selected disabled hidden>Choose here</option>
                                                        <option value="<?php echo $value['vidhansabha']; ?>"><?php echo $value['vidhansabha']; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <!---->
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Phone No</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="Enter Phone Number" name="phone_no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Aadhar No</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="Enter Aadhar Number" name="aardhar_no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Enter Password</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="password" class="form-control" placeholder="Enter password" name="password" onkeypress="return AvoidSpace(event)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Confirm Password</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="password" class="form-control" placeholder="Confirm password" name="confirm_password" onkeypress="return AvoidSpace(event)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-lg-7 offset-lg-5">
                                        <div class="form-group mt-2">
                                            <button type="submit" class="btn btn-lg btn-primary">Save</button><br><br><br>
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
    <script>
    $(document).ready(function(){
    $(".vibhag").change(function(){
        $(this).find("option:selected").each(function(){
            var optionValue = $(this).attr("value");
            var allDepartmentIds = new Array();

            allDepartmentIds.push('InitializingElement');
            <?php foreach($allDepartmentIds as $key => $val){ ?>
                allDepartmentIds.push('<?php echo $val; ?>');
            <?php } ?>

            if(jQuery.inArray(optionValue,allDepartmentIds) > 0){ 
              
                $(".box").show();
            } else{
                $(".box").hide();
            }
        });
    }).change();
});
    
    
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>
</html>