<?php
include_once '../configs/includes.php';

if(isset($_POST['delete_caste']) && isset($_POST['selected_location']) && isset($_POST['caste_name']) ){
    $caste_id = $_POST['caste_name'];
    delete_caste_from_map_stats($conn,$caste_id);
}

if(isset($_POST['delete_location_from_map']) && isset($_POST['selected_location'])){
    delete_location_and_stats($conn,$_POST['selected_location']);
}

if(isset($_POST['mark_location']) && isset($_POST['location_name']) && isset($_POST['latitude']) != '' && isset($_POST['longitude'])){
    add_google_map_locations($conn,$_POST['location_name'],$_POST['latitude'],$_POST['longitude']);
}

if(isset($_POST['selected_marker']) && isset($_POST['caste_name']) && isset($_POST['total_voter'])){
    add_map_stats($conn,$_POST['selected_marker'],$_POST['caste_name'],$_POST['total_voter']);
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
    $deptName = get_department_details($conn, $deptId);
}
$all_markers = array();
$all_markers = get_all_marker($conn);
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
                                <h5 class="card-title">Mark Location To Map</h5>
                            </div>
                            <form method="POST" class="gy-3">
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">Add Location Name</label>
                                            <span class="form-note">(Example: Gohana, Meerut, Bulandshahr etc.)</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" name="location_name" class="form-control" placeholder="Add Location Name" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">Add Latitude Value</label>
                                            <span class="form-note">(Example: 29.33725508190393)</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" name="latitude" class="form-control latlong" placeholder="Add Latitude Value" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">Add Longitude Value</label>
                                            <span class="form-note">(Example: 76.29386593162488)</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" name="longitude" class="form-control latlong" placeholder="Add Longitude Value" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row g-3">
                                    <div class="col-lg-7 offset-lg-5">
                                        <div class="form-group mt-2">
                                            <button name="mark_location" type="submit" class="btn btn-lg btn-primary">Save</button><br><br><br>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- card -->

                    <div class="nk-block nk-block-lg">
                        <div class="card">
                            <div class="card-inner">
                                <div class="card-head">
                                    <h5 class="card-title">Add Caste Details</h5>
                                </div>
                                <form method="POST" class="gy-3">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Select Location</label>
                                                <span class="form-note">Select any location from the dropdown.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                <select name="selected_marker" class="form-control">
                                                    <?php foreach($all_markers as $key => $value){?>
                                                        <option value="" selected disabled hidden>Choose here</option>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['location_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">Caste Name</label>
                                            <span class="form-note">(Example: General, OBC, SC, ST etc.)</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" name="caste_name" class="form-control" placeholder="Caste Name" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">Add Total Voter </label>
                                            <span class="form-note">(Example: 1234567890)</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <input type="text" name="total_voter" class="form-control latlong" placeholder="Add Total Voter" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-7 offset-lg-5">
                                            <div class="form-group mt-2">
                                                <button type="submit" class="btn btn-lg btn-primary">Save</button><br><br><br>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- card -->
                        <div class="nk-block nk-block-lg">
                        <div class="card">
                            <div class="card-inner">
                                <div class="card-head">
                                    <h5 class="card-title">Delete Caste</h5>
                                </div>
                                <form method="POST" class="gy-3">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Select Location</label>
                                                <span class="form-note">Select any location from the dropdown.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                <select name="selected_location" id="selected_location" class="form-control" required>
                                                    <?php foreach($all_markers as $key => $value){?>
                                                        <option value="" selected disabled hidden>Choose here</option>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['location_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 align-center">
                                    <div class="col-lg-5">
                                        <div class="form-group">
                                            <label class="form-label" for="site-name">Caste Name</label>
                                            <span class="form-note">(Example: General, OBC, SC, ST etc.)</span>
                                        </div>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="form-group">
                                            <div class="form-control-wrap">
                                                <select name="caste_name" id="caste_name" class="form-control" required>
                                                        <option value="" selected disabled hidden>Choose here</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-7 offset-lg-5">
                                            <div class="form-group mt-2">
                                                <button type="submit" name="delete_caste" class="btn btn-lg btn-primary">Delete</button><br><br><br>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- card -->
                        <div class="nk-block nk-block-lg">
                        <div class="card">
                            <div class="card-inner">
                                <div class="card-head">
                                    <h5 class="card-title">Delete Location From The Map</h5>
                                </div>
                                <form method="POST" class="gy-3">
                                    <div class="row g-3 align-center">
                                        <div class="col-lg-5">
                                            <div class="form-group">
                                                <label class="form-label" for="site-name">Select Location</label>
                                                <span class="form-note">Select any location from the dropdown.</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-7">
                                            <div class="form-group">
                                                <div class="form-control-wrap">
                                                <select name="selected_location" id="selected_location" class="form-control" required>
                                                    <?php foreach($all_markers as $key => $value){?>
                                                        <option value="" selected disabled hidden>Choose here</option>
                                                        <option value="<?php echo $value['id']; ?>"><?php echo $value['location_name']; ?></option>
                                                    <?php } ?>
                                                </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-lg-7 offset-lg-5">
                                            <div class="form-group mt-2">
                                                <button type="submit" name="delete_location_from_map" class="btn btn-lg btn-primary">Delete</button><br><br><br>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div><!-- card -->
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
            $(".latlong").keypress(function(e){
            var keyCode = e.which;
            /*
            8 - (backspace)
            110 & 119 - (point)
            48-57 - (0-9)Numbers
            */
        //    console.log(keyCode);
            if ( (keyCode != 8 && keyCode != 110 && keyCode != 190 && keyCode != 46) && (keyCode < 48 || keyCode > 57)) { 
            return false;
            }
        });

        $('#selected_location').change(function() {

        var location_id = $(this).val();
        $('#caste_name').find('option').not(':first').remove();

        // AJAX request
        $.ajax({
            url: 'service_to_get_castes.php',
            type: 'post',
            data: {
                request: 1,
                location_id: location_id
            },
            dataType: 'json',
            success: function(response) {

                var len = response.length;

                for (var i = 0; i < len; i++) {
                    var id = response[i][0];
                    var caste = response[i][1];
                    $("#caste_name").append("<option value='" + id + "'>" + caste.toUpperCase() + "</option>");
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