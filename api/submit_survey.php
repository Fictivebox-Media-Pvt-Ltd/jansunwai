<?php
include_once '../configs/database.php';

if(isset($_GET['voter_id'])){
        $voter_id = $_GET['voter_id'];
        $pesha = isset($_GET['pesha']) ? $_GET['pesha'] : '';
        $mobile_no = isset($_GET['mobile_no']) ? $_GET['mobile_no'] : '';
        $whatsapp_no = isset($_GET['whatsapp_no']) ? $_GET['whatsapp_no'] : '';
        $pramukh_mudde = isset($_GET['pramukh_mudde']) ? $_GET['pramukh_mudde'] : '';
        $rating_current_govt = isset($_GET['rating_current_govt']) ? $_GET['rating_current_govt'] : '';
        $voted_2019_loksabha = isset($_GET['voted_2019_loksabha']) ? $_GET['voted_2019_loksabha'] : '';
        $voted_2018_vidhansabha = isset($_GET['voted_2018_vidhansabha']) ? $_GET['voted_2018_vidhansabha'] : '';
        $vote_reason_2018 = isset($_GET['vote_reason_2018']) ? $_GET['vote_reason_2018'] : '';
        $vichardhahra = isset($_GET['vichardhahra']) ? $_GET['vichardhahra'] : '';
        $corona = isset($_GET['corona']) ? $_GET['corona'] : '';
        $active_karyakarta = isset($_GET['active_karyakarta']) ? $_GET['active_karyakarta'] : '';
        $vidhansabha_2023 = isset($_GET['vidhansabha_2023']) ? $_GET['vidhansabha_2023'] : '';
        $caste = isset($_GET['caste']) ? $_GET['caste'] : '';
        $caste_categories = isset($_GET['caste_categories']) ? $_GET['caste_categories'] : '';
        $surveyed_by = $_GET['surveyed_by'];

}else{
        echo true;
        return;
}

$query="INSERT IGNORE INTO `tbl_voter_survey` (`voter_id`, `pesha`, `mobile_no`, `whatsapp_no`, `pramukh_mudde`, `rating_current_govt`, `voted_2019_loksabha`, `voted_2018_vidhansabha`, `vote_reason_2018`, `vichardhahra`, `corona`, `active_karyakarta`, `vidhansabha_2023`, `caste`, `caste_categories`,`created_at`,`surveyed_by`) VALUES ('$voter_id','$pesha','$mobile_no','$whatsapp_no','$pramukh_mudde','$rating_current_govt','$voted_2019_loksabha','$voted_2018_vidhansabha','$vote_reason_2018','$vichardhahra','$corona','$active_karyakarta','$vidhansabha_2023','$caste','$caste_categories', now(),'$surveyed_by')";

$ph_no_validation = "SELECT COUNT(id) AS 'NumberExist' FROM `tbl_voter_survey` WHERE `mobile_no` = '$mobile_no'";
$isNoExist = mysqli_query($conn,$ph_no_validation);
$numberExist = mysqli_fetch_assoc($isNoExist)['NumberExist'];

if(!$numberExist){
        mysqli_set_charset($conn,'utf8');
        mysqli_query($conn,$query) or die("Query problem".mysqli_error($conn));
        echo true;
}else{
        throw new Exception("Phone Number Already Exist!",403);
}
return;
?>