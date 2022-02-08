<?php
include_once '../configs/includes.php';
$user_id = $_SESSION['user_id'];
$loginUserData = get_user_details($conn,$user_id);
$deptId = $loginUserData['department_id'];
$deptNameValue = get_department_details($conn, $deptId);
?>
<div class="nk-header nk-header-fixed is-light">
    <div class="container-fluid">
        <div class="nk-header-wrap">
            <div class="nk-menu-trigger d-xl-none ml-n1">
                <a href="#" class="nk-nav-toggle nk-quick-nav-icon" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
            </div>
            <div class="nk-header-brand d-xl-none">
                <a href="#" class="logo-link">
                    <img class="logo-light logo-img" src="images/logo.png" srcset="images/logo2x.png 2x" alt="logo">
                    <img class="logo-dark logo-img" src="images/logo-dark.png" srcset="images/logo-dark2x.png 2x" alt="logo-dark">
                </a>
            </div><!-- .nk-header-brand -->
            <h5 style="padding-top: 8px;"><?php 
            $deptName = ($deptName === 'Super Admin')? $deptName : $deptName . ' Department';
            echo $deptName ?></h5>
            <div class="nk-header-tools">
                <ul class="nk-quick-nav">
                    <li class="dropdown user-dropdown">
                        <a href="#" class="dropdown-toggle mr-n1" data-toggle="dropdown">
                            <div class="user-toggle">
                                <div class="user-avatar sm">
                                    <img src="images/avatar/<?php echo $adminImage ?>" />
                                </div>
                                <div class="user-info d-none d-xl-block">
                                    <div class="user-name dropdown-indicator"><?php echo $adminName; ?></div>
                                </div>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                            <div class="dropdown-inner user-card-wrap bg-lighter d-none d-md-block">
                                <div class="user-card">
                                    <div class="user-avatar">
                                        <img src="images/avatar/<?php echo $adminImage ?>" />
                                    </div>
                                    <div class="user-info">
                                        <span class="lead-text"><?php echo $adminName; ?></span>
                                        <span class="sub-text"><?php $adminEmail = isset($adminEmail) ? $adminEmail : $email; echo $adminEmail; ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php if($deptNameValue != 'Field Worker'){ ?>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="user-profile.php"><em class="icon ni ni-user-alt"></em><span>View Profile</span></a></li>
                                    </ul>
                            </div>
                            <?php  } ?>
                            <div class="dropdown-inner">
                                <ul class="link-list">
                                    <li><a href="logout.php"><em class="icon ni ni-signout"></em><span>Sign out</span></a></li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div><!-- .nk-header-wrap -->
    </div><!-- .container-fliud -->
</div>