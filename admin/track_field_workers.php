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
    $assignedLoksabha = $loginUserData['assigned_loksabha'];
    $deptName = get_department_details($conn,$deptId);
}	 
$map_data = track_field_workers($conn,$assignedLoksabha);
?>	

<!DOCTYPE html>
<html lang="zxx" class="js">
<?php include_once 'head.php'; ?>
<style type="text/css">
    /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
    #map {
        height:500px;
    }

    /* Optional: Makes the sample page fill the window. */
    html,
    body {
        height: 100%;
        margin: 0;
        padding: 0;
    }

    table,
    td,
    th {
        color:black;
        font-size: 14px;
       
        border: 1px solid black;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    th,
    td {
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #f2f2f2
    }

    th {
        background-color: #4CAF50;
        color: white;
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
                <div class="nk-block nk-block-lg">
                    <div class="nk-block-head" style="padding: 75px 10px 0px 10px;">
                        <div class="nk-block-head-content">
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-inner">
                            <div class="card-head">
                                <h5 class="card-title">Track field Workers</h5>
                            </div>
                            <!-- Map Content: Start -->
                            <div class="card card-preview">
                                <div class="card-inner">
                                    <div id="map"></div>
                                </div>
                            </div><!-- .card-preview -->
                            <!--- Map Content: End --->
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
    <!-- Async script executes immediately and must be after any DOM elements used in callback. -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCTz0gfQHqMsuqrP774kF4HxxOytsWWjiY&callback=initMap&libraries=&v=weekly" async></script>
    <script>
        function initMap() {
            const map = new google.maps.Map(document.getElementById("map"), {
                zoom: 10,
                center: {
                    lat: <?php echo $map_data[0][1]; ?>,
                    lng: <?php echo $map_data[0][2]; ?>
                },
            });
            setMarkers(map);
        }


        // Data for the markers consisting of a name, a LatLng and a zIndex for the
        // order in which these markers should display on top of each other.
        var locations = <?php echo json_encode($map_data); ?>;
       
        function setMarkers(map) {
            for (let i = 0; i < locations.length; i++) {
                const location = locations[i];
                var contentString =
                    '<p style="color:black;font-size: 14px;"><b>Username:</b> '+ location[0]+'</p><img style="height: 150px;" src="images/avatar/'+location[3]+'">';

                const infowindow = new google.maps.InfoWindow({
                    content: contentString,
                });
                
                const marker = new google.maps.Marker({
                    position: {
                        lat: location[1], // Latitude
                        lng: location[2] // Longitute
                    },
                    map,
                    title: location[0]
                });
                marker.addListener("click", () => {
                    infowindow.open(map, marker);
                });
            }
        }
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>
</html>