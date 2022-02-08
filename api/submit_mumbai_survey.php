<?php
include_once '../configs/database.php';

if(isset($_GET['voter_id'])){
        $voter_id = $_GET['voter_id'];
        $pesha = isset($_GET['pesha']) ? $_GET['pesha'] : '';
        $makaan = isset($_GET['makaan']) ? $_GET['makaan'] : '';
        $mobile = isset($_GET['mobile']) ? $_GET['mobile'] : '';
        $whatsapp = isset($_GET['whatsapp']) ? $_GET['whatsapp'] : '';
        $mojudaa_sarkaar = isset($_GET['mojudaa_sarkaar']) ? $_GET['mojudaa_sarkaar'] : '';
        $mojudaa_vidhayak = isset($_GET['mojudaa_vidhayak']) ? $_GET['mojudaa_vidhayak'] : '';
        $mudde = isset($_GET['mudde']) ? $_GET['mudde'] : '';
        $bmc_chunaw = isset($_GET['bmc_chunaw']) ? $_GET['bmc_chunaw'] : '';
        $party_vs_umeedwar = isset($_GET['party_vs_umeedwar']) ? $_GET['party_vs_umeedwar'] : '';
        $parshad_ka_karya = isset($_GET['parshad_ka_karya']) ? $_GET['parshad_ka_karya'] : '';
        $if_bad_then_why = isset($_GET['if_bad_then_why']) ? $_GET['if_bad_then_why'] : '';
        $bmc_chunaw_2021 = isset($_GET['bmc_chunaw_2021']) ? $_GET['bmc_chunaw_2021'] : '';
        $bmc_chunaw_mudde = isset($_GET['bmc_chunaw_mudde']) ? $_GET['bmc_chunaw_mudde'] : '';
        $ward_parshad_kon = isset($_GET['ward_parshad_kon']) ? $_GET['ward_parshad_kon'] : '';
        $bmc_chunaw_gathbandhan = isset($_GET['bmc_chunaw_gathbandhan']) ? $_GET['bmc_chunaw_gathbandhan'] : '';
        $social_media = isset($_GET['social_media']) ? $_GET['social_media'] : '';
        $dharm = isset($_GET['dharm']) ? $_GET['dharm'] : '';
        $jaati = isset($_GET['jaati']) ? $_GET['jaati'] : '';
        $shredi = isset($_GET['shredi']) ? $_GET['shredi'] : '';
        $samudaye = isset($_GET['samudaye']) ? $_GET['samudaye'] : '';
        $surveyed_by = $_GET['surveyed_by'];

}else{
        echo true;
        return;
}

$query="INSERT IGNORE INTO `tbl_mumbai_voter_survey` (`voter_id`, `pesha`, `makaan`, `mobile`, `whatsapp`, `mojudaa_sarkaar`, `mojudaa_vidhayak`, `mudde`, `bmc_chunaw`, `party_vs_umeedwar`, `parshad_ka_karya`, `if_bad_then_why`, `bmc_chunaw_2021`, `bmc_chunaw_mudde`, `ward_parshad_kon`, `bmc_chunaw_gathbandhan`, `social_media`, `dharm`, `jaati`, `shredi`, `samudaye`, `surveyed_by`, `created_at`)
VALUES ('$voter_id', '$pesha', '$makaan', '$mobile', '$whatsapp', '$mojudaa_sarkaar', '$mojudaa_vidhayak', '$mudde', '$bmc_chunaw', '$party_vs_umeedwar', '$parshad_ka_karya', '$if_bad_then_why', '$bmc_chunaw_2021', '$bmc_chunaw_mudde', '$ward_parshad_kon', '$bmc_chunaw_gathbandhan', '$social_media', '$dharm', '$jaati', '$shredi', '$samudaye', '$surveyed_by', now())";

$ph_no_validation = "SELECT COUNT(id) AS 'NumberExist' FROM `tbl_mumbai_voter_survey` WHERE `mobile` = '$mobile'";
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