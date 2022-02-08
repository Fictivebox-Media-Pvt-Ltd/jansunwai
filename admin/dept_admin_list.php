<?php
include_once '../configs/includes.php';

if(isset($_GET['del'])){
    delete_an_admin($conn,$_GET['del']);
}

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT department_id,f_name,l_name,user_image FROM tbl_admin_users WHERE id=$user_id";
    $loginUserData = get_user_details($conn, $user_id);
    $adminName = $loginUserData['f_name'] . ' ' . $loginUserData['l_name'];
    $adminImage = $loginUserData['user_image'];
    $deptId = $loginUserData['department_id'];
    $deptName = get_department_details($conn, $deptId);
    $email = $loginUserData['email'];
    $dept_admin = get_dept_admin($conn,NULL);
  
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
                <?php include_once 'header.php';?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content" style="margin-top: 50px;">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                               <div class="nk-block nk-block-lg">
                                        <div class="nk-block-head">
                                            <div class="nk-block-head-content">
                                                <h4 class="nk-block-title">Admin List</h4>
                                               
                                            </div>
                                        </div>
                                        <div class="card card-preview" style="<?php if(preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])) echo 'width: max-content;'?>">
                                            <div class="card-inner">
                                                <table class="table" id="admins">
                                                    <thead>
                                                        <tr>
                                                        <th style="width:100px; text-align:center;">S. No.</th>
                                                            <th style="width:140px; text-align:center;">User Image</th>
                                                            <th>Name</th>
                                                            <th>Email</th>
                                                            <th>Vibhag Name</th>
                                                            <th style="width:155px; text-align:center;">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    <?php
                                                        $i = 1;
                                                        foreach ($dept_admin as $key => $value) {
                                                    ?>
                                                        <tr>
                                                        <td style="padding-top:35px; text-align:center;"><?php echo $i ?></td>
                                                        <td style="text-align:center;">
                                                        <?php
                                                        $image=$value['user_image'];
                                                        $file = 'images/avatar/'.$image; // 'images/'.$file (physical path)
                                                        if ($image) {
                                                        ?>
                                                            <img src="images/avatar/<?php echo $value['user_image']; ?>" id="output" style="width: 70px; height:80px;  background-color: white;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;"/>
                                                       
                                                        <?php
                                                          } else {
                                                            ?>
                                                           <img src="images/avatar/no-user-image.png" id="output" style="width: 70px; height:80px;  background-color: white;  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); border-radius: 8px;"/>
                                                       
                                                         <?php
                                                        }
                                                        ?>
                                                        
                                                        </td>
                                                        <td style="padding-top:35px;"><?php echo $value['f_name']." ";echo $value['l_name']; ?></td>
                                                        <td style="padding-top:35px;"><?php echo $value['email']; ?></td>
                                                        <td style="padding-top:35px;"><?php echo $value['name']; ?></td>
                                                        
                                                        <td style="padding-top:35px; text-align:center;">
                                                         <a href="<?php echo "edit_dept_admin.php?id=".$value['id'];?>" class="btn btn-icon btn-trigger btn-tooltip" title="Update information of this admin">
                                                                <em class="icon ni ni-edit"></em></a>
                                                        <a href="<?php echo "?del=".$value['id'] ?>" class="btn btn-icon btn-trigger btn-tooltip" title="Delete this admin">
                                                                <em class="icon ni ni-trash"></em></a></td>
                                                               
                                                        </tr>
                                                        <?php $i++;} ?>   
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!-- .card-preview -->
                                    </div> <!-- nk-block -->
                            
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content @e -->
                <!-- footer @s -->
                <?php include_once 'footer.php' ?>
                <!-- footer @e -->
            </div>
            <!-- wrap @e -->
        </div>
        <!-- main @e -->
    </div>
    <!-- app-root @e -->
    <!-- JavaScript -->
    <script>
            $(document).ready(function() {
                    NioApp.DataTable('#admins', {
                        "paging":true,
                        "processing":true,
                        "serverSide":false,
                        "order": [],
                        "info":true,
                        
                        "columnDefs":[
                                        {
                                            "targets":[1,3,5],
                                            "orderable":false,
                                        },
                                    ],
                        responsive: {
                            details: true
                        }
                    });
            });
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>

</html>