<?php
include_once '../configs/includes.php';

if (isset($_GET['del'])) {
    delete_mandal_panchayat_datasets($conn, $_GET['del']);
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

$datasets = get_mandal_panchayat_datasets($conn,$assignedLoksabha);

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
                                                <h4 class="nk-block-title">Mandal's & Panchayat's</h4>
                                            </div>
                                        </div>
                                        <div class="card card-preview" style="width: max-content;">
                                            <div class="card-inner">
                                                <table class="table" id="mandal_datasets">
                                                    <thead>
                                                        <tr>
                                                        <th>क्र. स.</th>
                                                        <th>लोकसभा</th>
                                                        <th>विधानसभा</th>
                                                        <th>मंडल</th>
                                                        <th>पंचायत</th>
                                                        <th>बूथ रेंज</th>
                                                        <th>Trash</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $i = 1;
                                                        foreach ($datasets as $key => $value) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $value['loksabha']; ?></td>
                                                            <td><?php echo $value['vidhansabha']; ?></td>
                                                            <td><?php echo $value['mandal']; ?></td>
                                                            <td><?php echo $value['panchayat']; ?></td>
                                                            <td><?php echo $value['booth_range']; ?></td>
                                                            <td>
                                                                <a href="<?php echo "?del=".$value['id'] ?>" class="btn btn-icon btn-trigger btn-tooltip" title="Delete this entry!"><em class="icon ni ni-trash"></em></a>
                                                            </td>
                                                        </tr>
                                                        <?php $i++;} ?>   
                                                    </tbody>
                                                </table>
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
                    NioApp.DataTable('#mandal_datasets', {
                        "paging":true,
                        "processing":true,
                        "serverSide":false,
                        "order": [],
                        "info":true,
                        "columnDefs":[
                                        {
                                            "targets":[6],
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