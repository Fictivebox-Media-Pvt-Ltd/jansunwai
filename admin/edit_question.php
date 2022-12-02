<?php
include_once '../configs/includes.php';
if(isset($_POST['selected_loksabha']) && isset($_POST['vidhansabha'])&& isset($_POST['question'])&& isset($_POST['question_option'])){
    addQuestion($conn,$_POST['selected_loksabha'],$_POST['vidhansabha'],$_POST['question'],$_POST['question_option']);
    
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
$details = getSurveyQuestion($conn,$_GET['id']);
// print_r($details);
// die;

$all_loksabhas = array();
$all_loksabhas = get_all_loksabha($conn);
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
                                            <h4 class="nk-block-title">Questions</h4>
                                        </div>
                                    </div>
                                    <div class="card card-preview w-100 py-3" style="width: max-content;">
                                    <form method="POST" class="gy-3">
                                        <div class="card-inner">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Loksabha</label>
                                                    <select name="selected_loksabha" id="loksabha" class="form-control">
                                                        <option value="<?php echo $details['loksabha']; ?>" selected disabled hidden><?php echo $details['loksabha'];?></option>                                                   
                                                    <?php foreach($all_loksabhas as $key => $value){?>
                                                        <option value="<?php echo $value['loksabha']; ?>"><?php echo $value['loksabha']; ?></option>
                                                    <?php } ?>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Vidhansabha</label>
                                                        <select name="vidhansabha" class="form-control" id="vidhansabha_list">
                                                            <?php if(!empty($details['vidhansabha'])){ ?>
                                                                <option value="<?php echo $details['vidhansabha']?>" selected ><?php echo $details['vidhansabha'].'✓'?></option>
                                                            <?php }else{ ?>
                                                                <option value="" selected disabled hidden>विधानसभा</option>
                                                            <?php }?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 align-self-end">
                                                    <div class="form-group mb-3">
                                                        <label class="form-label">Question</label>
                                                        <textarea name="question" id="" rows="5"
                                                            class="form-control"><?php echo $details['question'];?> </textarea>
                                                    </div>
                                                </div>
                                            </div>                                           
                                            <!--<div class="row mb-3">
                                                <div class="col-md-9">
                                                    <div class="form-group">
                                                        <label cmainlass="form-label">Option 1</label>
                                                        <input type="text" class="form-control"
                                                            placeholder="Booth Range" name="">
                                                    </div>
                                                </div>
                                                <div class="col-md-3 align-self-end">
                                                    <button name="import" type="submit"
                                                        class="btn btn-lg btn-success">Add</button>
                                                    <button name="import" type="submit"
                                                        class="btn btn-lg btn-danger">Remove</button>
                                                </div>
                                            </div>-->
                                            <div id="add-more-per" class="mb-3">
                                        <?php 
                                        $option = $details['option'];
                                            foreach($option as $key => $value){
                                                if(!empty($value)){
                                                    ?>
                                                    <div class="form-row">
                                                        <div class="col-md-10">
                                                            <div class="form-group">
                                                                <label class="form-label">Option 1</label>
                                                                <input type="hidden" id="count" value="<?php echo $x;?>">
                                                                <input class="form-control" name="question_option[]" id="question_option" value="<?php echo $value;?>">              
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 align-self-end">
                                                        <a href="javascript:void(0)" onclick="addRemovePermissions()">
                                                                    <span name="" class="btn btn-lg btn-success">Add<span></a>                                                        
                                                        </div>
                                                    </div>
                                        <?php
                                                }
                                            }                                                
                                        ?>                                                
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12 text-end">
                                                    <button name="submit" id="" type="submit"
                                                        class="btn btn-lg btn-primary">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                     </form>
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
    function addRemovePermissions() {
        var max_fields = 10;
        var wrapper = $("#add-more-per");
        var x =  $("#count").val();
        alert(x);
        x++;
        if (x <= max_fields) {
            $(wrapper).append('<div id="deleteRow" class="mb-3"><div class="access-body accordion__body collapse show" id="user_permission" data-parent="#accordion-user-permission" style=""> <div class="form-row" id="add-more-per"> <div class="col-md-10"> <div class="form-group"> <label class="form-label">Option '+x+' </label> <input class="form-control" name="question_option[]" id="question_option'+x+'"></div> </div> <div class="col-md-2 align-self-end"> <a href="javascript:void(0)" onclick="addRemovePermissions()"> <span name=""  class="btn btn-lg btn-success">Add</span></a> <a href="javascript:void(0)" class="remove_field_beg"> <span name="import" class="btn btn-lg btn-danger">Remove</span></a>  </div> </div> </div> </div>');
            $("#count").val(x);
    }
}
$(document).on('click', '.remove_field_beg', function () {
    $(this).closest('#deleteRow').remove();
    var counter = $('#count').val();
    var new_counter = counter-1;
    $('#count').val(new_counter);
});
</script>

    <script>
        $(document).ready(function() {
            $("#loksabha").click(function(){
                var loksabha = $(this).val();
                $.ajax({
                    url: 'serviceFetchVidhansabha.php',
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
        });
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>

</html>