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

if($assignedVidhansabha != ''){
    $assignedVidhansabha = $assignedVidhansabha;
}else{
    $assignedVidhansabha = 'वल्लभनगर';
}

$mandal_list = get_mandal_list($conn,$assignedVidhansabha);
$category_list = get_category_list($conn);

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

    if(isset($_GET['isExport']) && $_GET['isExport'] != '' && $_GET['isExport'] != NULL && $_GET['isExport'] == TRUE){
        $export_surveyed_userbase = export_surveyed_userbase($conn,$_GET['filter_pesha'],$_GET['booth_no'],$_GET['assignedLoksabha '],$_GET['filter_loksabha'],$_GET['filter_mandal'],$_GET['filter_panchayat'],$_GET['filter_boothRange'],$_GET['filter_category'],$_GET['filter_caste'],$_GET['filter_ward'],$_GET['filter_pramukh_mudde'],$_GET['filter_mojuda_sarkaar'],$_GET['filter_2019_loksabha'],$_GET['filter_2018_vidhansabha'],$_GET['filter_partyVsCandidate'],$_GET['filter_vichardhara'],$_GET['filter_corona'],$_GET['filter_local_candidate'],$_GET['filter_2023_vidhansabha'],$_GET['filter_ageGroup']);
        $file = new Spreadsheet();
        $objPHPExcel = $file;
        
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
        $objPHPExcel->getActiveSheet()->SetCellValue('U1', 'पेशा');
        $objPHPExcel->getActiveSheet()->SetCellValue('V1', 'मोबाइल न०');
        $objPHPExcel->getActiveSheet()->SetCellValue('W1', 'व्हाट्सएप्प न०');
        $objPHPExcel->getActiveSheet()->SetCellValue('X1', 'प्रमुख मुद्दे');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y1', 'Rating Current Govt');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z1', 'Voted in 2019 लोकसभा');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA1', 'Voted in 2018 विधानसभा');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB1', '2018 (पार्टी/सदस्य)');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC1', 'विचारधारा');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD1', 'कोरोना');
        $objPHPExcel->getActiveSheet()->SetCellValue('AE1', 'लोकल कार्यकर्ता');
        $objPHPExcel->getActiveSheet()->SetCellValue('AF1', '2023 विधानसभा');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG1', 'जाति');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH1', 'श्रेणी');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI1', 'Surveyed By');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ1', 'Surveyed At');

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
        $objPHPExcel->getActiveSheet()->SetCellValue('U'.$rowCount, $value['pesha'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('V'.$rowCount, $value['mobile_no'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('W'.$rowCount, $value['whatsapp_no'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('X'.$rowCount, $value['pramukh_mudde'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('Y'.$rowCount, $value['rating_current_govt'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('Z'.$rowCount, $value['voted_2019_loksabha'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AA'.$rowCount, $value['voted_2018_vidhansabha'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AB'.$rowCount, $value['vote_reason_2018'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AC'.$rowCount, $value['vichardhahra'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AD'.$rowCount, $value['corona'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AE'.$rowCount, $value['active_karyakarta'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AF'.$rowCount, $value['vidhansabha_2023'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AG'.$rowCount, $value['caste'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AH'.$rowCount, $value['caste_categories'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AI'.$rowCount, $value['surveyed_by'],'UTF-8');
        $objPHPExcel->getActiveSheet()->SetCellValue('AJ'.$rowCount, $value['surveyed_at'],'UTF-8');
        $rowCount++;
        }
        
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
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="category" class="form-control" id="category">
                                                            <?php if(!empty($filter_category)){ ?>
                                                                <option value="<?php echo $filter_category?>" selected><?php echo $filter_category.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>क्षेणी</option>
                                                            <?php }?> 
                                                            <?php foreach($category_list as $key => $value){ ?>
                                                                <option value="<?php echo $value[0]?>"><?php echo $value[0]?></option>
                                                            <?php } ?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="caste" class="form-control" id="caste_list">
                                                            <?php if(!empty($filter_caste)){ ?>
                                                                <option value="<?php echo $filter_caste?>" selected><?php echo $filter_caste.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>जाति</option>
                                                            <?php }?> 
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="pesha" class="form-control" id="pesha_list">
                                                            <?php if(!empty($filter_pesha)){ ?>
                                                                <option value="<?php echo $filter_pesha?>" selected ><?php echo $filter_pesha.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>पेशा</option>
                                                            <?php }?>        
                                                                <option value="किसान">किसान</option>
                                                                <option value="व्यवसाय">व्यवसाय</option>
                                                                <option value="पानी सप्लाई">पानी सप्लाई</option>
                                                                <option value="नौकरी">नौकरी</option>
                                                                <option value="मजदूर">मजदूर</option>
                                                                <option value="विद्यार्थी">विद्यार्थी</option>
                                                                <option value="बेरोजगार">बेरोजगार</option>
                                                                <option value="गृहणी">गृहणी</option>
                                                                <option value="रिटायर्ड">रिटायर्ड</option>
                                                                <option value="कोई कार्य नही कर रहे">कोई कार्य नही कर रहे</option>                                                   
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-md-12">
                                            <div class="row g-12">
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select name="pramukh_mudde" class="form-control">
                                                            <?php if(!empty($filter_pramukh_mudde)){ ?>
                                                                <option value="<?php echo $filter_pramukh_mudde?>" selected><?php echo $filter_pramukh_mudde.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>प्रमुख मुद्दे</option>
                                                            <?php }?>      
                                                                <option value="सड़क">सड़क</option>
                                                                <option value="बिजली">बिजली</option>
                                                                <option value="पानी सप्लाई">पानी सप्लाई</option>
                                                                <option value="रोज़गार">रोज़गार</option>
                                                                <option value="शिक्षा">शिक्षा</option>
                                                                <option value="स्वास्थ्य सुविधएँ">स्वास्थ्य सुविधएँ</option>
                                                                <option value="जल निकासी">जल निकासी</option>
                                                                <option value="स्ट्रीट लाइट">स्ट्रीट लाइट</option>
                                                                <option value="कचरा प्रबंधन">कचरा प्रबंधन</option>
                                                                <option value="लोकल ट्रांसपोर्ट">लोकल ट्रांसपोर्ट</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select name="mojuda_sarkaar" class="form-control">
                                                            <?php if(!empty($filter_mojuda_sarkaar)){ ?>
                                                                <option value="<?php echo $filter_mojuda_sarkaar?>" selected><?php echo $filter_mojuda_sarkaar.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>मौजूदा सरकार</option>
                                                            <?php }?>      
                                                                <option value="बढ़िया">बढ़िया</option>
                                                                <option value="संतोषजनक">संतोषजनक</option>
                                                                <option value="बुरा">बुरा</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select name="2019_loksabha" class="form-control">
                                                            <?php if(!empty($filter_2019_loksabha)){ ?>
                                                                <option value="<?php echo $filter_2019_loksabha?>" selected><?php echo $filter_2019_loksabha.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>2019 लोकसभा</option>
                                                            <?php }?>      
                                                                <option value="कांग्रेस">कांग्रेस</option>
                                                                <option value="भारतीय जनता पार्टी">भारतीय जनता पार्टी</option>
                                                                <option value="जनता सेना">जनता सेना</option>
                                                                <option value="राष्ट्रीय लोकतांत्रिक पार्टी">राष्ट्रीय लोकतांत्रिक पार्टी</option>
                                                                <option value="बहुजन समाज पार्टी">बहुजन समाज पार्टी</option>
                                                                <option value="अन्य">अन्य</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select name="2018_vidhansabha" class="form-control">
                                                            <?php if(!empty($filter_2018_vidhansabha)){ ?>
                                                                <option value="<?php echo $filter_2018_vidhansabha?>" selected><?php echo $filter_2018_vidhansabha.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>2018 विधानसभा</option>
                                                            <?php }?>      
                                                                <option value="कांग्रेस">कांग्रेस</option>
                                                                <option value="भारतीय जनता पार्टी">भारतीय जनता पार्टी</option>
                                                                <option value="जनता सेना">जनता सेना</option>
                                                                <option value="राष्ट्रीय लोकतांत्रिक पार्टी">राष्ट्रीय लोकतांत्रिक पार्टी</option>
                                                                <option value="बहुजन समाज पार्टी">बहुजन समाज पार्टी</option>
                                                                <option value="अन्य">अन्य</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select name="partyVsCandidate" class="form-control">
                                                            <?php if(!empty($filter_partyVsCandidate)){ ?>
                                                                <option value="<?php echo $filter_partyVsCandidate?>" selected><?php echo $filter_partyVsCandidate.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>पार्टी / सदस्य</option>
                                                            <?php }?>      
                                                                <option value="पार्टी">पार्टी</option>
                                                                <option value="उम्मीदवार">उम्मीदवार</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select name="vichardhara" class="form-control">
                                                            <?php if(!empty($filter_vichardhara)){ ?>
                                                                <option value="<?php echo $filter_vichardhara?>" selected><?php echo $filter_vichardhara.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>विचारधारा</option>
                                                            <?php }?>      
                                                                <option value="राम मंदिर">राम मंदिर</option>
                                                                <option value="किसान आंदोलन">किसान आंदोलन</option>
                                                                <option value="धारा 370">धारा 370 (कश्मीर)</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="col-md-12">
                                            <div class="row g-12">
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select name="corona" class="form-control">
                                                            <?php if(!empty($filter_corona)){ ?>
                                                                <option value="<?php echo $filter_corona?>" selected><?php echo $filter_corona.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>कोरोना</option>
                                                            <?php }?>      
                                                                <option value="अशोक गहलोत सरकार">अशोक गहलोत सरकार</option>
                                                                <option value="मोदी सरकार">मोदी सरकार</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select name="local_candidate" class="form-control">
                                                            <?php if(!empty($filter_local_candidate)){ ?>
                                                                <option value="<?php echo $filter_local_candidate?>" selected><?php echo $filter_local_candidate.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>लोकल कार्यकर्ता</option>
                                                            <?php }?>      
                                                                <option value="कांग्रेस">कांग्रेस</option>
                                                                <option value="भारतीय जनता पार्टी">भारतीय जनता पार्टी</option>
                                                                <option value="जनता सेना">जनता सेना</option>
                                                                <option value="राष्ट्रीय लोकतांत्रिक पार्टी">राष्ट्रीय लोकतांत्रिक पार्टी</option>
                                                                <option value="बहुजन समाज पार्टी">बहुजन समाज पार्टी</option>
                                                                <option value="अन्य">अन्य</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <select name="2023_vidhansabha" class="form-control">
                                                            <?php if(!empty($filter_2023_vidhansabha)){ ?>
                                                                <option value="<?php echo $filter_2023_vidhansabha?>" selected><?php echo $filter_2023_vidhansabha.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>2023 विधानसभा</option>
                                                            <?php }?>      
                                                                <option value="कांग्रेस">कांग्रेस</option>
                                                                <option value="भारतीय जनता पार्टी">भारतीय जनता पार्टी</option>
                                                                <option value="जनता सेना">जनता सेना</option>
                                                                <option value="राष्ट्रीय लोकतांत्रिक पार्टी">राष्ट्रीय लोकतांत्रिक पार्टी</option>
                                                                <option value="बहुजन समाज पार्टी">बहुजन समाज पार्टी</option>
                                                                <option value="अन्य">अन्य</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="ageGroup" class="form-control">
                                                            <?php if(!empty($filter_ageGroup)){ ?>
                                                                <option value="<?php echo $filter_ageGroup?>" selected><?php echo $filter_ageGroup.'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>Age Group</option>
                                                            <?php }?>    
                                                            <option value="25~30">25 ~ 30</option>
                                                            <option value="31~35">31 ~ 35</option>
                                                            <option value="36~40">36 ~ 40</option>
                                                            <option value="40~45">40 ~ 45</option>
                                                            <option value="45~50">45 ~ 50</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                
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
                                                    <!-- <div class="row">
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
                                                        <div class="row g-3">
                                                            <div class="col-lg-1 offset-lg-1">
                                                                    <button type="submit" name="submit_booth" value="applied" class="btn btn-dim btn-success">OK</button>
                                                            </div>
                                                        </div>
                                                    </div> -->
                                                    </form><br/>
                                                    <a href="userbase.php" class="btn btn-dim btn-warning">Go to ↦ All Voters</a>

                                                    <a href="?filter_pesha=<?php echo $filter_pesha?>&booth_no=<?php echo $booth_no?>&assignedLoksabha=<?php echo $assignedLoksabha ?>&filter_loksabha=<?php echo $filter_loksabha?>&filter_mandal=<?php echo $filter_mandal?>&filter_panchayat=<?php echo $filter_panchayat?>&filter_boothRange=<?php echo $filter_boothRange?>&filter_category=<?php echo $filter_category?>&filter_caste=<?php echo $filter_caste?>&filter_ward=<?php echo $filter_ward?>&filter_pramukh_mudde=<?php echo $filter_pramukh_mudde?>&filter_mojuda_sarkaar=<?php echo $filter_mojuda_sarkaar?>&filter_2019_loksabha=<?php echo $filter_2019_loksabha?>&filter_2018_vidhansabha=<?php echo $filter_2018_vidhansabha?>&filter_partyVsCandidate=<?php echo $filter_partyVsCandidate?>&filter_vichardhara=<?php echo $filter_vichardhara?>&filter_corona=<?php echo $filter_corona?>&filter_local_candidate=<?php echo $filter_local_candidate?>&filter_2023_vidhansabha=<?php echo $filter_2023_vidhansabha?>&filter_ageGroup=<?php echo $filter_ageGroup?>&isExport=TRUE" class="btn btn-dim btn-info">Export Excel File<em style="margin-left: 2px;" class="icon ni ni-growth"></em></a>
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
                                                        <!-- <th style="text-align: center;">Action</th> -->
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
                    for( var i = 0; i<len; i++){
                        var name = response[i];
                        $("#booth_range").append("<option value='"+name+"'>"+name+"</option>");
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
                        url:"service_for_surveyed_userbase.php?filter_pesha=<?php echo $filter_pesha?>&booth_no=<?php echo $booth_no?>&assignedLoksabha=<?php echo $assignedLoksabha ?>&filter_loksabha=<?php echo $filter_loksabha?>&filter_mandal=<?php echo $filter_mandal?>&filter_panchayat=<?php echo $filter_panchayat?>&filter_boothRange=<?php echo $filter_boothRange?>&filter_category=<?php echo $filter_category?>&filter_caste=<?php echo $filter_caste?>&filter_ward=<?php echo $filter_ward?>&filter_pramukh_mudde=<?php echo $filter_pramukh_mudde?>&filter_mojuda_sarkaar=<?php echo $filter_mojuda_sarkaar?>&filter_2019_loksabha=<?php echo $filter_2019_loksabha?>&filter_2018_vidhansabha=<?php echo $filter_2018_vidhansabha?>&filter_partyVsCandidate=<?php echo $filter_partyVsCandidate?>&filter_vichardhara=<?php echo $filter_vichardhara?>&filter_corona=<?php echo $filter_corona?>&filter_local_candidate=<?php echo $filter_local_candidate?>&filter_2023_vidhansabha=<?php echo $filter_2023_vidhansabha?>&filter_ageGroup=<?php echo $filter_ageGroup?>",
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