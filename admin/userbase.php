<?php
include_once '../configs/includes.php';

if (isset($_GET['del'])) {
    delete_voters_data($conn, $_GET['del']);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    $user_id = $_SESSION['user_id'];
    $assignedLoksabha = getLoksabhaOfLoggedInUser($conn,$user_id);
    $query = "SELECT department_id,f_name,l_name,user_image FROM tbl_admin_users WHERE id=$user_id";
    $loginUserData = get_user_details($conn, $user_id);
    $adminName = $loginUserData['f_name'] . ' ' . $loginUserData['l_name'];
    $adminImage = $loginUserData['user_image'];
    $email = $loginUserData['email'];
    $deptId = $loginUserData['department_id'];
    $assignedLoksabha = $loginUserData['assigned_loksabha'];
    $deptName = get_department_details($conn, $deptId);
}

    $booth_no = '';
    $selected_ward = '';
    $voter_name = '';

    if(isset($_GET['submit_booth']) && $_GET['booth_no']){
        $ward_list = get_wards_names($conn,$_GET['booth_no']);
    }else{
        $ward_list = array();
    }

    if(isset($_GET['booth_no'])){
        $booth_no = $_GET['booth_no'];
    }
    if(isset($_GET['selected_ward'])){
        $selected_ward = $_GET['selected_ward'];
    }
    if(isset($_GET['voter_name'])){
        $voter_name = $_GET['voter_name'];
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
                <div class="nk-content " style="margin-top: 50px;">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                               <div class="nk-block nk-block-lg">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title">Voter List</h4>
                                                <div class="col-md-12">
                                                    <form method="GET" class="form-validate">
                                                    <div class="row">
                                                        <div>
                                                            <div class="form-group">
                                                                <label class="form-label" style="padding-top: 5px;font-size: 17px;">Enter Booth No.</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-2">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" placeholder="Enter Booth No." value="<?php if(!empty($_GET['booth_no'])) echo $_GET['booth_no']?>" name="booth_no">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!-- <div>
                                                            <div class="form-group">
                                                                <label class="form-label" style="padding-top: 5px;font-size: 17px;">Select Ward</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <select name="selected_ward" class="form-control">
                                                                        <?php foreach($ward_list as $key => $value){?>
                                                                            <option value="" selected disabled hidden>Choose here</option>
                                                                            <?php if($selected_ward){?>
                                                                            <option selected value="<?php echo $selected_ward; ?>"><?php echo $selected_ward; ?></option>
                                                                            <?php } ?>
                                                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                        <!-- <div>
                                                            <div class="form-group">
                                                                <label class="form-label" style="padding-top: 5px;font-size: 17px;">Enter Name</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <input type="text" class="form-control" placeholder="Enter Voter Name" value="<?php if(!empty($_GET['voter_name'])) echo $_GET['voter_name']?>" name="voter_name">
                                                                </div>
                                                            </div>
                                                        </div> -->
                                                        <div class="row g-3">
                                                            <div class="col-lg-1 offset-lg-1">
                                                                    <button type="submit" name="submit_booth" value="applied" class="btn btn-dim btn-success">OK</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </form><br/>
                                                    <?php if($assignedLoksabha != 'मुंबई साउथ'){ ?>
                                                        <a href="surveyed_userbase.php" class="btn btn-dim btn-warning">Go to ↦ Surveyed Voters</a>
                                                    <?php } ?>
                                                </div>
                                                <!-- <div class="col-md-7">
                                                    <form method="GET" class="form-validate">
                                                    <div class="row g-3">
                                                        <div>
                                                            <div class="form-group">
                                                                <label class="form-label" style="padding-top: 5px;font-size: 17px;">Select Ward</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3">
                                                            <div class="form-group">
                                                                <div class="form-control-wrap">
                                                                    <select name="selected_ward" class="form-control">
                                                                        <?php foreach($ward_list as $key => $value){?>
                                                                            <option value="" selected disabled hidden>Choose here</option>
                                                                            <option value="<?php echo $value; ?>"><?php echo $value; ?></option>
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row g-3">
                                                            <div class="col-lg-1 offset-lg-1">
                                                                    <button type="submit" name="date_filter" value="applied" class="btn btn-dim btn-success">Apply</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </form>
                                                </div> -->
                                            </div>
                                        </div>
                                        <div class="card card-preview" style="width: max-content;">
                                            <div class="card-inner">
                                                <table class="table" id="voter-list">
                                                    <thead>
                                                        <tr>
                                                        <th style="width:80px;">S. No.</th>
                                                        <th>File ID</th>
                                                        <th>लोकसभा</th>
                                                        <th>विधानसभा</th>
                                                        <th>बूथ</th>
                                                        <th>सेक्शन सं</th>
                                                        <th>मकान सं</th>
                                                        <th>नाम</th>
                                                        <th>उम</th>
                                                        <th>पिता / पति का नाम</th>
                                                        <th>सम्बन्ध</th>
                                                        <th>लिंग</th>
                                                        <th>वार्ड</th>
                                                        <th>आई डी क्रमांक</th>
                                                        <th>पोलिंग स्टेशन का नाम</th>
                                                        <th>Poling Station Name</th>
                                                        <th>Name</th>
                                                        <th>Father / Husband Name</th>
                                                        <th>Gender</th>
                                                        <th>Ward</th>
                                                        <th>Trash</th>
                                                    <?php if($assignedLoksabha != 'मुंबई साउथ'){?>    
                                                        <th style="text-align: center;">Action</th>
                                                    <?php if(strtolower($deptName) != 'field worker department'){?>
                                                        <th>पेशा</th>
                                                        <th>मोबाइल न०</th>
                                                        <th>व्हाट्सएप्प न०</th>
                                                        <th>प्रमुख मुद्दे</th>
                                                        <th>Rating Current Govt</th>
                                                        <th>Voted in 2019 लोकसभा</th>
                                                        <th>Voted in 2018 विधानसभा</th>
                                                        <th>2018 (पार्टी/सदस्य)</th>
                                                        <th>विचारधारा</th>
                                                        <th>कोरोना</th>
                                                        <th>लोकल कार्यकर्ता</th>
                                                        <th>2023 विधानसभा</th>
                                                        <th>जाति</th>
                                                        <th>श्रेणी</th>
                                                    <?php }
                                                    } ?>
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
                NioApp.DataTable('#voter-list', {
                    "lengthMenu": [100, 250, 500],
                    "searching": false,
                    "paging":true,
                    "processing":true,
                    "serverSide":true,
                    "order": [],
                    "info":true,
                    "ajax":{
                        url:"service_for_userbase.php?booth_no=<?php echo $booth_no?>&selected_ward=<?php echo $selected_ward?>&voter_name=<?php echo $voter_name?>&assignedLoksabha=<?php echo $assignedLoksabha ?>",
                        type:"POST"
                        },
                    "ordering": false,
                    // "columnDefs":[
                    //                 {
                    //                     "targets":[0,1,2,5,7,8,9,10,11,12,13,14,15,16,17,18,3,4,6,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33],
                    //                     "orderable":false,
                    //                 },
                    //             ],
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