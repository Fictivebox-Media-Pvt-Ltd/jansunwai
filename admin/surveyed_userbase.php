<?php
include_once '../configs/includes.php';
include 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;

if(!empty($_POST['data_filter']) && isset($_POST['data_filter'])){
    $filter_mandal = $_POST['mandal'];
    $filter_panchayat = $_POST['panchayat'];
    $filter_boothRange = str_replace(' ', '', $_POST['boothRange']);

    $optionFilter = $_POST['optionFilters'];
    $optionFilters = implode (",", $optionFilter) ; 
 
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


   
   $assignedLoksabha;
   $filter_panchayat;
   $filter_boothRange;
   $optionFilters;



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

if($assignedVidhansabha != ''){
    $assignedVidhansabha = $assignedVidhansabha;
}else{
    $assignedVidhansabha = 'वल्लभनगर';
}

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
    
    $range = 20;    
    if(isset($_GET['isExport']) && $_GET['isExport'] != '' && $_GET['isExport'] != NULL && $_GET['isExport'] == TRUE){
      
        $optionFilters = $_GET['optionFilters'];
 
        $export_surveyed_userbase = export_surveyed_userbase($conn,$assignedLoksabha,$assignedVidhansabha,$_GET['mandal'],$_GET['panchayat'],$_GET['boothRange'],$optionFilters);
        $file = new Spreadsheet();
        $objPHPExcel = $file;
        $alphabet = range('A', 'Z');
             
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'S. No.');
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'File ID');
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'लोकसभा');
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'विधानसभा');
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'बूथ');
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'सेक्शन सं');
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'मकान सं');
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'नाम');
        $objPHPExcel->getActiveSheet()->SetCellValue('I1', 'उम');
        $objPHPExcel->getActiveSheet()->SetCellValue('J1', 'पिता / पति का नाम');
        $objPHPExcel->getActiveSheet()->SetCellValue('K1', 'सम्बन्ध');
        $objPHPExcel->getActiveSheet()->SetCellValue('L1', 'लिंग');
        $objPHPExcel->getActiveSheet()->SetCellValue('M1', 'वार्ड');
        $objPHPExcel->getActiveSheet()->SetCellValue('N1', 'आई डी क्रमांक');
        $objPHPExcel->getActiveSheet()->SetCellValue('O1', 'पोलिंग स्टेशन का नाम');
        $objPHPExcel->getActiveSheet()->SetCellValue('P1', 'Poling Station Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q1', 'Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('R1', 'Father / Husband Name');
        $objPHPExcel->getActiveSheet()->SetCellValue('S1', 'Gender');
        $objPHPExcel->getActiveSheet()->SetCellValue('T1', 'Ward');
        if(!empty($getFilterQuestionList)){ 
                foreach($getFilterQuestionList as $k => $data){
                   // echo $range;
                    $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$range].'1',$data[1]);
                    $range++;
                } 
        }       
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Surveyed By');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Surveyed At');

        //$alphabet = range('A', 'Z');
        $rowCount   =   2;      
       foreach($export_surveyed_userbase as $key => $value){

        $objPHPExcel->getActiveSheet()->SetCellValue('A'.$rowCount, $value['s_no'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('B'.$rowCount, $value['file_id'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('C'.$rowCount, $value['loksabha'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('D'.$rowCount, $value['vidhansabha'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('E'.$rowCount, $value['booth_no'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('F'.$rowCount, $value['section_no'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.$rowCount, $value['house_no'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.$rowCount, $value['voter_name_hin'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('I'.$rowCount, $value['voter_age'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('J'.$rowCount, $value['father_husband_name_hin'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('K'.$rowCount, $value['sambandh'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('L'.$rowCount, $value['gender_hin'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('M'.$rowCount, $value['ward_hin'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('N'.$rowCount, $value['id_no'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('O'.$rowCount, $value['poling_station_hin'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('P'.$rowCount, $value['poling_station_en'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('Q'.$rowCount, $value['voter_name_en'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('R'.$rowCount, $value['father_husband_name_en'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('S'.$rowCount, $value['gender_en'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('T'.$rowCount, $value['ward_en'],'UTF-8');
        if(!empty($getFilterQuestionList)){ 
            $tworange = 20;
            foreach($getFilterQuestionList as $ke => $row){ 
            //    print_r($value[$row[1]]);
            //   echo $row[1];
            
              if($tworange>25){
                $newrange = $tworange - 25;
                $objPHPExcel->getActiveSheet()->SetCellValue('A'.$alphabet[$newrange].$rowCount,$value[$row[1]]);
              }
              else{
                $objPHPExcel->getActiveSheet()->SetCellValue($alphabet[$tworange].$rowCount,$value[$row[1]]);
              }
               
                $tworange++;
            } 
        }
        $objPHPExcel->getActiveSheet()->SetCellValue('AI'.$rowCount, $value['surveyed_by'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$rowCount, $value['surveyed_at'],'UTF-8');
        $rowCount++;
        }
       // die;
        
        $objPHPExcel->getActiveSheet()->getStyle("A1:AJ1")->getFont()->setBold(true);
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, 'Xlsx');
        $file_name = 'Surveyed-Voters.xlsx';
        $writer->save($file_name);
        header('Content-Type: application/x-www-form-urlencoded');
        header('Content-Transfer-Encoding: Binary');
        header("Content-disposition: attachment; filename=\"".$file_name."\"");
        readfile($file_name);
        unlink($file_name);
        exit;
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
                <div class="nk-content " style="margin-top: 50px;">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                               <div class="nk-block nk-block-lg">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title">Voter List</h4>
                                                <div class="form-group" style="margin-top: 15px;">
                                                <label class="form-label" style="padding-top: 5px;font-size: 17px;margin-bottom:4px;">Apply Data Filters: </label>
                                                <span class="form-note" style="margin-bottom:10px">`मंडल` to `क्षेणी` filters are highly data-sensitive. Select them from Left to Right order only, after every page load. </span>
                                                </div>
                                            </div>
                                        <form method="POST" class="form-validate">
                                        <div class="col-md-12">
                                            <div class="row g-12">
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
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
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="panchayat" class="form-control" id="panchayat_list">
                                                            <?php if(!empty($filter_panchayat)){ ?>
                                                                <option value="<?php echo $filter_panchayat?>" selected><?php echo $filter_panchayat.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>पंचायत</option>
                                                            <?php }?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="boothRange" class="form-control" id="booth_range">
                                                            <?php if(!empty($filter_boothRange)){ ?>
                                                                <option value="<?php echo $filter_boothRange?>" selected><?php echo $filter_boothRange.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>बूथ रेंज</option>
                                                            <?php }?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>                                               
                                                                
                                                                                
                                            <?php if(!empty($getFilterQuestionList)){ ?>
                                                <?php foreach($getFilterQuestionList as $key => $value){
                                                ?>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="optionFilters[]" class="form-control" id="optionFilters" >
                                                        <option value="" selected disabled hidden><?php echo $value[1];?></option>
                                                            <?php for($i=1;$i<=12;$i++){
                                                              if($value[$i]!=NULL){
                                                                ?>
                                                                <option value="<?php echo $value[$i]?>"><?php echo $value[$i]?></option>
                                                              <?php }
                                                            } ?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } ?>
                                                <?php }?>

                                            </div>
                                        </div>
                                       
                                        <!-- <br> -->
                                        <div class="col-md-12">
                                            <div class="row g-12">
                                             
                                                <!--<div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="ageGroup" class="form-control">
                                                            <!?php if(!empty($filter_ageGroup)){ ?>
                                                                <option value="<!?php echo $filter_ageGroup?>" selected><!?php echo $filter_ageGroup.'✓'?></option>
                                                            <!?php }else{ ?>
                                                                <option value="" selected disabled hidden>Age Group</option>
                                                            <!?php }?>    
                                                            <option value="25~30">25 ~ 30</option>
                                                            <option value="31~35">31 ~ 35</option>
                                                            <option value="36~40">36 ~ 40</option>
                                                            <option value="40~45">40 ~ 45</option>
                                                            <option value="45~50">45 ~ 50</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div> -->
                                                
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <button style="min-width:-webkit-fill-available;justify-content:center" type="submit" name="data_filter" value="applied" class=" btn-outline-primary">Apply</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <input style="min-width:-webkit-fill-available;justify-content:center" type="reset" class=" btn-outline-warning">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        </form>
                                        <br/>
                                        <div class="col-md-12">
                                                    <form method="GET" class="form-validate">                                                 
                                                    </form><br/>
                                                    <a href="userbase.php" class="btn btn-dim btn-warning">Go to ↦ All Voters</a>
                                                    <a href="?booth_no=<?php echo $filter_boothRange?>&assignedLoksabha=<?php echo $assignedLoksabha ?>&filter_panchayat=<?php echo $filter_panchayat?>&filter_boothRange=<?php echo $filter_boothRange?>&optionFilters=<?php echo $optionFilters?>&isExport=TRUE" class="btn btn-dim btn-info">Export Excel File<em style="margin-left: 2px;" class="icon ni ni-growth"></em></a>

                                                </div>
                                               
                                            </div>
                                        </div> <br>
                                        <form action="surveyed_userbase_sms.php" method="post">
                                            <div style="text-align:right;">

                                                    <button type="submit" name="submit" class="btn-outline-info btn-tooltip" title="Click to send an SMS"><em class="icon ni ni-emails"></em>&nbsp;Send SMS</button>
                                                    <select name="sms" class="btn-outline-info btn-tooltip text-left">
                                                    <option>--Send SMS--</option>
                                                    <?php
                                                        foreach ($sms as $key => $value) {
                                                    ?>
                                                    <option value="<?php echo $value['sms']; ?>"><?php echo $value['sms_type']; ?></option>
                                                    <?php } ?>
                                                   </select>
                                                    <button href="#" class="btn-outline-success btn-tooltip" title="Click to send an Whatsapp SMS"><em class="icon ni ni-call-alt"></em>&nbsp;Whatsapp</button>
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
                                                    
                                                    <?php if(strtolower($deptName) != 'field worker department'){?>

                                                        <?php if(!empty($getFilterQuestionList)){ ?>
                                                <?php foreach($getFilterQuestionList as $key => $value){
                                                  //  print_r($value);
                                                     ?>
                                               <th><?php echo $value[1];?></th>
                                                <?php } ?>
                                                <?php }?>
                                                  
                                                        <th>Surveyed By</th>
                                                        <th>Surveyed At</th>
                                                        <th>Action</th>
                                                        <th>
                                                            <div class="custom-control custom-control-sm custom-checkbox notext">
                                                                    <input type="checkbox" name='select_all' data-child="chk2" class="custom-control-input" id="selectAllMembers">
                                                                    <label class="custom-control-label" for="selectAllMembers"></label>
                                                            </div>
                                                        </th>
                                                    <?php } ?>
                                                        </tr>
                                                    </thead>
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
                NioApp.DataTable('#voter-list', {
                    "lengthMenu": [100, 250, 500],
                    "searching": false,
                    "paging":true,
                    "processing":true,
                    "serverSide":true,
                    "order": [],
                    "info":true,
                    "ajax":{
                        url:"service_for_surveyed_userbase.php?booth_no=<?php echo $filter_boothRange?>&assignedLoksabha=<?php echo $assignedLoksabha ?>&filter_mandal=<?php echo $filter_mandal?>&filter_panchayat=<?php echo $filter_panchayat?>&filter_boothRange=<?php echo $filter_boothRange?>&optionFilters=<?php echo $optionFilters?>",
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
                $(document).ready(function() {
                    NioApp.DataTable('#karyakartas', {
                        "paging":true,
                        "processing":true,
                        "serverSide":false,
                        "order": [],
                        "info":true,
                        "columnDefs":[
                                        {
                                            "targets":[1,3,4,5,6],
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