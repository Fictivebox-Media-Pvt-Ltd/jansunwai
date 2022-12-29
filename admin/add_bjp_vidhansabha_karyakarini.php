<?php

include_once '../configs/includes.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    $admin_dir_name = dirname($_SERVER['PHP_SELF']);
    $user_id = $_SESSION['user_id'];
    $loginUserData = get_user_details($conn, $user_id);
    $adminName = $loginUserData['f_name'] . ' ' . $loginUserData['l_name'];
    $fName = $loginUserData['f_name'];
    $lName = $loginUserData['l_name'];
    $adminImage = $loginUserData['user_image'];
    $deptId = $loginUserData['department_id'];
    $adminEmail = $loginUserData['email'];
    $userName = $loginUserData['username'];
    $deptName = get_department_details($conn, $deptId);
}

if ((isset($_POST['assembly']) && isset($_POST['name']) && isset($_POST['phone']) && isset($_POST['vidhansabha_DOB']))) {
    add_bjp_vidhansabha_karyakarini($conn, $_POST['assembly'], $_POST['name'], $_POST['phone'], $_POST['vidhansabha_DOB']);
}

if (isset($_POST["import"])) {
    require_once('vendor/excel_reader2.php');
    require_once('vendor/SpreadsheetReader.php');
    $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {
        $targetPath = 'doc/' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $query = "INSERT INTO `bjp_vidhansabha_karyakarini` (`assembly`,`name`, `phone_no`,`dob`) VALUES";
        $sub_query = "";
        $Reader = new SpreadsheetReader($targetPath);
        $Reader->ChangeSheet(0);

        foreach ($Reader as $Row) {
            if ($counter >= $skipRows) {
                $assembly = ''; // Last Name
                if (isset($Row[$skipColumns + 0])) {
                    $assembly = $Row[$skipColumns + 0];
                }
                $name = ''; // Last Name
                if (isset($Row[$skipColumns + 1])) {
                    $name = $Row[$skipColumns + 1];
                }
                $phone_no = ''; // First Name
                if (isset($Row[$skipColumns + 2])) {
                    $phone_no = $Row[$skipColumns + 2];
                }
                $dob = NULL; // DOB
                if (isset($Row[$skipColumns + 3]) && $Row[$skipColumns + 3] != '') {
                    $dob = $Row[$skipColumns + 3];
                    $dob = strtotime($dob);
                    $dob = date('Y-m-d', $dob);
                }

                if ($assembly) {
                    $sub_query = $sub_query . " ('$assembly','$name','$phone_no','$dob')\n,";
                }
            }
            $counter++;
        }
        $query = $query . $sub_query;

        $query = substr($query, 0, -1) . ';';
        // $file = fopen('bulkupload/bulk_upload.sql','w');
        // fwrite($file,$query);
        // asd($query);
        // die;
        mysqli_set_charset($conn, 'utf8');
        $result = mysqli_query($conn, $query);

        unlink($targetPath);
    }
}
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
                                <h5 class="card-title">Bulk Upload</h5>
                            </div>
                            <form method="POST" enctype="multipart/form-data" class="gy-3 form-validate">

                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Upload XLSX</label>
                                            <span class="form-note">Upload the XLSX file having records within the total of 10,000.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <div class="custom-file">
                                                    <input type="file" class="custom-file-input" id="customFile" name="file" accept=".xlsx">
                                                    <label class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                        </div>
                        <div class="row g-3">
                            <div class="col-lg-7 offset-lg-5">
                                <div class="form-group mt-2 mb-5">
                                    <button name="import" type="submit" class="btn btn-lg btn-primary">Upload</button>
                                    <a href="" download="" class="btn btn-lg btn-info"> Download Sample File</a>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

                <div class="nk-block nk-block-lg">
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Add Vidhansabha Karyakarini </h5>
                            </div>
                            <form method="POST" enctype="multipart/form-data" class="gy-3 form-validate">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Assembly</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" placeholder="Enter assembly" name="assembly" onkeypress="return AvoidSpace(event)">
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
                                                <input type="text" class="form-control" placeholder="Enter name" name="name" onkeypress="return AvoidSpace(event)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Phone No.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" placeholder="Enter Phone No." name="phone" required>
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
                                                <input style="max-height: 35px;" type="text" name="vidhansabha_DOB" placeholder="Enter birthday date" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress" id="outlined-date-picker" required data-date-format="yyyy-mm-dd">
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