<?php
include_once '../configs/includes.php';


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
$all_loksabhas = array();
$all_loksabhas = get_all_loksabha($conn);

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
                                            <h4 class="nk-block-title">Add Vidhansabha</h4>
                                        </div>
                                    </div>
                                    <div class="card card-preview w-100" style="width: max-content;">
                                        <div class="card-inner">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Loksabha</label>
                                                        <select name="selected_loksabha" class="form-control">
                                                    <?php foreach($all_loksabhas as $key => $value){?>
                                                        <option value="" selected disabled hidden>Choose here</option>
                                                        <option value="<?php echo $value['loksabha']; ?>"><?php echo $value['loksabha']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="form-label">Vidhansabha</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Add Vidhansabha" name="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 align-self-end">
                                                    <button name="import" type="submit"
                                                        class="btn btn-lg btn-primary">Submit</button>
                                                </div>
                                                <div class="col-md-12 mt-4">
                                                    <table class="table" id="mandal_datasets">
                                                        <thead>
                                                            <tr>
                                                                <th>S.No.</th>
                                                                <th>Loksabha</th>
                                                                <th>Vidhansabha</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Data</td>
                                                                <td>Data</td>
                                                                <td>
                                                                    <a href="vidhansabha-edit.php"
                                                                        class="btn btn-icon btn-trigger btn-tooltip"
                                                                        title="Edit"><em
                                                                            class="icon ni ni-edit"></em></a>
                                                                    <a href="#!"
                                                                        class="btn btn-icon btn-trigger btn-tooltip"
                                                                        title="Delete"><em
                                                                            class="icon ni ni-trash"></em></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Data</td>
                                                                <td>Data</td>
                                                                <td>
                                                                    <a href="vidhansabha_edit.php"
                                                                        class="btn btn-icon btn-trigger btn-tooltip"
                                                                        title="Edit"><em
                                                                            class="icon ni ni-edit"></em></a>
                                                                    <a href="#!"
                                                                        class="btn btn-icon btn-trigger btn-tooltip"
                                                                        title="Delete"><em
                                                                            class="icon ni ni-trash"></em></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
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
        NioApp.DataTable('#mandal_datasets', {
            "paging": true,
            "processing": true,
            "serverSide": false,
            "order": [],
            "info": true,
            "columnDefs": [{
                "targets": [6],
                "orderable": false,
            }, ],
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