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

if(isset($_POST['file_id'])){
    $file_id = $_POST['file_id'];
    $loksabha = isset($_POST['loksabha']) ? $_POST['loksabha'] : '';
    $vidhansabha = isset($_POST['vidhansabha']) ? $_POST['vidhansabha'] : '';
    $booth_no = isset($_POST['booth_no']) ? $_POST['booth_no'] : '';
    $house_no = isset($_POST['house_no']) ? $_POST['house_no'] : '';
    $voter_name_hin = isset($_POST['voter_name_hin']) ? $_POST['voter_name_hin'] : '';
    $voter_age = isset($_POST['voter_age']) ? $_POST['voter_age'] : '';
    $father_husband_name_hin = isset($_POST['father_husband_name_hin']) ? $_POST['father_husband_name_hin'] : '';
    $gender_hin = isset($_POST['gender_hin']) ? $_POST['gender_hin'] : '';
    $ward_hin = isset($_POST['ward_hin']) ? $_POST['ward_hin'] : '';
    $cast_hin = isset($_POST['cast_hin']) ? $_POST['cast_hin'] : '';
    $phone_no = isset($_POST['phone_no']) ? $_POST['phone_no'] : '';
    $pesha_hin = isset($_POST['pesha_hin']) ? $_POST['pesha_hin'] : '';
    $voter_name_en = isset($_POST['voter_name_en']) ? $_POST['voter_name_en'] : '';
    $father_husband_name_en = isset($_POST['father_husband_name_en']) ? $_POST['father_husband_name_en'] : '';
    $gender_en = isset($_POST['gender_en']) ? $_POST['gender_en'] : '';
    $ward_en = isset($_POST['ward_en']) ? $_POST['ward_en'] : '';
    $cast_en = isset($_POST['cast_en']) ? $_POST['cast_en'] : '';
    $pesha_en = isset($_POST['pesha_en']) ? $_POST['pesha_en'] : '';

    add_single_voter($conn,$file_id,$loksabha,$vidhansabha,$booth_no,$house_no,$voter_name_hin,$voter_age,$father_husband_name_hin,$gender_hin,$ward_hin,$cast_hin,$phone_no,$pesha_hin,$voter_name_en,$father_husband_name_en,$gender_en,$ward_en,$cast_en,$pesha_en);
}

