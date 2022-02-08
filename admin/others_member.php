<?php
include_once '../configs/includes.php';

if(isset($_GET['del'])){
    delete_others_member($conn,$_GET['del']);
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

$asha_worker_details = get_others_member($conn,NULL);
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
                                                <h4 class="nk-block-title" style="margin-top: 50px;">Other Members</h4>
                                                <div style="text-align:right;">
                                                <a href="add_others_member.php" class="btn btn-outline-warning btn-tooltip" title="Click to add new records"><em class="icon ni ni-users"></em>&nbsp;Add New</a>
                                                    <button href="#" class="btn btn-outline-info sms-success btn-tooltip" title="Click to send an SMS"><em class="icon ni ni-emails"></em>&nbsp;Send SMS</button>
                                                    <button href="#" class="btn btn-outline-success ivr-call-success btn-tooltip" title="Click to initiate IVR call"><em class="icon ni ni-call-alt"></em>&nbsp;Initiate IVR Call</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card card-preview" style="width: max-content">
                                            <div class="card-inner">
                                                <table class="table" id="karyakartas">
                                                    <thead>
                                                        <tr>
                                                        <th >क्र.स.</th>
                                                            <th >लोकसभा</th>
                                                            <th >विधानसभा</th>
                                                            <th >मण्डल</th>
                                                            <th >पंचायत</th>
                                                            <th >बूथ</th>
                                                            <th >नाम</th>
                                                            <th >पिता का नाम</th>
                                                            <th >आयु</th>
                                                            <th >सामाजिक वर्ग</th>
                                                            <th >मोबाइल</th>
                                                            <th >न्यूज़ पेपर / चैनल</th>
                                                            <th >पुरा पता</th>
                                                            <th >जन्म तिथि</th>
                                                            <th >Action</th>
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
                                                        foreach ($asha_worker_details as $key => $value) {
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $i ?></td>
                                                            <td><?php echo $value['loksabha']; ?></td>
                                                            <td><?php echo $value['vidhansabha']; ?></td>
                                                            <td><?php echo $value['mandal']; ?></td>
                                                            <td><?php echo $value['panchayat']; ?></td>
                                                            <td><?php echo $value['booth']; ?></td>
                                                            <td><?php echo $value['name']; ?></td>
                                                            <td><?php echo $value['fathers_name']; ?></td>
                                                            <td><?php echo $value['age']; ?></td>
                                                            <td><?php echo $value['caste']; ?></td>
                                                            <td><?php echo $value['mobile']; ?></td>
                                                            <td><?php echo $value['news_paper_channel']; ?></td>
                                                            <td><?php echo $value['address']; ?></td>
                                                            <td><?php echo $value['dob']; ?></td>
                                                            <td>
                                                                <a href="<?php echo "?del=".$value['id'] ?>" class="btn btn-icon btn-trigger btn-tooltip" title="Delete this member"><em class="icon ni ni-trash"></em></a>
                                                            </td>
                                                            <td>
                                                                <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" class="custom-control-input chk2" name="check[]" id="<?php echo $value['id'] ?>" value="<?php echo $value['id'] ?>" >
                                                                    <label class="custom-control-label" for="<?php echo $value['id'] ?>"></label>
                                                                </div>
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
                                            "targets":[1,2,3,4,6,7,9,11,12,14,15],
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