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

if ((isset($_POST['district']) && isset($_POST['designation']) && isset($_POST['name']) && isset($_POST['father_name']) && isset($_POST['age']) && isset($_POST['cast']) && isset($_POST['phone_no']) && isset($_POST['address']) && isset($_POST['active_membership_number']) && isset($_POST['previous_designation']) && isset($_POST['nivasi_mandal']) && isset($_POST['karyakarini_DOB']))) {
    add_bjp_jila_karyakarini($conn, $_POST['district'], $_POST['designation'], $_POST['name'], $_POST['father_name'], $_POST['age'], $_POST['cast'], $_POST['phone_no'], $_POST['address'], $_POST['active_membership_number'], $_POST['previous_designation'], $_POST['nivasi_mandal'], $_POST['karyakarini_DOB']);
    header("Location: bjp_jila_karyakarini.php");
}

if (isset($_POST["import"])) {
    require_once('vendor/excel_reader2.php');
    require_once('vendor/SpreadsheetReader.php');
    $allowedFileType = ['application/vnd.ms-excel', 'text/xls', 'text/xlsx', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];

    if (in_array($_FILES["file"]["type"], $allowedFileType)) {
        $targetPath = 'doc/' . $_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $query = "INSERT INTO `bjp_jila_karyakarini` (`district`,`designation`, `name`, `father_name`, `age`, `cast`, `phone_no`, `address`,`active_membership_number`,`previous_designation`,`nivasi_mandal`,`dob`) VALUES";
        $sub_query = "";
        $Reader = new SpreadsheetReader($targetPath);
        $Reader->ChangeSheet(0);

        foreach ($Reader as $Row) {
            if ($counter >= $skipRows) {
                $district = ''; // First Name
                if (isset($Row[$skipColumns + 0])) {
                    $district = $Row[$skipColumns + 0];
                }
                $designation = ''; // First Name
                if (isset($Row[$skipColumns + 1])) {
                    $designation = $Row[$skipColumns + 1];
                }

                $name = ''; // Last Name
                if (isset($Row[$skipColumns + 2])) {
                    $name = $Row[$skipColumns + 2];
                }

                $father_name = NULL; // Aadhar No
                if (isset($Row[$skipColumns + 3])) {
                    $father_name = $Row[$skipColumns + 3];
                }

                $age = ""; // Email Id
                if (isset($Row[$skipColumns + 4])) {
                    $age = $Row[$skipColumns + 4];
                }

                $cast = ""; // Phone No
                if (isset($Row[$skipColumns + 5])) {
                    $cast = $Row[$skipColumns + 5];
                }

                $phone_no = ""; // Phone No
                if (isset($Row[$skipColumns + 6])) {
                    $phone_no = $Row[$skipColumns + 6];
                }
                $address = ""; // Phone No
                if (isset($Row[$skipColumns + 7])) {
                    $address = $Row[$skipColumns + 7];
                }

                $active_membership_number = ""; // Phone No
                if (isset($Row[$skipColumns + 8])) {
                    $active_membership_number = $Row[$skipColumns + 8];
                }
                $previous_designation = ""; // previous_designation
                if (isset($Row[$skipColumns + 9])) {
                    $previous_designation = $Row[$skipColumns + 9];
                }
                $nivasi_mandal = ""; // nivasi_mandal
                if (isset($Row[$skipColumns + 10])) {
                    $nivasi_mandal = $Row[$skipColumns + 10];
                }


                $dob = NULL; // DOB
                if (isset($Row[$skipColumns + 11]) && $Row[$skipColumns + 11] != '') {
                    $dob = $Row[$skipColumns + 11];
                    $dob = strtotime($dob);
                    $dob = date('Y-m-d', $dob);
                }
                if ($district) {
                    $sub_query = $sub_query . " ('$district','$designation','$name','$father_name','$age','$cast','$phone_no','$address','$active_membership_number','$previous_designation','$nivasi_mandal','$dob')\n,";
                }
            }
            $counter++;
        }
        $query = $query . $sub_query;

        $query = substr($query, 0, -1) . ';';

        // $file = fopen('bulkupload/bulk_upload.sql','w');
        // fwrite($file,$query);
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
                                <h5 class="card-title">Add Jila Karyakarini </h5>
                            </div>
                            <form method="POST" enctype="multipart/form-data" class="gy-3 form-validate">

                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">District</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" placeholder="Enter district" name="district" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Designation</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" placeholder="Enter designation" name="designation" required>
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
                                            <label class="form-label">Father Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" placeholder="Enter Father Name" name="father_name" required>
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
                                                <input type="number" class="form-control" placeholder="Enter age" name="age" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Cast</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" placeholder="Enter Cast" name="cast" required>
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
                                                <input type="number" class="form-control" placeholder="Enter Phone No." name="phone_no" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Address</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" placeholder="Enter Address" name="address" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Active Membership Number</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control" placeholder="Enter Active Membership Number" name="active_membership_number" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Previous Designation</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" placeholder="Enter Previous Designation" name="previous_designation" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Nivasi Mandal</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" placeholder="Enter Nivasi Mandal" name="nivasi_mandal" required>
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
                                                <input style="max-height: 35px;" type="text" name="karyakarini_DOB" placeholder="Enter birthday date" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress" id="outlined-date-picker" required data-date-format="yyyy-mm-dd">
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