if (isset($_POST["import"]))
{ 
  require_once('vendor/excel_reader2.php');
  require_once('vendor/SpreadsheetReader.php');    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){
        $targetPath = 'doc/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $query = "INSERT INTO `tbl_voters` (`file_id`, `loksabha`, `vidhansabha`, `booth_no`, `section_no`, `house_no`, `voter_name_hin`, `voter_age`, `father_husband_name_hin`, `sambandh`, `gender_hin`, `ward_hin`, `id_no`, `poling_station_hin`, `poling_station_en`, `voter_name_en`, `father_husband_name_en`, `gender_en`, `ward_en`) VALUES";
        $sub_query = "";
        $Reader = new SpreadsheetReader($targetPath);
        $Reader->ChangeSheet(0);   

        foreach ($Reader as $Row){       
            if($counter >= $skipRows){

                $file_id = ''; 
                if(isset($Row[$skipColumns+0])) {
                    $file_id = $Row[$skipColumns+0];
                }
                
                $loksabha = ''; 
                if(isset($Row[$skipColumns+1])) {
                    $loksabha = $Row[$skipColumns+1];
                }

                $vidhansabha = ''; 
                if(isset($Row[$skipColumns+2])) {
                    $vidhansabha = $Row[$skipColumns+2];
                }

                $booth_no= ''; 
                if(isset($Row[$skipColumns+3])) {
                    $booth_no = $Row[$skipColumns+3];
                }

                $section_no= ''; 
                if(isset($Row[$skipColumns+4])) {
                    $section_no = $Row[$skipColumns+4];
                }

                $house_no = '';
                if(isset($Row[$skipColumns+5])) {
                    $house_no = $Row[$skipColumns+5];
                }

                $voter_name_hin = ''; 
                if(isset($Row[$skipColumns+6])) {
                    $voter_name_hin = $Row[$skipColumns+6];
                }  

                $voter_age = ''; 
                if(isset($Row[$skipColumns+7])) {
                    $voter_age = $Row[$skipColumns+7];
                }  

                $father_husband_name_hin = ''; 
                if(isset($Row[$skipColumns+8])) {
                    $father_husband_name_hin = $Row[$skipColumns+8];
                }  

                $sambandh = ''; 
                if(isset($Row[$skipColumns+9])) {
                    $sambandh = $Row[$skipColumns+9];
                } 

                $gender_hin = ''; 
                if(isset($Row[$skipColumns+10])) {
                    $gender_hin = $Row[$skipColumns+10];
                } 
                
                $ward_hin = ''; 
                if(isset($Row[$skipColumns+11])) {
                    $ward_hin = $Row[$skipColumns+11];
                } 

                $id_no = ''; 
                if(isset($Row[$skipColumns+12])) {
                    $id_no = $Row[$skipColumns+12];
                } 

                $poling_station_hin = ''; 
                if(isset($Row[$skipColumns+13])) {
                    $poling_station_hin = $Row[$skipColumns+13];
                } 

                $poling_station_en = ''; 
                if(isset($Row[$skipColumns+14])) {
                    $poling_station_en = $Row[$skipColumns+14];
                } 

                $voter_name_en = ''; 
                if(isset($Row[$skipColumns+15])) {
                    $voter_name_en = $Row[$skipColumns+15];
                }  

                $father_husband_name_en = ''; 
                if(isset($Row[$skipColumns+16])) {
                    $father_husband_name_en = $Row[$skipColumns+16];
                }  

                $gender_en = ''; 
                if(isset($Row[$skipColumns+17])) {
                    $gender_en = $Row[$skipColumns+17];
                } 
                
                $ward_en = ''; 
                if(isset($Row[$skipColumns+18])) {
                    $ward_en = $Row[$skipColumns+18];
                } 

                $sub_query = $sub_query." ('$file_id','$loksabha','$vidhansabha','$booth_no','$section_no','$house_no','$voter_name_hin','$voter_age','$father_husband_name_hin','$sambandh','$gender_hin','$ward_hin','$id_no','$poling_station_hin','$poling_station_en','$voter_name_en','$father_husband_name_en','$gender_en','$ward_en')\n,";
            }
            $counter++;
        }
        $query = $query.$sub_query;
        $query = substr($query, 0, -1).';';
        $file = fopen('bulkupload/bulk_upload.sql','w');
        // fwrite($file,$query);
        // mysqli_set_charset($conn,'utf8');
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
                                        <div class="form-group mt-2">
                                            <button name="import" type="submit" class="btn btn-lg btn-primary">Upload</button>
                                            <a href="./SampleFiles/Voter_list_sample.xlsx" download="proposed_file_name" class="btn btn-lg btn-info"> Download Sample File</a><br><br><br>
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
                                <h5 class="card-title">Add New Voter</h5>
                            </div>
                            <form method="POST" enctype="multipart/form-data" class="gy-3 form-validate">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">File ID</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter File ID" name="file_id" onkeypress="return AvoidSpace(event)" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Loksabha</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter Loksabha" name="loksabha">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Vidhansabha</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter Vidhansabha" name="vidhansabha">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Booth No.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="Enter Booth Number" name="booth_no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">House No.</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="Enter House Number" name="house_no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Voter Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter Voter Name" name="voter_name_en">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Voter Age</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="number" class="form-control" placeholder="Enter Voter Age" name="voter_age">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Father/Husband Name</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter Father/Husband Name" name="father_husband_name_en">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Gender</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter Gender" name="gender_en">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Ward</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter Ward" name="ward_hin">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Cast</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter Cast" name="cast_en">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                                <!-- <div class="row g-3 align-center">
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
                                </div> -->
                                <!-- <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">Pesha</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                            <input type="text" class="form-control" placeholder="Enter Pesha" name="pesha_en">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
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