<?php
include_once '../configs/includes.php';
include 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if(!empty($_POST['data_filter']) && isset($_POST['data_filter'])){
    $filter_mandal = $_POST['mandal'];
    $filter_panchayat = $_POST['panchayat'];
    $filter_boothRange = str_replace(' ', '', $_POST['boothRange']);
    $filter_category = $_POST['category'];
    $filter_caste = $_POST['caste'];
    $filter_pesha = $_POST['pesha'];
    $filter_pramukh_mudde = $_POST['pramukh_mudde'];
    $filter_mojuda_sarkaar = $_POST['mojuda_sarkaar'];
    $filter_2019_loksabha = $_POST['2019_loksabha'];
    $filter_2018_vidhansabha = $_POST['2018_vidhansabha'];
    $filter_partyVsCandidate = $_POST['partyVsCandidate'];
    $filter_vichardhara = $_POST['vichardhara'];
    $filter_corona = $_POST['corona'];
    $filter_local_candidate = $_POST['local_candidate'];
    $filter_2023_vidhansabha = $_POST['2023_vidhansabha'];
    $filter_ageGroup = $_POST['ageGroup'];
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
    $assignedVidhansabha = $loginUserData['assigned_vidhansabha'];
    $deptName = get_department_details($conn, $deptId);
}

// if($assignedVidhansabha != ''){
//     $assignedVidhansabha = $assignedVidhansabha;
// }else{
//     $assignedVidhansabha = 'वल्लभनगर';
// }

$mandal_list = get_mandal_list($conn,$assignedVidhansabha);
$category_list = get_category_list($conn);

$getFilterQuestionList = getFilterQuestionList($conn,$assignedVidhansabha);

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
    // echo count($getFilterQuestionList);
    // die;
$sms = get_sms($conn,NULL);
?>



<!DOCTYPE html>
<html lang="zxx" class="js">
<?php include_once 'head.php'; ?>

<style>
.card .table tr:first-child th,
.card .table tr:first-child td {
    white-space: nowrap;
}

