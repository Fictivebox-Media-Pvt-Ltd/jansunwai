<?php
include_once '../configs/includes.php';

if(isset($_GET['del'])){
    hard_delete($conn,$_GET['del'],'sms');
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
}

$sms = get_sms($conn,NULL);
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
                                                <h4 class="nk-block-title" style="margin-top: 50px;">sms</h4>
                                                <div style="text-align:right;">
                                                <a href="add_sms.php" class="btn btn-outline-warning btn-tooltip" title="Click to add new records"><em class="icon ni ni-users"></em>&nbsp;Add New Template</a>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="card card-preview" style="<?php if(count($sms) != 0 && preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) echo 'width: max-content;'?>">
                                            <div class="card-inner">
                                                <table class="table" id="karyakartas">
                                                    <thead>
                                                        <tr>
                                                            <th>S.No.</th>
                                                            <th>SMS<span>&nbsp;</span>Type</th>
                                                            <th>SMS Template</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $i = 1;
                                                        foreach ($sms as $key => $value) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $value['sms_type']; ?></td>
                                                            <td><?php echo $value['sms']; ?></td>

                                                            <td>
                                                                <!-- <a href="<?php // echo "edit_worker.php?id=".$value['id'];?>" class="btn btn-icon btn-trigger btn-tooltip" title="Edit details"><em class="icon ni ni-edit"></em></a> -->
                                                                <a href="<?php echo "?del=".$value['id'] ?>" class="btn btn-icon btn-trigger btn-tooltip" title="Delete this member"><em class="icon ni ni-trash"></em></a>

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

    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>
</html>