<?php
include_once '../configs/includes.php';

if(isset($_GET['del'])){
    hard_delete($conn,$_GET['del'],'bjym_shakti_kendra');
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

$bjp_worker_details = get_bjym_shakti_kendra($conn,NULL);

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
                                                <h4 class="nk-block-title" style="margin-top: 50px;">BJYM Shakti Kendra</h4>

                                            </div>
                                        </div>
                                        <form action="bjym_jila_karyakarini_sms.php" method="post">
                                            <div style="text-align:right;">
                                                <a href="add_bjym_shakti_kendra.php" class="btn btn-outline-warning btn-tooltip" title="Click to add new records"><em class="icon ni ni-users"></em>&nbsp;Add New</a>
                                                    <button type="submit" name="submit" class="btn btn-outline-info btn-tooltip" title="Click to send an SMS"><em class="icon ni ni-emails"></em>&nbsp;Send SMS</button>
                                                    <select name="sms" class="btn btn-outline-info btn-tooltip text-left">
                                                     <option>--Send SMS--</option>
                                                    <?php
                                                        foreach ($sms as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value['sms']; ?>"><?php echo $value['sms_type']; ?></option>
                                                    <?php } ?>
                                                   </select>
                                                    <button href="#" class="btn btn-outline-success ivr-call-success btn-tooltip" title="Click to initiate IVR call"><em class="icon ni ni-call-alt"></em>&nbsp;Initiate IVR Call</button>
                                                </div>
                                        <div class="card card-preview" style="width: max-content;">
                                            <div class="card-inner">
                                            <table class="table" id="karyakartas">
                                                    <thead>
                                                        <tr>
                                                        <th>डाटा क्रम</th>
                                                        <th>क्रम</th>
                                                            <th>विधानसभा</th>
                                                            <th>मण्डल</th>
                                                            <th>शक्ति केन्द्र का नाम </th>
                                                            <th>प्रभारी</th>
                                                            <th>प्रभारी दुरभाष</th>
                                                            <th>संयोजक</th>
                                                            <th>संयोजक दुरभाष</th>
                                                            <th>सह संयोजक </th>
                                                            <th>सह संयोजक दुरभाष </th>
                                                            <th>कब से</th>
                                                            <th>कब तक</th>
                                                            <th>जन्म तिथि </th>                                                            
                                                            <th>status</th>
                                                            <th style="text-align: center;">Action</th>
                                                            <th>
                                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" name='select_all' data-child="chk2" class="custom-control-input" id="selectAllMembers">
                                                                    <label class="custom-control-label" for="selectAllMembers"></label>
                                                                </div>
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $i = 1;
                                                        foreach ($bjp_worker_details as $key => $value) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $value['kram']; ?></td>
                                                            <td><?php echo $value['assembly']; ?></td>
                                                            <td><?php echo $value['mandal']; ?></td>
                                                            <td><?php echo $value['shakti_kendra_name']; ?></td>
                                                            <td><?php echo $value['prabhari']; ?></td>
                                                            <td><?php echo $value['prabhari_phone_no']; ?></td>
                                                            <td><?php echo $value['sanyojak']; ?></td>
                                                            <td><?php echo $value['sanyojak_phone_no']; ?></td>
                                                            <td><?php echo $value['co_sanyojak']; ?></td>
                                                            <td><?php echo $value['co_sanyojak_phone_no']; ?></td>
                                                            <td><?php echo $value['kab_se']; ?></td>
                                                            <td><?php echo $value['kab_tak']; ?></td>
                                                            <td><?php echo $value['dob']; ?></td>
                                                            <td><?php echo $value['status']; ?></td>
                                                            <td>
                                                                <!-- <a href="<?php // echo "edit_worker.php?id=".$value['id'];?>" class="btn btn-icon btn-trigger btn-tooltip" title="Edit details"><em class="icon ni ni-edit"></em></a> -->
                                                                <a href="<?php  echo "?del=".$value['id'] ?>" class="btn btn-icon btn-trigger btn-tooltip" title="Delete this member"><em class="icon ni ni-trash"></em></a>
                                                                <a href="<?php echo "edit_bjym_shakti_kendra.php?id=".$value['id'];?>" class="btn btn-icon btn-trigger btn-tooltip" title="Edit this member"><em class="icon ni ni-edit"></em></a>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" class="custom-control-input chk2" name="mobile[]" id="<?php echo $value['id'] ?>" value="<?php echo $value['prabhari_phone_no'] ?>" >
                                                                    <label class="custom-control-label" for="<?php echo $value['id'] ?>"></label>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php $i++;} ?>   
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!-- .card-preview -->
                                        </form>
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
        $('#selectAllMembers').on('click', function() {
            var childClass = $(this).attr('data-child');
            $('.' + childClass + '').prop('checked', this.checked);
        });
                $(document).ready(function() {
                    NioApp.DataTable('#karyakartas', {
                        "paging":true,
                        "processing":true,
                        "serverSide":false,
                        "order": [],
                        "info":true,
                        
                        "columnDefs":[
                                        {
                                            "targets":[3,4,5,6,7,8,9,10,11,12,13],
                                            "orderable":false,
                                        },
                                    ],
                        responsive: {
                            details: true
                        }
                    });
                    $('.sms-success').on("click", function(e){
                        Swal.fire(
                            "SMS Sent Successfully!", 
                            "", 
                            "success"
                        );
                        e.preventDefault();
                    });

                    $('.ivr-call-success').on("click", function(e){
                        Swal.fire(
                            "Inititated IVR Call Successfully!", 
                            "", 
                            "success"
                        );
                        e.preventDefault();
                    });

                    var checkBoxes = $('.custom-control-input');
                    checkBoxes.change(function () {
                        $('.btn').prop('disabled', checkBoxes.filter(':checked').length < 1);
                    });
                    $('.custom-control-input').change();
            });
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>
</html>