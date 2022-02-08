<?php
include_once '../configs/includes.php';

$start_date = NULL;
$end_date = NULL;
if(isset($_GET['date_range'])){
    $start_date = $_GET['start_date'];
    $end_date = $_GET['end_date'];
}else{
    $start_date = date("Y-m-d", strtotime("-8 days"));
    $end_date = date("Y-m-d");
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT department_id,f_name,l_name,user_image FROM tbl_admin_users WHERE id=$user_id";
    $loginUserData = get_user_details($conn, $user_id);
    $adminName = $loginUserData['f_name'] . ' ' . $loginUserData['l_name'];
    $adminImage = $loginUserData['user_image'];
    $deptId = $loginUserData['department_id'];
    $adminEmail = $loginUserData['email'];
    $deptName = get_department_details($conn, $deptId);
    $assignedLoksabha = $loginUserData['assigned_loksabha'];
    $surveyers_stats = get_surveyers_stats($conn,$assignedLoksabha,$start_date,$end_date);
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
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                               <div class="nk-block nk-block-lg">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title" style="margin-top: 50px;">Surveyer's Stats</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                        <form method="GET" class="form-validate">
                                        <div class="row g-3">
                                            <div class="col-lg-3">
                                                <div class="form-group" style="text-align: right;">
                                                    <label class="form-label" style="padding-top: 5px;font-size: 17px;">Date Range:</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input style="max-height: 35px;" value="<?php echo $start_date?>" type="text" name="start_date" placeholder="Select Start Date" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress" required data-date-format="yyyy-mm-dd">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input style="max-height: 35px;" value="<?php echo $end_date?>" type="text" name="end_date" placeholder="Select End Date" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress" required data-date-format="yyyy-mm-dd">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-lg-1 offset-lg-1">
                                                        <button type="submit" name="date_range" value="applied" class="btn btn-dim btn-success">Apply</button>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-lg-1 offset-lg-1">
                                                <a href="surveyers_stats.php" class="btn btn-dim btn-warning">Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                        </div>
                                        <div class="card card-preview">
                                            <div class="card-inner">
                                                <table class="table" id="karyakartas">
                                                <thead>
                                                        <tr>
                                                            <th style="text-align-last: center;">S. No.</th>
                                                            <th style="text-align-last: center;">Surveyed By</th>
                                                            <th style="text-align-last: center;">Total Survey's</th>  
                                                            <th style="text-align-last: center;">First Surveyed At</th>      
                                                            <th style="text-align-last: center;">Last Surveyed At</th>                                                       
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $i = 1;
                                                        foreach ($surveyers_stats as $key => $value) {
                                                    ?>
                                                        <tr>
                                                            <td style="text-align-last: center;"><?php echo $i ?></td>
                                                            <td style="text-align-last: center;"><?php echo $value['surveyed_by']; ?></td>
                                                            <td style="text-align-last: center;"><?php echo $value['total_surveys']; ?></td>
                                                            <td style="text-align-last: center;"><?php echo $value['first_surveyed_at']; ?></td>
                                                            <td style="text-align-last: center;"><?php echo $value['last_surveyed_at']; ?></td>
                                                        </tr>
                                                        <?php $i++;} ?>   
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!-- .card-preview -->
                                    </div> <!-- nk-block -->
                                <figure class="highcharts-figure">
                                    <div id="container"></div>
                                </figure>
                            </div>
                        </div>
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
    <script>
            $(document).ready(function() {
                    NioApp.DataTable('#karyakartas', {
                        "paging":true,
                        "processing":true,
                        "serverSide":false,
                        "order": [],
                        "info":true,
                        
                        "columnDefs":[
                                        {
                                            "targets":[],
                                            "orderable":false,
                                        },
                                    ],
                        responsive: {
                            details: true
                        }
                    });
            });
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>
</html>