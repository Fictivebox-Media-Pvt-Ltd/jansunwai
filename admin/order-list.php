<?php
include_once '../configs/includes.php';
if (isset($_GET['del'])) {
    delete_governance_order($conn, $_GET['del']);
}
if (isset($_GET['approve'])) {
    approve_governance_order($conn, $_GET['approve']);
}
if (isset($_GET['discard'])) {
    discard_governance_order($conn, $_GET['discard']);
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
    $deptName = get_department_details($conn, $deptId);
    $email = $loginUserData['email'];
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
                    <div class="nk-content" style="margin-top: 50px;">
                        <div class="container-fluid">
                            <div class="nk-content-inner">
                                <div class="nk-content-body">
                                    <div class="nk-block nk-block-lg">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title">Notices</h4>

                                            </div>
                                        </div>
                                        <div class="card card-preview" style="<?php if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) echo 'width: max-content;'?>">
                                            <div class="card-inner">
                                                <table class="table" id="notices">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:100px;">S. No.</th>
                                                            <th style="width:140px; text-align:center;">Date</th>
                                                            <th>Notice</th>
                                                            <th style="width:155px; text-align:center;">Action</th>

                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div><!-- .card-preview -->
                                    </div> <!-- nk-block -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- content @e -->
                    <!-- footer @s -->
                    <?php include_once 'footer.php' ?>
                    <!-- footer @e -->
                </div>
                <!-- wrap @e -->
            </div>
            <!-- main @e -->
        </div>
        <!-- app-root @e -->
        <!-- JavaScript -->
        <script>
            $(document).ready(function() {
                    NioApp.DataTable('#notices', {
                        "paging":true,
                        "processing":true,
                        "serverSide":true,
                        "order": [],
                        "info":true,
                        "ajax":{
                            url:"service_for_notices.php",
                            type:"POST"
                            },
                        "columnDefs":[
                                        {
                                            "targets":[0,3],
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