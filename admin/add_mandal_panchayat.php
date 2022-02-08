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

if (isset($_POST["import"]))
{ 
  require_once('vendor/excel_reader2.php');
  require_once('vendor/SpreadsheetReader.php');    
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){
        $targetPath = 'doc/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);

        $query = "INSERT INTO `tbl_mandal_panchayat_mapping` (`loksabha`, `vidhansabha`, `mandal`, `panchayat`, `booth_range`, `created_at`) VALUES";
        $sub_query = "";
        $Reader = new SpreadsheetReader($targetPath);
        $Reader->ChangeSheet(0);   

        foreach ($Reader as $Row){       
            if($counter >= $skipRows){

                $loksabha = ''; 
                if(isset($Row[$skipColumns+0])) {
                    $loksabha = $Row[$skipColumns+0];
                }
                
                $vidhansabha = ''; 
                if(isset($Row[$skipColumns+1])) {
                    $vidhansabha = $Row[$skipColumns+1];
                }

                $mandal = ''; 
                if(isset($Row[$skipColumns+2])) {
                    $mandal = $Row[$skipColumns+2];
                }

                $panchayat= ''; 
                if(isset($Row[$skipColumns+3])) {
                    $panchayat = $Row[$skipColumns+3];
                }

                $booth_range= ''; 
                if(isset($Row[$skipColumns+4])) {
                    $booth_range = $Row[$skipColumns+4];
                }

                $sub_query = $sub_query." ('$loksabha','$vidhansabha','$mandal','$panchayat','$booth_range',now())\n,";
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
                                            <button name="import" type="submit" class="btn btn-lg btn-primary">Upload</button><br><br><br>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                <!-- content @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
        <?php include_once 'footer.php'; ?>
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>
</html>