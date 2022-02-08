<?php

include_once '../configs/includes.php';

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

if(( isset($_POST['loksabha']) && isset($_POST['vidhansabha']) && isset($_POST['mandal']) && isset($_POST['panchayat']) && isset($_POST['booth']) && isset($_POST['name']) && isset($_POST['fathers_name']) && isset($_POST['age']) && isset($_POST['caste']) && isset($_POST['mobile']) && isset($_POST['address']) && isset($_POST['dob']) && isset($_POST['kab_se']) && isset($_POST['kab_tak']) && isset($_POST['status']))){
        update_sarpanch_candidate($conn,$_GET['id'],$_POST['loksabha'],$_POST['vidhansabha'],$_POST['mandal'],$_POST['panchayat'],$_POST['booth'],$_POST['name'],$_POST['fathers_name'],$_POST['age'],$_POST['caste'],$_POST['mobile'],$_POST['address'],$_POST['dob'],$_POST['kab_se'],$_POST['kab_tak'],$_POST['status']);
        header("Location: sarpanch_candidate.php");
}

$details = get_sarpanch_candidate($conn,$_GET['id']);
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


                    <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Edit</h5>
                            </div>
                            <form method="POST" enctype="multipart/form-data" class="gy-3 form-validate">
                            <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Loksabha</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['loksabha']?>" type="text" class="form-control" placeholder="Enter assembly" name="loksabha" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Vidhansabh</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['vidhansabha']?>" type="text" class="form-control" placeholder="Enter name" name="vidhansabha" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Mandal</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['mandal']?>" type="text" class="form-control" placeholder="Enter name" name="mandal" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Panchayat</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['panchayat']?>" type="text" class="form-control" placeholder="Enter name" name="panchayat" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Booth</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['booth']?>" type="text" class="form-control" placeholder="Enter name" name="booth" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['name']?>" type="text" class="form-control" placeholder="Enter name" name="name" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Father's name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['fathers_name']?>" type="text" class="form-control" placeholder="Enter name" name="fathers_name" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Age</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['age']?>" type="number" class="form-control" placeholder="Enter name" name="age" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Caste</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['caste']?>" type="text" class="form-control" placeholder="Enter Phone No." name="caste"  required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Mobile</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['mobile']?>" type="number" class="form-control" placeholder="Enter Phone No." name="mobile"  required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                 <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Full Address</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['address']?>" type="text" class="form-control" placeholder="Enter name" name="address" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">From</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['kab_se']?>" style="max-height: 35px;" type="text" name="kab_se" placeholder="?? ??" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress" id="outlined-date-picker" required data-date-format="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">To</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input value="<?php echo $details['kab_tak']?>" style="max-height: 35px;" type="text" name="kab_tak" placeholder="?? ??" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress" id="outlined-date-picker" required data-date-format="yyyy-mm-dd">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Status</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <select class="form-control" name="status" id="status">
                                                <option selected><?php echo $details['status']?></option>
                                                <option value="Current">Current</option>
                                                <option value="Previous">Previous</option>
                                                <option value="Former">Former</option>
                                            </select>
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
                                            <input value="<?php echo $details['dob']?>" style="max-height: 35px;" type="text" name="dob" placeholder="Enter birthday date" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress" id="outlined-date-picker" required data-date-format="yyyy-mm-dd">
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
                    </div>





                    <!-- card -->
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