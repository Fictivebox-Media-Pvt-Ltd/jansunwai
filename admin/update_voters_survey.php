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
    $voter_details = get_survey_details($conn,$voter_id);

}
if(isset($_GET['id'])){
    $voter_id=$_GET['id'];
    $pesha = isset($_POST['pesha']) ? $_POST['pesha'] : ''; 
    $mobile_no = isset($_POST['mobile_no']) ? $_POST['mobile_no'] : '';
    $whatsapp_no = isset($_POST['whatsapp_no']) ? $_POST['whatsapp_no'] : '';
    $pramukh_mudde= isset($_POST['pramukh_mudde']) ? $_POST['pramukh_mudde'] : '';
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
        update_voter_survey($conn,$voter_id,$pesha,$mobile_no,$whatsapp_no,$pramukh_mudde,$rating_current_govt,$voted_2019_loksabha,$voted_2018_vidhansabha,$vote_reason_2018,$vichardhahra,$corona,$active_karyakarta,$vidhansabha_2023,$caste,$caste_categories);
    }
    
}
// asd($voter_details);
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
                                        <label class="form-label">1. बूथ नो०</label>
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
                                        <label class="form-label">2. नाम</label>
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
                                        <label class="form-label">3. पिता/पति का नाम </label>
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
                                        <label class="form-label">4. मकान स०</label>
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
                                            <label class="form-label">5. मुख्य पेशा </label>
                                            <span class="form-note">Select only one option.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="किसान"
                                                        class="custom-control-input" id="pesha1" 
                                                        <?php if(preg_match('~किसान~',$value['pesha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="pesha1">किसान
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="व्यवसाय"
                                                        class="custom-control-input" id="pesha2"
                                                        <?php if(preg_match('~व्यवसाय~',$value['pesha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label"
                                                        for="pesha2">व्यवसाय</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="नौकरी"
                                                        class="custom-control-input" id="pesha3"
                                                        <?php if(preg_match('~नौकरी~',$value['pesha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="pesha3">नौकरी
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="मजदूर"
                                                        class="custom-control-input" id="pesha4"
                                                        <?php if(preg_match('~मजदूर~',$value['pesha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="pesha4">मजदूर
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="विद्यार्थी"
                                                        class="custom-control-input" id="pesha5"
                                                        <?php if(preg_match('~विद्यार्थी~',$value['pesha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="pesha5">विद्यार्थी
                                                    </label>
                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="बेरोजगार"
                                                        class="custom-control-input" id="pesha6"
                                                        <?php if(preg_match('~बेरोजगार~',$value['pesha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label"
                                                        for="pesha6">बेरोजगार</label>

                                                </div>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="गृहणी"
                                                        class="custom-control-input" id="pesha7"
                                                        <?php if(preg_match('~गृहणी~',$value['pesha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="pesha7">गृहणी
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="रिटायर्ड"
                                                        class="custom-control-input" id="pesha8"
                                                        <?php if(preg_match('~रिटायर्ड~',$value['pesha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="pesha8">रिटायर्ड
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pesha[]" value="कोई कार्य नही कर रहे"
                                                        class="custom-control-input" id="pesha9"
                                                        <?php if(preg_match('~कोई कार्य नही~',$value['pesha'])){ echo 'checked';} ?>
                                                        >
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
                                            <label class="form-label">6. मोबाइल न०</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" placeholder="Enter Mobile No." onkeypress="return isNumber(event)"
                                                    name="mobile_no" maxlength="10" value="<?php echo $value['mobile_no']?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">7. व्हाट्सएप्प न०</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control" onkeypress="return isNumber(event)"
                                                    placeholder="Enter whatsapp Number" name="whatsapp_no" maxlength="10" value="<?php echo $value['whatsapp_no']?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">8. आपके गांव के तीन प्रमुख मुद्दे क्या है?</label>
                                            <span class="form-note">Select only three options.</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="सड़क"
                                                        class="custom-control-input" id="mudde1"
                                                        <?php if(preg_match('~सड़क~',$value['pramukh_mudde'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="mudde1">सड़क </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="बिजली"
                                                        class="custom-control-input" id="mudde2"
                                                        <?php if(preg_match('~बिजली~',$value['pramukh_mudde'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="mudde2">बिजली</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="पानी सप्लाई"
                                                        class="custom-control-input" id="mudde3"
                                                        <?php if(preg_match('~पानी~',$value['pramukh_mudde'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="mudde3">पानी सप्लाई
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="रोज़गार"
                                                        class="custom-control-input" id="mudde4"
                                                        <?php if(preg_match('~रोज़गार~',$value['pramukh_mudde'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="mudde4">रोज़गार
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="शिक्षा"
                                                        class="custom-control-input" id="mudde5"
                                                        <?php if(preg_match('~शिक्षा~',$value['pramukh_mudde'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="mudde5">शिक्षा
                                                    </label>
                                                </div>

                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]"
                                                        value="स्वास्थ्य सुविधएँ" class="custom-control-input" id="mudde6"
                                                        <?php if(preg_match('~स्वास्थ्य~',$value['pramukh_mudde'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="mudde6">स्वास्थ्य सुविधएँ</label>

                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="जल निकासी"
                                                        class="custom-control-input" id="mudde7"
                                                        <?php if(preg_match('~जल निकासी~',$value['pramukh_mudde'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="mudde7">जल निकासी
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="स्ट्रीट लाइट"
                                                        class="custom-control-input" id="mudde8"
                                                        <?php if(preg_match('~स्ट्रीट लाइट~',$value['pramukh_mudde'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="mudde8">स्ट्रीट लाइट
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]" value="कचरा प्रबंधन"
                                                        class="custom-control-input" id="mudde9"
                                                        <?php if(preg_match('~कचरा~',$value['pramukh_mudde'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="mudde9">कचरा प्रबंधन
                                                    </label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" name="pramukh_mudde[]"
                                                        value="लोकल ट्रांसपोर्ट" class="custom-control-input" id="mudde10"
                                                        <?php if(preg_match('~ट्रांसपोर्ट~',$value['pramukh_mudde'])){ echo 'checked';} ?>
                                                        >
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
                                            <label class="form-label">9. वर्तमान की राज्य सरकार के कार्य को आप कैसे देखते
                                                है? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Rating_Current_Govt" value="बढ़िया" id="Rating1"
                                                        <?php if(preg_match('~बढ़िया~',$value['rating_current_govt'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="Rating1">
                                                    बढ़िया &nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Rating_Current_Govt" value="संतोषजनक" id="Rating2"
                                                        <?php if(preg_match('~संतोषजनक~',$value['rating_current_govt'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="Rating2">
                                                    संतोषजनक &nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Rating_Current_Govt" value="बुरा" id="Rating3"
                                                        <?php if(preg_match('~बुरा~',$value['rating_current_govt'])){ echo 'checked';} ?>
                                                        >
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
                                            <label class="form-label">10. आपने 2019 लोकसभा चुनाव में किस पार्टी को वोट दिया था? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="कांग्रेस" id="voted1"
                                                        <?php if(preg_match('~कांग्रेस~',$value['voted_2019_loksabha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="voted1">
                                                    कांग्रेस	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="भारतीय जनता पार्टी" id="voted2"
                                                        <?php if(preg_match('~भारतीय~',$value['voted_2019_loksabha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="voted2">
                                                    भारतीय जनता पार्टी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="जनता सेना" id="voted3"
                                                        <?php if(preg_match('~जनता सेना~',$value['voted_2019_loksabha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="voted3">
                                                    जनता सेना	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="राष्ट्रीय लोकतांत्रिक पार्टी" id="voted4"
                                                        <?php if(preg_match('~राष्ट्रीय लोकतांत्रिक~',$value['voted_2019_loksabha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="voted4">
                                                    राष्ट्रीय लोकतांत्रिक पार्टी</label>
                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="बहुजन समाज पार्टी" id="voted5"
                                                        <?php if(preg_match('~बहुजन समाज~',$value['voted_2019_loksabha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="voted5">
                                                    बहुजन समाज पार्टी &nbsp;&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2019_loksabha" value="अन्य" id="voted6"
                                                        <?php if(preg_match('~अन्य~',$value['voted_2019_loksabha'])){ echo 'checked';} ?>
                                                        >
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
                                            <label class="form-label">11. आपने 2018 विधानसभा चुनाव में किस पार्टी को वोट दिया था? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="कांग्रेस" id="voted_vidhansabha1"
                                                        <?php if(preg_match('~कांग्रेस~',$value['voted_2018_vidhansabha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="voted_vidhansabha1">
                                                    कांग्रेस	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="भारतीय जनता पार्टी" id="voted_vidhansabha2"
                                                        <?php if(preg_match('~भारतीय जनता~',$value['voted_2018_vidhansabha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="voted_vidhansabha2">
                                                    भारतीय जनता पार्टी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="जनता सेना" id="voted_vidhansabha3"
                                                        <?php if(preg_match('~जनता सेना~',$value['voted_2018_vidhansabha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="voted_vidhansabha3">
                                                    जनता सेना	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="राष्ट्रीय लोकतांत्रिक पार्टी" id="voted_vidhansabha4"
                                                        <?php if(preg_match('~राष्ट्रीय लोकतांत्रिक~',$value['voted_2018_vidhansabha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="voted_vidhansabha4">
                                                    राष्ट्रीय लोकतांत्रिक पार्टी</label>
                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="बहुजन समाज पार्टी" id="voted_vidhansabha5"
                                                        <?php if(preg_match('~बहुजन समाज~',$value['voted_2018_vidhansabha'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="voted_vidhansabha5">
                                                    बहुजन समाज पार्टी &nbsp;&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="Voted_2018_vidhansabha" value="अन्य" id="voted_vidhansabha6"
                                                        <?php if(preg_match('~अन्य~',$value['voted_2018_vidhansabha'])){ echo 'checked';} ?>
                                                        >
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
                                            <label class="form-label">12. 2018 में आपके वोट देने का कारण पार्टी थी या उम्मीदवार थे ? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vote_reason_2018" value="पार्टी" id="vote_reason_20181"
                                                        <?php if(preg_match('~पार्टी~',$value['vote_reason_2018'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="vote_reason_20181">
                                                    पार्टी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vote_reason_2018" value="उम्मीदवार" id="vote_reason_20182"
                                                        <?php if(preg_match('~उम्मीदवार~',$value['vote_reason_2018'])){ echo 'checked';} ?>
                                                        >
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
                                            <label class="form-label">13. इनमें से कौन सा विषय आपके दिल के ज्यादा करीब है? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="vichardhahra[]" value="राम मंदिर" id="vichardhahra1"
                                                        <?php if(preg_match('~मंदिर~',$value['vichardhahra'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="vichardhahra1">
                                                    राम मंदिर	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="vichardhahra[]" value="किसान आंदोलन " id="vichardhahra2"
                                                        <?php if(preg_match('~किसान आंदोलन~',$value['vichardhahra'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="vichardhahra2">
                                                    किसान आंदोलन 	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>  
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input"
                                                        name="vichardhahra[]" value="धारा 370 (कश्मीर)" id="vichardhahra3"
                                                        <?php if(preg_match('~धारा 370~',$value['vichardhahra'])){ echo 'checked';} ?>
                                                        >
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
                                            <label class="form-label">14. आपके हिसाब से किस सरकार ने महामारी के दौरान अच्छा काम किया ? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="corona" value="अशोक गहलोत सरकार " id="corona1"
                                                        <?php if(preg_match('~गहलोत~',$value['corona'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="corona1">
                                                    अशोक गहलोत सरकार 	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="corona" value="मोदी सरकार" id="corona2"
                                                        <?php if(preg_match('~मोदी~',$value['corona'])){ echo 'checked';} ?>
                                                        >
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
                                            <label class="form-label">15. आपके गँवा/ वार्ड में किस राजनीतिक दल के कार्यकर्ता ज्यादा सक्रिय हैं?</label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="कांग्रेस" id="active_karyakarta1"
                                                        <?php if(preg_match('~कांग्रेस~',$value['active_karyakarta'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="active_karyakarta1">
                                                    कांग्रेस	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="भारतीय जनता पार्टी" id="active_karyakarta2"
                                                        <?php if(preg_match('~भारतीय~',$value['active_karyakarta'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="active_karyakarta2">
                                                    भारतीय जनता पार्टी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="जनता सेना" id="active_karyakarta3"
                                                        <?php if(preg_match('~जनता सेना~',$value['active_karyakarta'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="active_karyakarta3">
                                                    जनता सेना	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="राष्ट्रीय लोकतांत्रिक पार्टी" id="active_karyakarta4"
                                                        <?php if(preg_match('~राष्ट्रीय लोकतांत्रिक~',$value['active_karyakarta'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="active_karyakarta4">
                                                    राष्ट्रीय लोकतांत्रिक पार्टी</label>
                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="बहुजन समाज पार्टी" id="active_karyakarta5"
                                                        <?php if(preg_match('~बहुजन समाज~',$value['active_karyakarta'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="active_karyakarta5">
                                                    बहुजन समाज पार्टी &nbsp;&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="active_karyakarta" value="अन्य" id="active_karyakarta6"
                                                        <?php if(preg_match('~अन्य~',$value['active_karyakarta'])){ echo 'checked';} ?>
                                                        >
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
                                            <label class="form-label">16. आने वाले विधानसभा चुनाव में आप किस पार्टी को जीतते देखना चाहते है? </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="कांग्रेस" id="vidhansabha_20231"
                                                        <?php if(preg_match('~कांग्रेस~',$value['vidhansabha_2023'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="vidhansabha_20231">
                                                    कांग्रेस	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="भारतीय जनता पार्टी" id="vidhansabha_20232"
                                                        <?php if(preg_match('~भारतीय~',$value['vidhansabha_2023'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="vidhansabha_20232">
                                                    भारतीय जनता पार्टी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="जनता सेना" id="vidhansabha_20233"
                                                        <?php if(preg_match('~जनता सेना~',$value['vidhansabha_2023'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="vidhansabha_20233">
                                                    जनता सेना	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="राष्ट्रीय लोकतांत्रिक पार्टी" id="vidhansabha_20234"
                                                        <?php if(preg_match('~राष्ट्रीय लोकतांत्रिक~',$value['vidhansabha_2023'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="vidhansabha_20234">
                                                    राष्ट्रीय लोकतांत्रिक पार्टी</label>
                                                </div>
                                                <br><br>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="बहुजन समाज पार्टी" id="vidhansabha_20235"
                                                        <?php if(preg_match('~बहुजन समाज~',$value['vidhansabha_2023'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="vidhansabha_20235">
                                                    बहुजन समाज पार्टी &nbsp;&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="vidhansabha_2023" value="अन्य" id="vidhansabha_20236"
                                                        <?php if(preg_match('~अन्य~',$value['vidhansabha_2023'])){ echo 'checked';} ?>
                                                        >
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
                                            <label class="form-label">17. जाति </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" class="form-control"
                                                    placeholder="Enter Caste" name="caste"  value="<?php echo $value['caste']?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label">18. श्रेणी </label>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                    <div class="g-3 align-center flex-wrap">
                                            <div class="g">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="caste_categories" value="एससी" id="caste_categories1"
                                                        <?php if(preg_match('~एससी~',$value['caste_categories'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="caste_categories1">
                                                    एससी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="caste_categories" value="एसटी" id="caste_categories2"
                                                        <?php if(preg_match('~एसटी~',$value['caste_categories'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="caste_categories2">
                                                    एसटी 	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="caste_categories" value="ओबीसी" id="caste_categories3"
                                                        <?php if(preg_match('~ओबीसी~',$value['caste_categories'])){ echo 'checked';} ?>
                                                        >
                                                    <label class="custom-control-label" for="caste_categories3">
                                                    ओबीसी	&nbsp;	&nbsp;&nbsp;</label>
                                                </div>
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" class="custom-control-input"
                                                        name="caste_categories" value="सामान्य" id="caste_categories4"
                                                        <?php if(preg_match('~सामान्य~',$value['caste_categories'])){ echo 'checked';} ?>
                                                        >
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
                                                class="btn btn-lg btn-primary" name="submit">Update</button><br><br><br>
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
    function isNumber(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>

</html>