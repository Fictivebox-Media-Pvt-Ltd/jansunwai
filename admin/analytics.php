<?php
include_once '../configs/includes.php';

$filters = array();
if(!empty($_POST['date_filter']) && isset($_POST['date_filter'])){
    $filters['loksabha'] = $_POST['loksabha'];
    $filters['vidhansabha'] = $_POST['vidhansabha'];
    $filters['mandal'] = $_POST['mandal'];
    $filters['panchayat'] = $_POST['panchayat'];
    $filters['boothRange'] = str_replace(' ', '', $_POST['boothRange']);
    $filters['ward'] = $_POST['ward'];
    $filters['gender'] = $_POST['gender'];
    $filters['ageGroup'] = $_POST['ageGroup'];
    $filters['category'] = $_POST['category'];
    $filters['caste'] = $_POST['caste'];
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
    $deptName = get_department_details($conn, $deptId);
}

$loksabhaList = array();
if($assignedLoksabha != ''){
    $loksabhaList[] = $assignedLoksabha;
}else{
    $loksabhaList[] = 'चित्तौड़गढ़';
}
$category_list = get_category_list($conn);

//$g1 = get_g1($conn,$filters); // Current Gov

$g2 = get_g2($conn,$filters); // Pesha
asd($g2);
$g3 = get_g3($conn,$filters); // Pramukh Mudde
$g4 = get_g4($conn,$filters);
$g5 = get_g5($conn,$filters);
$g6 = get_g6($conn,$filters);
$g7 = get_g7($conn,$filters);
$g8 = get_g8($conn,$filters);
$g9 = get_g9($conn,$filters);
$g10 = get_g10($conn,$filters);
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
                                        <div class="nk-block-head" style="padding-bottom: 0px;">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title">Data Analytics</h4>
                                            </div>
                                            <div class="form-group" style="margin-top: 15px;">
                                                <label class="form-label" style="padding-top: 5px;font-size: 17px;margin-bottom:4px;">Apply Data Filters: </label>
                                                <span class="form-note" style="margin-bottom:10px">`लोकसभा` to `वार्ड` filters are highly data-sensitive. Select them from Left to Right order only, after every page load. </span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                        <form method="POST" class="form-validate" id="myForm">
                                            <div class="row g-12">
                                                <div class="col-lg-2">
                                                    <div class="form-group">                                                   
                                                        <div class="form-control-wrap">
                                                            <select id="loksabha" name="loksabha" class="form-control" required>
                                                            <?php if(!empty($filters['loksabha'])){ ?>
                                                                <option value="<?php echo $filters['loksabha']?>" selected ><?php echo $filters['loksabha'].'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>लोकसभा</option>
                                                                <?php foreach($loksabhaList as $key => $value){ ?>
                                                                    <option value="<?php echo $value ?>"><?php echo $value ?></option>
                                                                <?php } ?>
                                                            <?php }?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="vidhansabha" class="form-control" id="vidhansabha_list">
                                                            <?php if(!empty($filters['vidhansabha'])){ ?>
                                                                <option value="<?php echo $filters['vidhansabha']?>" selected ><?php echo $filters['vidhansabha'].'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>विधानसभा</option>
                                                            <?php }?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>                                               
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="mandal" class="form-control" id="mandal_list">
                                                            <?php if(!empty($filters['mandal'])){ ?>
                                                                <option value="<?php echo $filters['mandal']?>" selected ><?php echo $filters['mandal'].'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>मंडल</option>
                                                            <?php }?>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="panchayat" class="form-control" id="panchayat_list">
                                                            <?php if(!empty($filters['panchayat'])){ ?>
                                                                <option value="<?php echo $filters['panchayat']?>" selected><?php echo $filters['panchayat'].'✓'?></option>
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
                                                            <?php if(!empty($filters['boothRange'])){ ?>
                                                                <option value="<?php echo $filters['boothRange']?>" selected><?php echo $filters['boothRange'].'✓'?></option>
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
                                                        <select name="ward" class="form-control" id="ward_list">
                                                            <?php if(!empty($filters['ward'])){ ?>
                                                                <option value="<?php echo $filters['ward']?>" selected ><?php echo $filters['ward'].'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>वार्ड</option>
                                                            <?php }?>                                                            
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
                                                            <select name="gender" class="form-control" id="selectGender">
                                                            <?php if(!empty($filters['gender'])){ ?>
                                                                <option value="<?php echo $filters['gender']?>" selected><?php echo $filters['gender'].'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>Gender</option>
                                                            <?php }?>      
                                                                <option value="M">M</option>
                                                                <option value="F">F</option>
                                                                <option value="O">O</option>
                                                                <option value="T">T</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="ageGroup" class="form-control" id="ageGroup">
                                                            <?php if(!empty($filters['ageGroup'])){ ?>
                                                                <option value="<?php echo $filters['ageGroup']?>" selected><?php echo $filters['ageGroup'].'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>Age Group</option>
                                                            <?php }?>    
                                                            <option value="18~25">18 ~ 25</option>
                                                            <option value="26~35">26 ~ 35</option>
                                                            <option value="36~45">36 ~ 45</option>
                                                            <option value="46~55">46 ~ 55</option>
                                                            <option value="56~120">56 ~ 120</option>
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <select name="category" class="form-control" id="category">
                                                            <?php if(!empty($filters['category'])){ ?>
                                                                <option value="<?php echo $filters['category']?>" selected><?php echo $filters['category'].'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>Category</option>
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
                                                            <?php if(!empty($filters['caste'])){ ?>
                                                                <option value="<?php echo $filters['caste']?>" selected><?php echo $filters['caste'].'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>Caste</option>
                                                            <?php }?> 
                                                        </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                            <button style="min-width:-webkit-fill-available;justify-content:center" type="submit" name="date_filter" value="applied" class="btn btn-outline-primary">Apply</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-2">
                                                    <div class="form-group">
                                                        <div class="form-control-wrap">
                                                        <input type="button" class="btn btn-outline-warning" style="min-width:-webkit-fill-available;justify-content:center" onclick="myFunction()" value="Reset">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        </div>
                                        <br/>
                                        <?php 
                                            $isNoData = count($g2) ? '' : 'hidden'; 
                                            $divForNoData = count($g2) ? 'hidden' : '';
                                        ?>
                                        <figure class="highcharts-figure">
                                            <div id="g2" <?php  echo $isNoData;?>></div>
                                            <div <?php  echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                <p style="padding-top: 10px;">मुख्य पेशा</p>
                                                <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                <p style="padding-top: 5px;">Try to change data filters.!</p>
                                            </div>
                                        </figure>
                                        <?php 
                                            $isNoData = count($g3) ? '' : 'hidden'; 
                                            $divForNoData = count($g3) ? 'hidden' : '';
                                        ?>
                                        <figure class="highcharts-figure">
                                            <div id="g3" <?php  echo $isNoData;?>></div>
                                            <div <?php  echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                <p style="padding-top: 10px;">प्रमुख मुद्दे</p>
                                                <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                <p style="padding-top: 5px;">Try to change data filters.!</p>
                                            </div>
                                        </figure>
                                        <?php 
                                            $isNoData = count($g1) ? '' : 'hidden'; 
                                            $divForNoData = count($g1) ? 'hidden' : '';
                                        ?>
                                        <figure class="highcharts-figure">
                                            <div id="g1" <?php  echo $isNoData;?>></div>
                                            <div <?php  echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                <p style="padding-top: 10px;">वर्तमान की राज्य सरकार के कार्य को आप कैसे देखते है?</p>
                                                <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                <p style="padding-top: 5px;">Try to change data filters.!</p>
                                            </div>
                                        </figure>
                                        <?php 
                                            $isNoData = count($g4) ? '' : 'hidden'; 
                                            $divForNoData = count($g4) ? 'hidden' : '';
                                        ?>
                                        <figure class="highcharts-figure">
                                            <div id="g4" <?php  echo $isNoData;?>></div>
                                            <div <?php  echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                <p style="padding-top: 10px;">2019 लोकसभा चुनाव में किस पार्टी को वोट दिया?</p>
                                                <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                <p style="padding-top: 5px;">Try to change data filters.!</p>
                                            </div>
                                        </figure>
                                        <?php 
                                            $isNoData = count($g5) ? '' : 'hidden'; 
                                            $divForNoData = count($g5) ? 'hidden' : '';
                                        ?>
                                        <figure class="highcharts-figure">
                                            <div id="g5" <?php  echo $isNoData;?>></div>
                                            <div <?php  echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                <p style="padding-top: 10px;">2018 विधानसभा चुनाव में किस पार्टी को वोट दिया?</p>
                                                <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                <p style="padding-top: 5px;">Try to change data filters.!</p>
                                            </div>
                                        </figure>
                                        <?php 
                                            $isNoData = count($g6) ? '' : 'hidden'; 
                                            $divForNoData = count($g6) ? 'hidden' : '';
                                        ?>
                                        <figure class="highcharts-figure">
                                            <div id="g6" <?php  echo $isNoData;?>></div>
                                            <div <?php  echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                <p style="padding-top: 10px;">2018 में आपके वोट देने का कारण?</p>
                                                <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                <p style="padding-top: 5px;">Try to change data filters.!</p>
                                            </div>
                                        </figure>
                                        <?php 
                                            $isNoData = count($g7) ? '' : 'hidden'; 
                                            $divForNoData = count($g7) ? 'hidden' : '';
                                        ?>
                                        <figure class="highcharts-figure">
                                            <div id="g7" <?php  echo $isNoData;?>></div>
                                            <div <?php  echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                <p style="padding-top: 10px;">विचारधारा</p>
                                                <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                <p style="padding-top: 5px;">Try to change data filters.!</p>
                                            </div>
                                        </figure>
                                        <?php 
                                            $isNoData = count($g8) ? '' : 'hidden'; 
                                            $divForNoData = count($g8) ? 'hidden' : '';
                                        ?>
                                        <figure class="highcharts-figure">
                                            <div id="g8" <?php  echo $isNoData;?>></div>
                                            <div <?php  echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                <p style="padding-top: 10px;">किस सरकार ने कोरोना महामारी के दौरान अच्छा काम किया?</p>
                                                <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                <p style="padding-top: 5px;">Try to change data filters.!</p>
                                            </div>
                                        </figure>
                                        <?php 
                                            $isNoData = count($g9) ? '' : 'hidden'; 
                                            $divForNoData = count($g9) ? 'hidden' : '';
                                        ?>
                                        <figure class="highcharts-figure">
                                            <div id="g9" <?php  echo $isNoData;?>></div>
                                            <div <?php  echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                <p style="padding-top: 10px;">वार्ड में किस राजनीतिक दल के कार्यकर्ता ज्यादा सक्रिय हैं?</p>
                                                <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                <p style="padding-top: 5px;">Try to change data filters.!</p>
                                            </div>
                                        </figure>
                                        <?php 
                                            $isNoData = count($g10) ? '' : 'hidden'; 
                                            $divForNoData = count($g10) ? 'hidden' : '';
                                        ?>
                                        <figure class="highcharts-figure">
                                            <div id="g10" <?php  echo $isNoData;?>></div>
                                            <div <?php  echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                <p style="padding-top: 10px;">आने वाले विधानसभा चुनाव में आप किस पार्टी को जीतते देखना चाहते है?</p>
                                                <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                <p style="padding-top: 5px;">Try to change data filters.!</p>
                                            </div>
                                        </figure>
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
function myFunction() {  
    $('#ageGroup').prop('selectedIndex',0);
    $('#category').prop('selectedIndex',0);
    $('#caste_list').prop('selectedIndex',0);
    $('#selectGender').prop('selectedIndex',0);
    $('#ward_list').prop('selectedIndex',0);
    $('#booth_range').prop('selectedIndex',0);
    $('#panchayat_list').prop('selectedIndex',0);
    $('#mandal_list').prop('selectedIndex',0);
    $('#vidhansabha_list').prop('selectedIndex',0);
    $('#loksabha').prop('selectedIndex',0);
}
</script>


    <script type="text/javascript">

        
      $(document).ready(function(){
        $("#loksabha").click(function(){
            var loksabha = $(this).val();
            $.ajax({
                url: 'service_fetch_vidhansabha.php',
                type: 'post',
                data: {loksabha:loksabha},
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    $("#vidhansabha_list").empty();
                    $("#vidhansabha_list").append('<option value="" selected disabled hidden>विधानसभा</option>');
                    for( var i = 0; i<len; i++){
                        var name = response[i];
                        $("#vidhansabha_list").append("<option value='"+name+"'>"+name+"</option>");
                    }
                }
            });
        });
        $("#vidhansabha_list").click(function(){
            var vidhansabha = $(this).val();
            $.ajax({
                url: 'service_fetch_mandal.php',
                type: 'post',
                data: {vidhansabha:vidhansabha},
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    $("#mandal_list").empty();
                    $("#mandal_list").append('<option value="" selected disabled hidden>मंडल</option>');
                    for( var i = 0; i<len; i++){
                        var name = response[i];
                        $("#mandal_list").append("<option value='"+name+"'>"+name+"</option>");
                    }
                }
            });
        });
        });
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
        $("#booth_range").click(function(e){
            e.preventDefault();
                toastr.clear();
                NioApp.Toast('<h5>We\'re preparing the data for Ward(वार्ड) dropdown</h5><p>Estimated wait time: <b>15 Seconds</b></p>', 'info', {
                position: 'top-center',
                timeOut: 30000
            });
            e.preventDefault();
            var booth_range = $(this).val();
            $.ajax({
                url: 'service_fetch_wards.php',
                type: 'post',
                data: {booth_range:booth_range},
                dataType: 'json',
                success:function(response){
                    var len = response.length;
                    $("#ward_list").empty();
                    $("#ward_list").append('<option value="" selected disabled hidden>वार्ड</option>');
                    for( var i = 0; i<len; i++){
                        var name = response[i];
                        $("#ward_list").append("<option value='"+name+"'>"+name+"</option>");
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
                    $("#caste_list").append('<option value="" selected disabled hidden>Caste</option>');
                    for( var i = 0; i<len; i++){
                        var name = response[i];
                        $("#caste_list").append("<option value='"+name+"'>"+name+"</option>");
                    }
                }
            });
        });
        // Graphs Start
        Highcharts.chart('g1', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'वर्तमान की राज्य सरकार के कार्य को आप कैसे देखते है?'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                showInLegend: true,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
                }
            },
            series: [{
                name: 'Rating',
                colorByPoint: true,
                data: <?php echo json_encode($g1); ?>
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadJPEG',
                            'downloadPDF',
                        ]
                    }
                }
            },
            credits: {
                enabled: false
            }
            });
            Highcharts.chart('g2', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'मुख्य पेशा'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                showInLegend: true,
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
                }
            },
            series: [{
                name: 'Percentage',
                colorByPoint: true,
                data: <?php echo json_encode($g2); ?>
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadJPEG',
                            'downloadPDF',
                        ]
                    }
                }
            },
            credits: {
                enabled: false
            }
            });
            Highcharts.chart('g3', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'प्रमुख मुद्दे'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                showInLegend: true,
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
                }
            },
            series: [{
                name: 'Percentage',
                colorByPoint: true,
                data: <?php echo json_encode($g3); ?>
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadJPEG',
                            'downloadPDF',
                        ]
                    }
                }
            },
            credits: {
                enabled: false
            }
            });
            Highcharts.chart('g4', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '2019 लोकसभा चुनाव में किस पार्टी को वोट दिया?'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                showInLegend: true,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
                }
            },
            series: [{
                name: 'Rating',
                colorByPoint: true,
                data: <?php echo json_encode($g4); ?>
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadJPEG',
                            'downloadPDF',
                        ]
                    }
                }
            },
            credits: {
                enabled: false
            }
            });
            Highcharts.chart('g5', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '2018 विधानसभा चुनाव में किस पार्टी को वोट दिया?'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                showInLegend: true,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
                }
            },
            series: [{
                name: 'Rating',
                colorByPoint: true,
                data: <?php echo json_encode($g5); ?>
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadJPEG',
                            'downloadPDF',
                        ]
                    }
                }
            },
            credits: {
                enabled: false
            }
            });
            Highcharts.chart('g6', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '2018 में आपके वोट देने का कारण?'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                showInLegend: true,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
                }
            },
            series: [{
                name: 'Rating',
                colorByPoint: true,
                data: <?php echo json_encode($g6); ?>
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadJPEG',
                            'downloadPDF',
                        ]
                    }
                }
            },
            credits: {
                enabled: false
            }
            });
            Highcharts.chart('g7', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'विचारधारा'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                showInLegend: true,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
                }
            },
            series: [{
                name: 'Rating',
                colorByPoint: true,
                data: <?php echo json_encode($g7); ?>
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadJPEG',
                            'downloadPDF',
                        ]
                    }
                }
            },
            credits: {
                enabled: false
            }
            });
            Highcharts.chart('g8', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'किस सरकार ने कोरोना महामारी के दौरान अच्छा काम किया?'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                showInLegend: true,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
                }
            },
            series: [{
                name: 'Rating',
                colorByPoint: true,
                data: <?php echo json_encode($g8); ?>
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadJPEG',
                            'downloadPDF',
                        ]
                    }
                }
            },
            credits: {
                enabled: false
            }
            });
            Highcharts.chart('g9', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'वार्ड में किस राजनीतिक दल के कार्यकर्ता ज्यादा सक्रिय हैं?'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                showInLegend: true,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
                }
            },
            series: [{
                name: 'Rating',
                colorByPoint: true,
                data: <?php echo json_encode($g9); ?>
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadJPEG',
                            'downloadPDF',
                        ]
                    }
                }
            },
            credits: {
                enabled: false
            }
            });
            Highcharts.chart('g10', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'आने वाले विधानसभा चुनाव में आप किस पार्टी को जीतते देखना चाहते है?'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            accessibility: {
                point: {
                valueSuffix: '%'
                }
            },
            plotOptions: {
                pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                showInLegend: true,
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %'
                }
                }
            },
            series: [{
                name: 'Rating',
                colorByPoint: true,
                data: <?php echo json_encode($g10); ?>
            }],
            exporting: {
                buttons: {
                    contextButton: {
                        menuItems: [
                            'downloadJPEG',
                            'downloadPDF',
                        ]
                    }
                }
            },
            credits: {
                enabled: false
            }
            });
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>
</html>