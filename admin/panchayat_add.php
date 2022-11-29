<?php
include_once '../configs/includes.php';
if(isset($_POST['selected_Mandal']) && isset($_POST['panchayat_name'])&& isset($_POST['Booth_Range_name'])){
    addPanchayat($conn,$_POST['selected_Mandal'],$_POST['panchayat_name'],$_POST['Booth_Range_name']);
}

if (isset($_GET['del'])) {
    deletePanchayat($conn, $_GET['del']);
}


if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT department_id,f_name,l_name,user_image FROM tbl_admin_users WHERE id=$user_id";
    $loginUserData = get_user_details($conn, $user_id);
    $adminName = $loginUserData['f_name'] . ' ' . $loginUserData['l_name'];
    $adminImage = $loginUserData['user_image'];
    $email = $loginUserData['email'];
    $deptId = $loginUserData['department_id'];
    $assignedLoksabha = $loginUserData['assigned_loksabha'];
    $deptName = get_department_details($conn, $deptId);
}
$allMandal = array();
$allMandal = getAllMandal($conn);
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
                <div class="nk-content " style="margin-top: 50px;">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block nk-block-lg">
                                    <div class="nk-block-head">
                                        <div class="nk-block-head-content">
                                            <h4 class="nk-block-title">Add Panchayat</h4>
                                        </div>
                                    </div>
                                    <div class="card card-preview w-100" style="width: max-content;">
                                        <div class="card-inner">
                                        <form method="POST" class="gy-3">
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Mandal</label>
                                                        <select name="selected_Mandal" class="form-control">
                                                    <?php foreach($allMandal as $key => $value){?>
                                                        <option value="" selected disabled hidden>Choose here</option>
                                                        <option value="<?php echo $value['mandal']; ?>"><?php echo $value['mandal']; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Panchayat</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Panchayat Name" name="panchayat_name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="form-label">Booth Range</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Enter Booth Range" name="Booth_Range_name">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 align-self-end">
                                                    <button name="import" type="submit"
                                                        class="btn btn-lg btn-primary">Submit</button>
                                                </div>
                                            </div>
                                            </form>
                                            <div class="row">
                                            <div class="col-md-12 mt-4">
                                                    <table class="table" id="panchayatList">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Mandal</th>
                                                                <th>Panchayat</th>
                                                                <th>Booth Range</th>
                                                                <th>Action</th>
                                                               
                                                            </tr>
                                                        </thead>                                                   
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- .card-preview -->
                                </div> <!-- nk-block -->
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
                    NioApp.DataTable('#panchayatList', {
                        "paging":true,
                        "processing":true,
                        "serverSide":true,
                        "order": [],
                        "info":true,
                        "ajax":{
                            url:"service_fetchPanchayat.php",
                            type:"POST"
                            },
                        "ordering": false,
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