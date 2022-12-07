<?php
echo "deepK";
die;
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include_once '../configs/includes.php';
// $total_users='';
// $total_complaints='';
// $today_complaints='';
// $today_users= '';
$todaySurveyed = 0;
$totalSurveyed = 0;
$activeSurveyors = 0;
$totalSurveyors = 0;

// $start_date = NULL;
// $end_date = NULL;
// if(isset($_GET['date_range'])){
//     $start_date = $_GET['start_date'];
//     $end_date = $_GET['end_date'];
// }else{
//     $start_date = date("Y-m-d", strtotime("-7 days"));
//     $end_date = date("Y-m-d");
// }
// $new_users_for_graph = get_new_users_stats($conn,$start_date,$end_date);
// $total_users_for_graph = get_total_users_stats($conn,$start_date,$end_date);

// $total_users = get_workers_counts($conn, $total_users);
// $total_complaints = get_complaints_counts($conn, $total_complaints);
// $today_complaints = get_today_comlaints($conn,$today_complaints);
// $today_users= get_today_users($conn,$today_users);
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT department_id,f_name,l_name,user_image FROM tbl_admin_users WHERE id=$user_id";
    $loginUserData = get_user_details($conn, $user_id);
    $adminName = $loginUserData['f_name'] . ' ' . $loginUserData['l_name'];
    $adminImage = $loginUserData['user_image'];
    $deptId = $loginUserData['department_id'];
    $email = $loginUserData['email'];
    $assignedLoksabha = $loginUserData['assigned_loksabha'];
    $deptName = get_department_details($conn, $deptId);

    if($assignedLoksabha === 'चित्तौड़गढ़' || $assignedLoksabha == ''){
       
        $todaySurveyed = get_todaySurveyed($conn);
       $totalSurveyed = get_totalSurveyed($conn);
      $activeSurveyors = get_activeSurveyors($conn);
      $totalSurveyors = get_totalSurveyors($conn);

       
    }

    if($deptName == 'Field Worker'){
        header('location:userbase.php');
    }
  
    $g1 =  get_g3($conn,NULL);
    $graphString = "'";
    foreach($g1 as $key => $value){
        $graphString .= $value['name'];
    }
    $graphString .= "'";
    $graphString = str_replace(' ', '-', $graphString);
}
?>
<!DOCTYPE html>
<html lang="zxx" class="js">
<?php include_once 'head.php';?>
<body class="nk-body bg-lighter npc-default has-sidebar">
    <div class="nk-app-root">
        <!-- main @s -->
        <div class="nk-main ">
            <!-- sidebar @s -->
            <?php include_once 'sidebar.php';?>
            <!-- sidebar @e -->
            <!-- wrap @s -->
            <div class="nk-wrap ">
                <!-- main header @s -->
                <?php include_once 'header.php';?>
                <!-- main header @e -->
                <!-- content @s -->
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">
                                <div class="nk-block-head nk-block-head-sm">
                                    <div class="nk-block-between">
                                        <div class="nk-block-head-content">
                                            <!-- <h3 class="nk-block-title page-title">Super Admin Pannel</h3> -->
                                        </div><!-- .nk-block-head-content -->
                                        <div class="nk-block-head-content">
                                            <div class="toggle-wrap nk-block-tools-toggle">
                                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                            </div>
                                        </div><!-- .nk-block-head-content -->
                                    </div><!-- .nk-block-between -->
                                </div><!-- .nk-block-head -->
                                <div class="nk-block">
                                    <div class="row g-gs">
                                        <div class="col-xxl-3 col-sm-6">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Today Surveyed</h6>
                                                            </div>
                                                        </div>
                                                        <div class="data">
                                                            <div class="data-group">
                                                                <div class="amount"><?php echo $todaySurveyed;?></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-xxl-3 col-sm-6">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Total Surveyed</h6>
                                                            </div>
                                                        </div>
                                                        <div class="data">
                                                            <div class="data-group">
                                                                <div class="amount"><?php echo $totalSurveyed;?></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-xxl-3 col-sm-6">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Today Active Surveyors</h6>
                                                            </div>
                                                        </div>
                                                        <div class="data">
                                                            <div class="data-group">
                                                                <div class="amount"><?php echo $activeSurveyors;?></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-xxl-3 col-sm-6">
                                            <div class="card">
                                                <div class="nk-ecwg nk-ecwg6">
                                                    <div class="card-inner">
                                                        <div class="card-title-group">
                                                            <div class="card-title">
                                                                <h6 class="title">Total Active Surveyors</h6>
                                                            </div>
                                                        </div>
                                                        <div class="data">
                                                            <div class="data-group">
                                                                <div class="amount"><?php echo $totalSurveyors;?></div>
                                                            </div>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .nk-ecwg -->
                                            </div><!-- .card -->
                                        </div><!-- .col -->
                                        <div class="col-md-12">
                                        <?php if($assignedLoksabha === 'चित्तौड़गढ़' || $assignedLoksabha == ''){?>
                                            <figure class="highcharts-figure">
                                                <div id="container"></div>
                                            </figure>
                                        <?php } ?>
                                        <!-- <form method="GET" class="form-validate">
                                        <div class="row g-3">
                                            <div class="col-lg-3">
                                                <div class="form-group" style="text-align: right;">
                                                    <label class="form-label" style="padding-top: 5px;font-size: 17px;">Date Range:</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input style="max-height: 35px;" value="<?php echo $start_date?>" type="text" name="start_date" placeholder="Select Start Date" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress" required data-date-format="yyyy-mm-dd">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-3">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <input style="max-height: 35px;" value="<?php echo $end_date?>" type="text" name="end_date" placeholder="Select End Date" class="form-control form-control-xl form-control-outlined date-picker disableKeyPress" required data-date-format="yyyy-mm-dd">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-lg-1 offset-lg-1">
                                                        <button type="submit" name="date_range" value="applied" class="btn btn-dim btn-success">Apply</button>
                                                </div>
                                            </div>
                                            <div class="row g-3">
                                                <div class="col-lg-1 offset-lg-1">
                                                <a href="index.php" class="btn btn-dim btn-warning">Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                        </form> -->
                                        </div>
                                        <!-- <div class="col-xxl-6">
                                            <div class="card card-full">
                                                <div class="nk-ecwg nk-ecwg8 h-100">
                                                    <div class="card-inner">
                                                    <?php 
                                                        // $isNoData = count($total_users_for_graph) ? '' : 'hidden'; 
                                                        // $divForNoData = count($total_users_for_graph) ? 'hidden' : '';
                                                    ?>
                                                    <figure class="highcharts-figure">
                                                        <div id="userWiseEngagement" <?php // echo $isNoData;?>></div>
                                                        <div <?php // echo $divForNoData;?> style='background-color: white;color:#333333;text-align: center;font-size: 20px;font-family: "Lucida Grande", "Lucida Sans Unicode", Arial, Helvetica, sans-serif;height: 370px;'>
                                                            <p>Userwise Engagement Graph</p>
                                                            <p><img src="images/no_data_found.png" height="15%" width="15%"></p>
                                                            <p style="padding-top: 5px;">No data for this time period</p>
                                                        </div>
                                                    </figure>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <!-- <div class="col-xxl-6">
                                            <div class="card card-full">
                                                <div class="nk-ecwg nk-ecwg8 h-100">
                                                    <div class="card-inner">
                                                    <figure class="highcharts-figure">
                                                        <div id="grievanceTrendGraph"></div>
                                                    </figure>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-xxl-3 col-sm-6"> 
                                        </div>
                                        </div>
                                    </div><!-- .row -->
                                </div><!-- .nk-block -->
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
        Highcharts.setOptions({
            global: {
                /**
                 * Use moment-timezone.js to return the timezone offset for individual
                 * timestamps, used in the X axis labels and the tooltip header.
                 */
                getTimezoneOffset: function (timestamp) {
                    var zone = 'Asia/Kolkata',
                        timezoneOffset = -moment.tz(timestamp, zone).utcOffset();

                    return timezoneOffset;
                }
            }
        });
        // Highcharts.chart('userWiseEngagement', {
        //     chart: {
        //         zoomType: 'x'
        //     },
        //     title: {
        //         text: 'Userwise Engagement Graph'
        //     },
        //     yAxis: {
        //         title: {
        //             text: 'Number of Users'
        //         }
        //     },
        //     xAxis: {
        //         type: 'datetime',
        //         title: {
        //             text: 'Dates'
        //         }
        //     },
        //     legend: {
        //         layout: 'vertical',
        //         align: 'right',
        //         verticalAlign: 'middle'
        //     },
        //     series: [{
        //             name: 'Newly Added Users',
        //             data: <?php
        //             echo json_encode($new_users_for_graph); ?>
        //         }
        //         ,{
        //             name: 'Total Users',
        //             data: <?php
        //             echo json_encode($total_users_for_graph); ?>
        //         }
        //     ],
        //     responsive: {
        //         rules: [{
        //             condition: {
        //                 maxWidth: 500
        //             },
        //             chartOptions: {
        //                 legend: {
        //                     layout: 'horizontal',
        //                     align: 'center',
        //                     verticalAlign: 'bottom'
        //                 }
        //             }
        //         }]
        //     },
        //     exporting: {
        //         buttons: {
        //             contextButton: {
        //                 menuItems: [
        //                     'downloadJPEG',
        //                     'downloadPDF',
        //                     'downloadXLS',
        //                 ]
        //             }
        //         }
        //     }
        // });
        // Highcharts.chart('grievanceTrendGraph', {
        //     chart: {
        //         zoomType: 'x'
        //     },
        //     title: {
        //         text: 'Grievance Trend Graph'
        //     },
        //     yAxis: {
        //         title: {
        //             text: 'Number of Grievance'
        //         }
        //     },
        //     xAxis: {
        //         type: 'datetime',
        //         title: {
        //             text: 'Dates'
        //         }
        //     },
        //     legend: {
        //         layout: 'vertical',
        //         align: 'right',
        //         verticalAlign: 'middle'
        //     },
        //     series: [{
        //             name: 'Total Grievance',
        //             data: [
        //                 [1609462801000, 0],
        //                 [1609549201000, 15],
        //                 [1609635601000, 33],
        //                 [1609722001000, 48],
        //                 [1609808401000, 52],
        //                 [1609894801000, 64],
        //                 [1609981201000, 66],
        //                 [1610067601000, 71],
        //                 [1610154001000, 91],
        //                 [1610240401000, 98],
        //                 [1610326801000, 108],
        //                 [1610413201000, 114],
        //                 [1610499601000, 129],
        //                 [1610586001000, 144],
        //                 [1610672401000, 152],
        //                 [1610758801000, 164],
        //                 [1610845201000, 177],
        //                 [1610931601000, 193],
        //                 [1611018001000, 197],
        //                 [1611104401000, 206],
        //                 [1611190801000, 221],
        //                 [1611277201000, 227],
        //                 [1611363601000, 231],
        //                 [1611450001000, 247],
        //                 [1611536401000, 260],
        //                 [1611622801000, 270],
        //                 [1611709201000, 288],
        //                 [1611795601000, 305],
        //                 [1611882001000, 320],
        //                 [1611968401000, 336],
        //                 [1612054801000, 338],
        //                 [1612141201000, 351],
        //                 [1612227601000, 370],
        //                 [1612314001000, 375],
        //                 [1612400401000, 375],
        //                 [1612486801000, 389],
        //                 [1612573201000, 400]
        //             ]
        //         },
        //         {
        //             name: 'Newly Added Grievance',
        //             data: [
        //                 [1609462801000, 14],
        //                 [1609549201000, 17],
        //                 [1609635601000, 14],
        //                 [1609722001000, 10],
        //                 [1609808401000, 5],
        //                 [1609894801000, 18],
        //                 [1609981201000, 2],
        //                 [1610067601000, 6],
        //                 [1610154001000, 27],
        //                 [1610240401000, 17],
        //                 [1610326801000, 12],
        //                 [1610413201000, 27],
        //                 [1610499601000, 11],
        //                 [1610586001000, 6],
        //                 [1610672401000, 11],
        //                 [1610758801000, 15],
        //                 [1610845201000, 5],
        //                 [1610931601000, 26],
        //                 [1611018001000, 4],
        //                 [1611104401000, 2],
        //                 [1611190801000, 8],
        //                 [1611277201000, 9],
        //                 [1611363601000, 15],
        //                 [1611450001000, 12],
        //                 [1611536401000, 7],
        //                 [1611622801000, 20],
        //                 [1611709201000, 18],
        //                 [1611795601000, 13],
        //                 [1611882001000, 18],
        //                 [1611968401000, 27],
        //                 [1612054801000, 26],
        //                 [1612141201000, 19],
        //                 [1612227601000, 14],
        //                 [1612314001000, 10],
        //                 [1612400401000, 11],
        //                 [1612486801000, 28],
        //                 [1612573201000, 9],

        //             ]
        //         },
        //         {
        //             name: 'Re-Opened Grievance',
        //             data: [
        //                 [1609462801000, 9],
        //                 [1609549201000, 25],
        //                 [1609635601000, 11],
        //                 [1609722001000, 12],
        //                 [1609808401000, 24],
        //                 [1609894801000, 13],
        //                 [1609981201000, 28],
        //                 [1610067601000, 9],
        //                 [1610154001000, 11],
        //                 [1610240401000, 21],
        //                 [1610326801000, 13],
        //                 [1610413201000, 26],
        //                 [1610499601000, 28],
        //                 [1610586001000, 4],
        //                 [1610672401000, 4],
        //                 [1610758801000, 26],
        //                 [1610845201000, 10],
        //                 [1610931601000, 20],
        //                 [1611018001000, 4],
        //                 [1611104401000, 15],
        //                 [1611190801000, 14],
        //                 [1611277201000, 14],
        //                 [1611363601000, 25],
        //                 [1611450001000, 12],
        //                 [1611536401000, 9],
        //                 [1611622801000, 28],
        //                 [1611709201000, 5],
        //                 [1611795601000, 19],
        //                 [1611882001000, 11],
        //                 [1611968401000, 2],
        //                 [1612054801000, 27],
        //                 [1612141201000, 10],
        //                 [1612227601000, 26],
        //                 [1612314001000, 5],
        //                 [1612400401000, 3],
        //                 [1612486801000, 22],
        //                 [1612573201000, 12],

        //             ]
        //         },
        //         {
        //             name: 'Reminded Grievance',
        //             data: [
        //                 [1609462801000, 8],
        //                 [1609549201000, 12],
        //                 [1609635601000, 21],
        //                 [1609722001000, 15],
        //                 [1609808401000, 24],
        //                 [1609894801000, 22],
        //                 [1609981201000, 3],
        //                 [1610067601000, 16],
        //                 [1610154001000, 2],
        //                 [1610240401000, 14],
        //                 [1610326801000, 18],
        //                 [1610413201000, 15],
        //                 [1610499601000, 26],
        //                 [1610586001000, 2],
        //                 [1610672401000, 11],
        //                 [1610758801000, 28],
        //                 [1610845201000, 3],
        //                 [1610931601000, 22],
        //                 [1611018001000, 26],
        //                 [1611104401000, 8],
        //                 [1611190801000, 19],
        //                 [1611277201000, 8],
        //                 [1611363601000, 11],
        //                 [1611450001000, 21],
        //                 [1611536401000, 17],
        //                 [1611622801000, 3],
        //                 [1611709201000, 10],
        //                 [1611795601000, 15],
        //                 [1611882001000, 12],
        //                 [1611968401000, 14],
        //                 [1612054801000, 4],
        //                 [1612141201000, 15],
        //                 [1612227601000, 27],
        //                 [1612314001000, 15],
        //                 [1612400401000, 25],
        //                 [1612486801000, 15],
        //                 [1612573201000, 28],

        //             ]
        //         },
        //         {
        //             name: 'Closed Grievance',
        //             data: [
        //                 [1609462801000, 18],
        //                 [1609549201000, 8],
        //                 [1609635601000, 14],
        //                 [1609722001000, 25],
        //                 [1609808401000, 5],
        //                 [1609894801000, 13],
        //                 [1609981201000, 19],
        //                 [1610067601000, 25],
        //                 [1610154001000, 4],
        //                 [1610240401000, 24],
        //                 [1610326801000, 13],
        //                 [1610413201000, 26],
        //                 [1610499601000, 19],
        //                 [1610586001000, 27],
        //                 [1610672401000, 5],
        //                 [1610758801000, 7],
        //                 [1610845201000, 23],
        //                 [1610931601000, 3],
        //                 [1611018001000, 5],
        //                 [1611104401000, 13],
        //                 [1611190801000, 12],
        //                 [1611277201000, 23],
        //                 [1611363601000, 16],
        //                 [1611450001000, 7],
        //                 [1611536401000, 15],
        //                 [1611622801000, 10],
        //                 [1611709201000, 22],
        //                 [1611795601000, 28],
        //                 [1611882001000, 20],
        //                 [1611968401000, 22],
        //                 [1612054801000, 2],
        //                 [1612141201000, 20],
        //                 [1612227601000, 13],
        //                 [1612314001000, 14],
        //                 [1612400401000, 9],
        //                 [1612486801000, 6],
        //                 [1612573201000, 18],

        //             ]
        //         }
        //     ],
        //     responsive: {
        //         rules: [{
        //             condition: {
        //                 maxWidth: 500
        //             },
        //             chartOptions: {
        //                 legend: {
        //                     layout: 'horizontal',
        //                     align: 'center',
        //                     verticalAlign: 'bottom'
        //                 }
        //             }
        //         }]
        //     },
        //     exporting: {
        //         buttons: {
        //             contextButton: {
        //                 menuItems: [
        //                     'downloadJPEG',
        //                     'downloadPDF',
        //                     'downloadXLS',
        //                 ]
        //             }
        //         }
        //     }
        // });

        var graphString =  <?php echo $graphString;?>;
        var lines = graphString.split(/[,\. ]+/g);

        data = Highcharts.reduce(lines, function (arr, word) {
            var obj = Highcharts.find(arr, function (obj) {
            return obj.name === word;
            });
            if (obj) {
            obj.weight += 1;
            } else {
            obj = {
                name: word,
                weight: 1
            };
            arr.push(obj);
            }
            return arr;
        }, []);

        Highcharts.chart('container', {
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: 'जनता के प्रमुख मुद्दे'
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
        jQuery(document).ready(function($) {
            $('.disableKeyPress').bind('keypress', function(e) {
                e.preventDefault();
            });
        });
    </script>
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>

</html>