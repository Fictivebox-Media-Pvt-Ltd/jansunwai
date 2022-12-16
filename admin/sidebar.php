<?php
include_once '../configs/includes.php';
$user_id = $_SESSION['user_id'];
$assignedLoksabha = getLoksabhaOfLoggedInUser($conn,$user_id);
$loginUserData = get_user_details($conn,$user_id);
$deptId = $loginUserData['department_id'];
$deptName = get_department_details($conn, $deptId);

?>
<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="index.php" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="images/jansunwai_logo.png" srcset="images/jansunwai_logo.png 1x"
                    alt="logo">
                <img class="logo-dark logo-img" src="images/jansunwai_logo.png" srcset="images/jansunwai_logo.png 1x"
                    alt="logo-dark">
                <img class="logo-small logo-img logo-img-small" src="images/jansunwai_logo.png"
                    srcset="images/jansunwai_logo.png 1x" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em
                    class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em
                    class="icon ni ni-menu"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <?php if($deptName != 'Field Worker'){ ?>
                    <li class="nk-menu-item">
                        <a href="index.php" class="nk-menu-link" data-original-title="" title="">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-map"></em></span>
                            <span class="nk-menu-text">Surveillance System</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="track_field_workers.php" class="nk-menu-link"><span class="nk-menu-text">Track
                                        Field Workers</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="surveyers_stats.php" class="nk-menu-link"><span class="nk-menu-text">Surveyer's
                                        Stats</span></a>
                            </li>
                            <!-- <li class="nk-menu-item">
                                <a href="manage_loksabha_kshetra.php" class="nk-menu-link"><span class="nk-menu-text">Manage LokSabha Kshetra</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link"><span class="nk-menu-text">Karyakram Updates</span></a>
                            </li> -->
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <?php } ?>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-db-fill"></em></span>
                            <span class="nk-menu-text">Voters</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <?php if($deptName != 'Field Worker' && $deptName != 'Administrative'){ ?>
                            <li class="nk-menu-item">
                                <a href="add_voters.php" class="nk-menu-link"><span class="nk-menu-text">Add New
                                        Voters</span></a>
                            </li>
                            <?php } ?>
                            <li class="nk-menu-item">
                                <a href="userbase.php" class="nk-menu-link"><span class="nk-menu-text">List Of
                                        Voters</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="surveyed_userbase.php" class="nk-menu-link"><span class="nk-menu-text">Surveyed
                                        Voter</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="javascript:void(0)" class="nk-menu-link" style="opacity: .5;color: #526484 !important;"><span class="nk-menu-text">adivasi
                                    </span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="javascript:void(0)" class="nk-menu-link" style="opacity: .5;color: #526484 !important;"><span class="nk-menu-text">Mahila
                                    </span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="javascript:void(0)" class="nk-menu-link" style="opacity: .5;color: #526484 !important;"><span class="nk-menu-text">First
                                        time voter
                                    </span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <?php if($deptName != 'Field Worker' && $deptName != 'Administrative'){ ?>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-cc-alt2-fill"></em></span>
                            <span class="nk-menu-text">Notices</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="add_governance_order.php" class="nk-menu-link"><span class="nk-menu-text">Add
                                        New</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="order-list.php" class="nk-menu-link"><span class="nk-menu-text">View
                                        Notices</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li><!-- .nk-menu-item -->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-user-list-fill"></em></span>
                            <span class="nk-menu-text">Vibhag</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="manage_department.php" class="nk-menu-link"><span class="nk-menu-text">Manage
                                        Vibhag </span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="manage_loksabha.php" class="nk-menu-link"><span class="nk-menu-text">Manage
                                        Loksabha </span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="add_dept_admin.php" class="nk-menu-link"><span class="nk-menu-text">Add Vibhag
                                        Admins</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="dept_admin_list.php" class="nk-menu-link"><span class="nk-menu-text">View
                                        Vibhag Admins</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-users-fill"></em></span>
                            <span class="nk-menu-text">Karyakarta</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="add_workers.php" class="nk-menu-link"><span class="nk-menu-text">Add New
                                        Karyakarta</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="workers_list.php" class="nk-menu-link"><span class="nk-menu-text">List Of
                                        Karyakarta's</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-light-fill"></em></span>
                            <span class="nk-menu-text">Karyakarta</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link nk-menu-toggle"><span
                                        class="nk-menu-text">BJP</span></a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="bjp_jila_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Jila karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjp_vidhansabha_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Vidhansabha karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjp_mandal_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Mandal karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjp_shakti_kendra.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Shakti Kendra</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjp_booth_adhyaksh.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Booth Adhyaksh</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link nk-menu-toggle"><span
                                        class="nk-menu-text">BJYM</span></a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="bjym_jila_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Jila karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjym_vidhansabha_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Vidhansabha karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjym_mandal_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Mandal karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjym_shakti_kendra.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Shakti Kendra</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjym_booth_adhyaksh.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Booth Adhyaksh</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link nk-menu-toggle"><span
                                        class="nk-menu-text">Morcha</span></a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="morcha_yuva.php" class="nk-menu-link"><span class="nk-menu-text">Yuva
                                                Morcha</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="morcha_sc.php" class="nk-menu-link"><span class="nk-menu-text">SC
                                                Morcha</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="morcha_st.php" class="nk-menu-link"><span class="nk-menu-text">ST
                                                Morcha</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="morcha_mahila.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Mahila
                                                Morcha</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="morcha_kissan.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Kissan
                                                Morcha</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="morcha_miniority.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Miniority
                                                Morcha</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="morcha_obc.php" class="nk-menu-link"><span class="nk-menu-text">OBC
                                                Morcha</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link nk-menu-toggle"><span
                                        class="nk-menu-text">Sangathan</span></a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="javascript:void(0)" class="nk-menu-link" style="opacity: .5;color: #526484 !important;"><span class="nk-menu-text">Add
                                                Sangathan</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="javascript:void(0)" class="nk-menu-link" style="opacity: .5;color: #526484 !important;"><span
                                                class="nk-menu-text">Sangathan List</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-user-check"></em></span>
                            <span class="nk-menu-text">Local Officials</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="asha_worker.php" class="nk-menu-link"><span class="nk-menu-text">Asha
                                        Worker</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="anm.php" class="nk-menu-link"><span class="nk-menu-text">ANM</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="blo.php" class="nk-menu-link"><span class="nk-menu-text">BLO</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="news_reporter.php" class="nk-menu-link"><span class="nk-menu-text">News
                                        Reporter</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="sarpanch_candidate.php" class="nk-menu-link"><span
                                        class="nk-menu-text">Voters</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="javascript:void(0)" class="nk-menu-link" style="opacity: .5;color: #526484 !important;"><span class="nk-menu-text">Mukhiya</span></a>
                            </li>
                        </ul><!-- .nk-menu-sub -->
                    </li>
                    <!-- <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-setting"></em></span>
                            <span class="nk-menu-text">Settings</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="about_us.php" class="nk-menu-link"><span class="nk-menu-text">About Us</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="privacy_policy.php" class="nk-menu-link"><span class="nk-menu-text">Privacy Policy</span></a>
                            </li>
                        </ul>
                    </li> -->
                    <?php } ?>
                    <!--?php if($assignedLoksabha === 'चित्तौड़गढ़'){ ?-->
                    <!-- <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-light-fill"></em></span>
                            <span class="nk-menu-text">Karyakarta</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link nk-menu-toggle"><span
                                        class="nk-menu-text">BJP</span></a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="bjp_jila_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Jila karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjp_vidhansabha_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Vidhansabha karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjp_mandal_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Mandal karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjp_shakti_kendra.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Shakti Kendra</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjp_booth_adhyaksh.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Booth Adhyaksh</span></a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nk-menu-item">
                                <a href="#" class="nk-menu-link nk-menu-toggle"><span
                                        class="nk-menu-text">BJYM</span></a>
                                <ul class="nk-menu-sub">
                                    <li class="nk-menu-item">
                                        <a href="bjym_jila_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Jila karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjym_vidhansabha_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Vidhansabha karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjym_mandal_karyakarini.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Mandal karyakarini</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjym_shakti_kendra.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Shakti Kendra</span></a>
                                    </li>
                                    <li class="nk-menu-item">
                                        <a href="bjym_booth_adhyaksh.php" class="nk-menu-link"><span
                                                class="nk-menu-text">Booth Adhyaksh</span></a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-light-fill"></em></span>
                            <span class="nk-menu-text">Morcha</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="morcha_yuva.php" class="nk-menu-link"><span class="nk-menu-text">Yuva
                                        Morcha</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="morcha_sc.php" class="nk-menu-link"><span class="nk-menu-text">SC
                                        Morcha</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="morcha_st.php" class="nk-menu-link"><span class="nk-menu-text">ST
                                        Morcha</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="morcha_mahila.php" class="nk-menu-link"><span class="nk-menu-text">Mahila
                                        Morcha</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="morcha_kissan.php" class="nk-menu-link"><span class="nk-menu-text">Kissan
                                        Morcha</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="morcha_miniority.php" class="nk-menu-link"><span class="nk-menu-text">Miniority
                                        Morcha</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="morcha_obc.php" class="nk-menu-link"><span class="nk-menu-text">OBC Morcha</a>
                            </li>
                        </ul>
                    </li> -->
                    <!-- <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-user-check"></em></span>
                            <span class="nk-menu-text">Local Officials</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="asha_worker.php" class="nk-menu-link"><span class="nk-menu-text">Asha
                                        Worker</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="anm.php" class="nk-menu-link"><span class="nk-menu-text">ANM</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="blo.php" class="nk-menu-link"><span class="nk-menu-text">BLO</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="news_reporter.php" class="nk-menu-link"><span class="nk-menu-text">News
                                        Reporter</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="sarpanch_candidate.php" class="nk-menu-link"><span
                                        class="nk-menu-text">Voters</span></a>
                            </li>

                        </ul>
                    </li>
                    <li class="nk-menu-item">
                        <a href="sms.php" class="nk-menu-link" data-original-title="" title="">
                            <span class="nk-menu-icon"><em class="icon ni ni-list-round"></em></span>
                            <span class="nk-menu-text">SMS Templates</span>
                        </a>
                    </li> -->

                    <!--?php } ?-->
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-list-round"></em></span>
                            <span class="nk-menu-text">Mandal's & Panchayat's</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="add_mandal_panchayat.php" class="nk-menu-link"><span class="nk-menu-text">Bulk
                                        Upload</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="list_mandal_panchayat.php" class="nk-menu-link"><span class="nk-menu-text">List
                                        Data</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="loksabha_add.php" class="nk-menu-link"><span class="nk-menu-text">Add
                                        Loksabha</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="vidhansabha_add.php" class="nk-menu-link"><span class="nk-menu-text">Add
                                        Vidhansabha</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="mandal_add.php" class="nk-menu-link"><span class="nk-menu-text">Add
                                        Mandal</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="panchayat_add.php" class="nk-menu-link"><span class="nk-menu-text">Add
                                        Panchayat</span></a>
                            </li>

                        </ul><!-- .nk-menu-sub -->
                    </li>
                    <!--?php if($assignedLoksabha === 'चित्तौड़गढ़' || $assignedLoksabha == ''){ ?-->
                    <li class="nk-menu-item has-sub">
                        <a href="analytics.php" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-activity-round"></em></span>
                            <span class="nk-menu-text">Analytics</span>
                        </a>
                    </li>
                    <!-- <li class="nk-menu-item has-sub">
                        <a href="questions.php" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-activity-round"></em></span>
                            <span class="nk-menu-text">Questions</span>
                        </a>
                    </li> -->
                    <li class="nk-menu-item has-sub">
                        <a href="questions.php" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-user-check"></em></span>
                            <span class="nk-menu-text">Questions</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="questions.php" class="nk-menu-link"><span class="nk-menu-text">Add
                                        Questions</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="questions-list.php" class="nk-menu-link"><span class="nk-menu-text">Questions
                                        List</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-list-round"></em></span>
                            <span class="nk-menu-text">Media</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="javascript:void(0)" class="nk-menu-link" style="opacity: .5;color: #526484 !important;"><span class="nk-menu-text">News</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="javascript:void(0)" class="nk-menu-link" style="opacity: .5;color: #526484 !important;"><span
                                        class="nk-menu-text">Youtube</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="javascript:void(0)" class="nk-menu-link" style="opacity: .5;color: #526484 !important;"><span class="nk-menu-text">Social
                                        media</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="javascript:void(0)" class="nk-menu-link" style="opacity: .5;color: #526484 !important;"><span
                                        class="nk-menu-text">Press</span></a>
                            </li>
                        </ul>
                    </li>
                    <!-- .nk-menu-item -->
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>