.form-group {
    position: relative;
    margin-bottom: 1.25rem !important;
}
tr > th, tr > td {
    display: table-cell !important;
}
</style>

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
                                            <div class="row">
                                                <div class="col-md-6 ">
                                                    <nav aria-label="breadcrumb">
                                                        <ol class="breadcrumb">
                                                            <li class="breadcrumb-item"><a href="userbase.php">List of all
                                                                    voters</a></li>
                                                            <li class="breadcrumb-item active" aria-current="page">
                                                                Adivasi voters List</li>
                                                        </ol>
                                                    </nav>
                                                    <h4 class="nk-block-title">Adivasi voters List</h4>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="submit" name="submit"
                                                        class="btn btn-lg btn-warning justify-content-center" title=""
                                                        data-original-title="Export Excel
                                                        File">Export Excel File</button>
                                                    <button type="submit" name="submit"
                                                        class="btn btn-lg btn-info justify-content-center" title=""
                                                        data-original-title="Import Excel
                                                        File">Import Excel File</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card card-preview w-100" style="width: max-content;">
                                        <div class="card-inner">
                                            <form method="POST" class="gy-3">
                                                <div class="row">
                                                    <div class="col-md-2">
                                                        <div class="form-group"> 
                                                            <select name="mandal" class="form-control" id="mandal_list">
                                                            <option value="" selected disabled hidden>मंडल</option>                                                            
                                                            <?php if(!empty($filter_mandal)){ ?>
                                                                <option value="<?php echo $filter_mandal?>" selected><?php echo $filter_mandal.'✓'?></option>
                                                                <?php foreach($mandal_list as $key => $value){ ?>
                                                                    <option value="<?php echo $value[0] ?>"><?php echo $value[0] ?></option>
                                                                <?php } ?>
                                                            <?php }else{ ?>
                                                                <?php foreach($mandal_list as $key => $value){ ?>
                                                                    <option value="<?php echo $value[0] ?>"><?php echo $value[0] ?></option>
                                                                <?php } ?>
                                                            <?php }?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <select name="panchayat" class="form-control" id="panchayat_list">
                                                            <?php if(!empty($filter_panchayat)){ ?>
                                                                <option value="<?php echo $filter_panchayat?>" selected><?php echo $filter_panchayat.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>पंचायत</option>
                                                            <?php }?>
                                                        </select>
                                                           
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <div class="form-group">
                                                        <select name="boothRange" class="form-control" id="booth_range">
                                                            <?php if(!empty($filter_boothRange)){ ?>
                                                                <option value="<?php echo $filter_boothRange?>" selected><?php echo $filter_boothRange.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>बूथ रेंज</option>
                                                            <?php }?>
                                                        </select>
                                                        </div>
                                                    </div>

                                                    <?php if(!empty($getFilterQuestionList)){ ?>
                                                <?php foreach($getFilterQuestionList as $key => $value){
                                                // print_r($value);
                                                // die;
                                                     ?>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <select name="<?php echo $value[0];?>[]" class="form-control" id="optionFilters" >
                                                        <option value="" selected disabled hidden><?php echo $value[1];?></option>
                                                            <?php for($i=2;$i<=12;$i++){
                                                              if($value[$i]!=NULL){
                                                                ?>
                                                                <option value="<?php echo $value[$i]?>"><?php echo $value[$i]?></option>
                                                              <?php }
                                                            } ?>
                                                        </select>
                                                       
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php }?>

                                                    <div class="col-md-2">
                                                        <button name="import" type="submit"
                                                            class="btn btn-lg btn-primary w-100 justify-content-center">Appy</button>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button name="import" type="submit"
                                                            class="btn btn-lg btn-danger w-100 justify-content-center">Reset</button>
                                                    </div>
                                                    <div class="col-md-12 text-right mt-3">
                                                        <button name="import" type="submit"
                                                            class="btn btn-lg btn-light justify-content-center py-1 px-3 btn-tooltip"
                                                            data-original-title="Click to send an Whatsapp SMS"
                                                            title=""><em class="icon ni ni-emails"></em>&nbsp;Send
                                                            SMS</button>
                                                        <select name="sms" class="btn btn-lg btn-light py-1 px-3"
                                                            data-original-title="" title="">
                                                            <option>--Send SMS--</option>
                                                            <option
                                                                value="कोरोना आपदा की इस घड़ी में मैं ईश्वर से प्रार्थना करता हूँ कि हम सभी को सुख शांति एवं उत्तम स्वास्थ्य का आशीर्वाद दें। आप सभी घरों में रहें व स्वस्थ रहें और मेरे योग्य किसी भी प्रकार की सहायता के लिए संपर्क करें। हिम्मत सिंह झाला एसआरएम ग्रुप 9414197766 8003394949">
                                                                Corona</option>
                                                            <option
                                                                value="आप सभी को शक्ति उपासना के महापर्व नवरात्रि की हार्दिक शुभकामनाएं। हिम्मत सिंह झाला भाजपा प्रत्याशी, वल्लभनगर विधानसभा।">
                                                                Navrati Puja</option>
                                                            <option
                                                                value="भारतीय जनता पार्टी के शीर्ष नेतृत्व, वरिष्ठ पदाधिकारीगण एवं सभी कार्यकर्ताओं का मुझ पर विश्वास जताने के लिए एवं अवसर देने के लिए आप सब का आभार व्यक्त करता हूँ। मैं आपको विश्वास दिलाता हूं कि वल्लभनगर विधानसभा एवं भाजपा की आन बान शान के लिए हरसंभव प्रयास करता रहूँगा। हिम्मत सिंह झाला, भाजपा प्रत्याशी वल्लभनगर विधानसभा।">
                                                                Puja In</option>
                                                        </select>
                                                        <button name="import" type="submit"
                                                            class="btn btn-lg btn-light justify-content-center py-1 px-3 btn-tooltip"
                                                            data-original-title="Click to send an Whatsapp SMS"
                                                            title=""><em
                                                                class="icon ni ni-call-alt"></em>&nbsp;Whatsapp</button>

                                                    </div>
                                                </div>
                                            </form>
                                            <table class="table table-bordered table-responsive mt-3"
                                                id="adivasiVoterTable">
                                                <thead>
                                                    <tr>
                                                        <th>S.No.</th>
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
                                                        <?php if(strtolower($deptName) != 'field worker department'){?>

                                                                <?php if(!empty($getFilterQuestionList)){ ?>
                                                                  
                                                                <?php foreach($getFilterQuestionList as $key => $value){
                                                                //  print_r($value);
                                                                ?>
                                                                <th><?php echo $value[0];?></th>
                                                                <?php } ?>
                                                                <?php }?>

                                                                <th>Surveyed By</th>
                                                                <th>Surveyed At</th>
                                                                
                                                                <th>Action</th>
                                                                <th>
                                                                <div
                                                                class="custom-control custom-control-sm custom-checkbox notext">
                                                                <input type="checkbox" name="select_all"
                                                                    data-child="chk2" class="custom-control-input"
                                                                    id="selectAllMembers">
                                                                <label class="custom-control-label"
                                                                    for="selectAllMembers"></label>
                                                            </div>
                                                        </th>
                                                    <?php } ?>
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
    <script>
        $("#mandal_list").click(function(){
            var mandal = $(this).val();
            $.ajax({
                url: 'service_fetch_panchayat.php',
                type: 'post',
                data: {mandal:mandal},
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    $("#panchayat_list").empty();
                    $("#panchayat_list").append('<option value="" selected disabled hidden>पंचायत</option>');
                    for( var i = 0; i<len; i++){
                        var name = response[i];
                        $("#panchayat_list").append("<option value='"+name+"'>"+name+"</option>");
                    }
                }
            });
        });
        $("#panchayat_list").click(function(){
            var panchayat = $(this).val();
            $.ajax({
                url: 'service_fetch_booth_range.php',
                type: 'post',
                data: {panchayat:panchayat},
                dataType: 'json',
                success:function(response){
                    var len = response.length;                   
                    $("#booth_range").empty();
                    $("#booth_range").append('<option value="" selected disabled hidden>बूथ रेंज</option>');
                    for(var i = 0; i<len; i++){
                        var name = response[i];
                        var boothresponse = name[0].split(",");
                        var boothlen = boothresponse.length;
                        for( var i = 0; i<boothlen; i++){
                            var boothname = boothresponse[i];
                         // console.log(boothname);
                        $("#booth_range").append("<option value='"+boothname+"'>"+boothname+"</option>");
                        }
                    }
                }
            });
        });
        $("#category").click(function(){
            var category = $(this).val();
            $.ajax({
                url: 'service_fetch_cates.php',
                type: 'post',
                data: {category:category},
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    $("#caste_list").empty();
                    $("#caste_list").append('<option value="" selected disabled hidden>जाति</option>');
                    for( var i = 0; i<len; i++){
                        var name = response[i];
                        $("#caste_list").append("<option value='"+name+"'>"+name+"</option>");
                    }
                }
            });
        });
        $(document).ready(function() {
            // var panchayat = $('#optionFilters').val();
            // alert(panchayat);
                NioApp.DataTable('#adivasiVoterTable', {
                    "lengthMenu": [100, 250, 500],
                    "searching": false,
                    "paging":true,
                    "processing":true,
                    "serverSide":true,
                    "order": [],
                    "info":true,
                    "ajax":{
                        url:"service_for_adivasi_voters.php?booth_no=<?php echo $filter_boothRange?>&assignedLoksabha=<?php echo $assignedLoksabha ?>&filter_panchayat=<?php echo $filter_panchayat?>&filter_boothRange=<?php echo $filter_boothRange?>",
                        type:"POST"
                        },
                    "ordering": false,
                    responsive: {
                        details: true
                    }
                });
        });
    </script>
     <script>
        $('#selectAllMembers').on('click', function(){
            var childClass = $(this).attr('data-child');
            $('.' + childClass + '').prop('checked', this.checked);
        });
    </script>
    <!-- app-root @e -->
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>

</html>