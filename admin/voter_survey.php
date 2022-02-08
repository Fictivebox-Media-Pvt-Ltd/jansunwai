<?php

include_once '../configs/includes.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    $admin_dir_name = dirname($_SERVER['PHP_SELF']);
    $user_id = $_SESSION['user_id'];
    $loginUserData = get_user_details($conn,$user_id);
    $adminName = $loginUserData['f_name'] . ' ' . $loginUserData['l_name'];
    $fName = $loginUserData['f_name'];
    $lName = $loginUserData['l_name'];
    $adminImage = $loginUserData['user_image'];
    $deptId = $loginUserData['department_id'];
    $adminEmail = $loginUserData['email'];
    $userName = $loginUserData['username'];
    $deptName = get_department_details($conn,$deptId);
}

if($_GET['id']){
   $voter_id=$_GET['id'];
    $voter_details = get_voter_details($conn,$voter_id);

}
if(isset($_GET['id'])){
    $voter_id=$_GET['id'];
    $peshasingle = isset($_POST['pesha']) ? $_POST['pesha'] : '';
    $pesha="";  
foreach($peshasingle as $chk1)  
   {  
      $pesha .= $chk1.",";  
   } 
    $mobile_no = isset($_POST['mobile_no']) ? $_POST['mobile_no'] : '';
    $whatsapp_no = isset($_POST['whatsapp_no']) ? $_POST['whatsapp_no'] : '';
    $pramukh= isset($_POST['pramukh_mudde']) ? $_POST['pramukh_mudde'] : '';
    $pramukh_mudde="";  
    foreach($pramukh as $chk)  
       {  
          $pramukh_mudde .= $chk.",";  
       } 
    $rating_current_govt = isset($_POST['Rating_Current_Govt']) ? $_POST['Rating_Current_Govt'] : '';
    $voted_2019_loksabha = isset($_POST['Voted_2019_loksabha']) ? $_POST['Voted_2019_loksabha'] : '';
    $voted_2018_vidhansabha = isset($_POST['Voted_2018_vidhansabha']) ? $_POST['Voted_2018_vidhansabha'] : '';
    $vote_reason_2018 = isset($_POST['vote_reason_2018']) ? $_POST['vote_reason_2018'] : '';
    $vichardhahra = isset($_POST['vichardhahra']) ? $_POST['vichardhahra'] : '';
    $corona = isset($_POST['corona']) ? $_POST['corona'] : '';
    $active_karyakarta = isset($_POST['active_karyakarta']) ? $_POST['active_karyakarta'] : '';
    $vidhansabha_2023 = isset($_POST['vidhansabha_2023']) ? $_POST['vidhansabha_2023'] : '';
    $caste = isset($_POST['caste']) ? $_POST['caste'] : '';
    $caste_categories = isset($_POST['caste_categories']) ? $_POST['caste_categories'] : '';

    if(isset($_POST['submit'])){
        add_voter_survey($conn,$voter_id,$pesha,$mobile_no,$whatsapp_no,$pramukh_mudde,$rating_current_govt,$voted_2019_loksabha,$voted_2018_vidhansabha,$vote_reason_2018,$vichardhahra,$corona,$active_karyakarta,$vidhansabha_2023,$caste,$caste_categories);
    }
    
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
                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head" style="padding: 75px 10px 0px 10px;">
                        <div class="nk-block-head-content">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Voter Details</h5>
                            </div>
                            <?php
                            foreach ($voter_details as $key => $value) {                          

                            ?>
                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label">बूथ नो०</label>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <?php echo $value['booth_no']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label">नाम</label>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <?php echo $value['voter_name_hin']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label">पिता/पति का नाम </label>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <?php echo $value['father_husband_name_hin']; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row g-3 align-center">
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <label class="form-label">मकान स०</label>
                                    </div>
                                </div>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <?php echo $value['house_no']; ?>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>


                <div class="nk-block nk-block-lg">

                    <div class="card">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Questions</h5>
                            </div>
                            <form method="POST" enctype="multipart/form-data" class="gy-3 form-validate">
                            <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">मुख्य पेशा </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="किसान"
                                                        class="custom-control-input" id="pesha1">
                                                    <label class="custom-control-label" for="pesha1">किसान
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="व्यवसाय"
                                                        class="custom-control-input" id="pesha2">
                                                    <label class="custom-control-label"
                                                        for="pesha2">व्यवसाय</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="नौकरी"
                                                        class="custom-control-input" id="pesha3">
                                                    <label class="custom-control-label" for="pesha3">नौकरी
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="मजदूर"
                                                        class="custom-control-input" id="pesha4">
                                                    <label class="custom-control-label" for="pesha4">मजदूर
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="विद्यार्थी"
                                                        class="custom-control-input" id="pesha5">
                                                    <label class="custom-control-label" for="pesha5">विद्यार्थी
                                                    </label>
                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="बेरोजगार"
                                                        class="custom-control-input" id="pesha6">
                                                    <label class="custom-control-label"
                                                        for="pesha6">बेरोजगार</label>

                                                </div>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="गृहणी"
                                                        class="custom-control-input" id="pesha7">
                                                    <label class="custom-control-label" for="pesha7">गृहणी
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="रिटायर्ड"
                                                        class="custom-control-input" id="pesha8">
                                                    <label class="custom-control-label" for="pesha8">रिटायर्ड
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="कोई कार्य नही कर रहे"
                                                        class="custom-control-input" id="pesha9">
                                                    <label class="custom-control-label" for="pesha9">कोई कार्य नही
                                                        कर रहे </label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">मोबाइल न०</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" placeholder="Enter Mobile No."
                                                    name="mobile_no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">व्हाट्सएप्प न०</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="number" class="form-control"
                                                    placeholder="Enter whatsapp Number" name="whatsapp_no">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">आपके गांव के तीन प्रमुख मुद्दे क्या है?</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="सड़क"
                                                        class="custom-control-input" id="mudde1">
                                                    <label class="custom-control-label" for="mudde1">सड़क </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="बिजली"
                                                        class="custom-control-input" id="mudde2">
                                                    <label class="custom-control-label" for="mudde2">बिजली</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="पानी सप्लाई"
                                                        class="custom-control-input" id="mudde3">
                                                    <label class="custom-control-label" for="mudde3">पानी सप्लाई
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="रोज़गार"
                                                        class="custom-control-input" id="mudde4">
                                                    <label class="custom-control-label" for="mudde4">रोज़गार
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="शिक्षा"
                                                        class="custom-control-input" id="mudde5">
                                                    <label class="custom-control-label" for="mudde5">शिक्षा
                                                    </label>
                                                </div>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]"
                                                        value="स्वास्थ्य सुविधएँ" class="custom-control-input"
                                                        id="mudde6">
                                                    <label class="custom-control-label" for="mudde6">स्वास्थ्य
                                                        सुविधएँ</label>

                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="जल निकासी"
                                                        class="custom-control-input" id="mudde7">
                                                    <label class="custom-control-label" for="mudde7">जल निकासी
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="स्ट्रीट लाइट"
                                                        class="custom-control-input" id="mudde8">
                                                    <label class="custom-control-label" for="mudde8">स्ट्रीट लाइट
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="कचरा प्रबंधन"
                                                        class="custom-control-input" id="mudde9">
                                                    <label class="custom-control-label" for="mudde9">कचरा प्रबंधन
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]"
                                                        value="लोकल ट्रांसपोर्ट" class="custom-control-input"
                                                        id="mudde10">
                                                    <label class="custom-control-label" for="mudde10">लोकल
                                                        ट्रांसपोर्ट</label>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">वर्तमान की राज्य सरकार के कार्य को आप कैसे देखते
                                                है? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Rating_Current_Govt" value="बढ़िया" id="Rating1">
                                                    <label class="custom-control-label" for="Rating1">
                                                    बढ़िया &nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Rating_Current_Govt" value="संतोषजनक" id="Rating2">
                                                    <label class="custom-control-label" for="Rating2">
                                                    संतोषजनक &nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Rating_Current_Govt" value="बुरा" id="Rating3">
                                                    <label class="custom-control-label" for="Rating3">
                                                    बुरा</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">आपने 2019 लोकसभा चुनाव में किस पार्टी को वोट दिया था? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="कांग्रेस" id="voted1">
                                                    <label class="custom-control-label" for="voted1">
                                                    कांग्रेस	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="भारतीय जनता पार्टी" id="voted2">
                                                    <label class="custom-control-label" for="voted2">
                                                    भारतीय जनता पार्टी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="जनता सेना" id="voted3">
                                                    <label class="custom-control-label" for="voted3">
                                                    जनता सेना	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="राष्ट्रीय लोकतांत्रिक पार्टी" id="voted4">
                                                    <label class="custom-control-label" for="voted4">
                                                    राष्ट्रीय लोकतांत्रिक पार्टी</label>
                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="बहुजन समाज पार्टी" id="voted5">
                                                    <label class="custom-control-label" for="voted5">
                                                    बहुजन समाज पार्टी &nbsp;&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="अन्य" id="voted6">
                                                    <label class="custom-control-label" for="voted6">
                                                    अन्य</label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">आपने 2018 विधानसभा चुनाव में किस पार्टी को वोट दिया था? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="कांग्रेस" id="voted_vidhansabha1">
                                                    <label class="custom-control-label" for="voted_vidhansabha1">
                                                    कांग्रेस	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="भारतीय जनता पार्टी" id="voted_vidhansabha2">
                                                    <label class="custom-control-label" for="voted_vidhansabha2">
                                                    भारतीय जनता पार्टी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="जनता सेना" id="voted_vidhansabha3">
                                                    <label class="custom-control-label" for="voted_vidhansabha3">
                                                    जनता सेना	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="राष्ट्रीय लोकतांत्रिक पार्टी" id="voted_vidhansabha4">
                                                    <label class="custom-control-label" for="voted_vidhansabha4">
                                                    राष्ट्रीय लोकतांत्रिक पार्टी</label>
                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="बहुजन समाज पार्टी" id="voted_vidhansabha5">
                                                    <label class="custom-control-label" for="voted_vidhansabha5">
                                                    बहुजन समाज पार्टी &nbsp;&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="अन्य" id="voted_vidhansabha6">
                                                    <label class="custom-control-label" for="voted_vidhansabha6">
                                                    अन्य</label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">2018 में आपके वोट देने का कारण पार्टी थी या उम्मीदवार थे ? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vote_reason_2018" value="पार्टी" id="vote_reason_20181">
                                                    <label class="custom-control-label" for="vote_reason_20181">
                                                    पार्टी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vote_reason_2018" value="उम्मीदवार" id="vote_reason_20182">
                                                    <label class="custom-control-label" for="vote_reason_20182">
                                                    उम्मीदवार	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>                                    
                                               
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">इनमें से कौन सा विषय आपके दिल के ज्यादा करीब है? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vichardhahra" value="राम मंदिर" id="vichardhahra1">
                                                    <label class="custom-control-label" for="vichardhahra1">
                                                    राम मंदिर	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vichardhahra" value="किसान आंदोलन " id="vichardhahra2">
                                                    <label class="custom-control-label" for="vichardhahra2">
                                                    किसान आंदोलन 	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>  
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vichardhahra" value="धारा 370 (कश्मीर)" id="vichardhahra3">
                                                    <label class="custom-control-label" for="vichardhahra3">
                                                    धारा 370 (कश्मीर) 	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>                                       
                                               
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">आपके हिसाब से किस सरकार ने महामारी के दौरान अच्छा काम किया ? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="corona" value="अशोक गहलोत सरकार " id="corona1">
                                                    <label class="custom-control-label" for="corona1">
                                                    अशोक गहलोत सरकार 	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="corona" value="मोदी सरकार" id="corona2">
                                                    <label class="custom-control-label" for="corona2">
                                                    मोदी सरकार 	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>                                                                                   
                                              </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">आपके गँवा/ वार्ड में किस राजनीतिक दल के कार्यकर्ता ज्यादा सक्रिय हैं?</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="कांग्रेस" id="active_karyakarta1">
                                                    <label class="custom-control-label" for="active_karyakarta1">
                                                    कांग्रेस	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="भारतीय जनता पार्टी" id="active_karyakarta2">
                                                    <label class="custom-control-label" for="active_karyakarta2">
                                                    भारतीय जनता पार्टी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="जनता सेना" id="active_karyakarta3">
                                                    <label class="custom-control-label" for="active_karyakarta3">
                                                    जनता सेना	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="राष्ट्रीय लोकतांत्रिक पार्टी" id="active_karyakarta4">
                                                    <label class="custom-control-label" for="active_karyakarta4">
                                                    राष्ट्रीय लोकतांत्रिक पार्टी</label>
                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="बहुजन समाज पार्टी" id="active_karyakarta5">
                                                    <label class="custom-control-label" for="active_karyakarta5">
                                                    बहुजन समाज पार्टी &nbsp;&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="अन्य" id="active_karyakarta6">
                                                    <label class="custom-control-label" for="active_karyakarta6">
                                                    अन्य</label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">आने वाले विधानसभा चुनाव में आप किस पार्टी को जीतते देखना चाहते है? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="कांग्रेस" id="vidhansabha_20231">
                                                    <label class="custom-control-label" for="vidhansabha_20231">
                                                    कांग्रेस	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="भारतीय जनता पार्टी" id="vidhansabha_20232">
                                                    <label class="custom-control-label" for="vidhansabha_20232">
                                                    भारतीय जनता पार्टी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="जनता सेना" id="vidhansabha_20233">
                                                    <label class="custom-control-label" for="vidhansabha_20233">
                                                    जनता सेना	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="राष्ट्रीय लोकतांत्रिक पार्टी" id="vidhansabha_20234">
                                                    <label class="custom-control-label" for="vidhansabha_20234">
                                                    राष्ट्रीय लोकतांत्रिक पार्टी</label>
                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="बहुजन समाज पार्टी" id="vidhansabha_20235">
                                                    <label class="custom-control-label" for="vidhansabha_20235">
                                                    बहुजन समाज पार्टी &nbsp;&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="अन्य" id="vidhansabha_20236">
                                                    <label class="custom-control-label" for="vidhansabha_20236">
                                                    अन्य</label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">जाति </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Caste" name="caste">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">श्रेणी </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="caste_categories" value="एससी" id="caste_categories1">
                                                    <label class="custom-control-label" for="caste_categories1">
                                                    एससी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="caste_categories" value="एसटी" id="caste_categories2">
                                                    <label class="custom-control-label" for="caste_categories2">
                                                    एसटी 	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="caste_categories" value="ओबीसी" id="caste_categories3">
                                                    <label class="custom-control-label" for="caste_categories3">
                                                    ओबीसी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="caste_categories" value="सामान्य" id="caste_categories4">
                                                    <label class="custom-control-label" for="caste_categories4">
                                                    सामान्य </label>
                                                </div>
                                               
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3">
                                    <div class="col-lg-7 offset-lg-5">
                                        <div class="form-group mt-2">
                                            <button type="submit"
                                                class="btn btn-lg btn-primary" name="submit">Save</button><br><br><br>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- card -->
                </div><!-- .nk-block -->
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
    jQuery(document).ready(function($) {
        $('.disableKeyPress').bind('keypress', function(e) {
            e.preventDefault();
        });
    });

    function AvoidSpace(event) {
        var k = event ? event.which : window.event.keyCode;
        if (k == 32) return false;
    }

    function validateEmail(emailField) {
        var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

        if (reg.test(emailField.value) == false) {
            document.getElementById("admin_email").style.border = "2px solid #ff0000";
            return false;
        }
        document.getElementById("admin_email").style.border = "";
        return true;
    }
    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>

</html>