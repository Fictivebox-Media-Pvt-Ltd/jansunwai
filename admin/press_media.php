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
                                            <h4 class="nk-block-title">Press</h4>
                                        </div>
                                    </div>
                                    <div class="card card-preview w-100" style="width: max-content;">
                                        <div class="card-inner">
                                        <form method="POST" class="gy-3">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">News Channels</label>
                                                            <select name="selected_Mandal" class="form-control">
                                                                <option value="" selected disabled hidden>Choose here
                                                                </option>
                                                                <option value="">test</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label class="form-label">Reporter Name</label>
                                                            <input type="text" class="form-control" placeholder="Reporter Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Broadcast area</label>
                                                            <input type="text" class="form-control" placeholder="Broadcast area">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label class="form-label">Address</label>
                                                            <input type="text" class="form-control" placeholder="Address">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-2">
                                                    <div class="form-group">
                                                            <label class="form-label">Website</label>
                                                            <input type="text" class="form-control" placeholder="Website">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-2">
                                                    <div class="form-group">
                                                            <label class="form-label">Phone</label>
                                                            <input type="text" class="form-control" placeholder="Phone">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-2">
                                                    <div class="form-group">
                                                            <label class="form-label">Email</label>
                                                            <input type="email" class="form-control" placeholder="Email">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-2">
                                                    <div class="form-group">
                                                            <label class="form-label">Location</label>
                                                            <input type="text" class="form-control" placeholder="Location">
                                                        </div>
                                                    </div>
                                                   
                                                    <div class="col-md-3 mt-2 align-self-end">
                                                        <button name="import" type="submit" class="btn btn-lg btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row">
                                                <div class="col-md-12 mt-4">
                                                    <table class="table table-striped table-bordered table-hover" id="panchayatList">
                                                        <thead>
                                                            <tr>
                                                                <th class="py-3">S.No.</th>
                                                                <th class="py-3">News&nbsp;Channels</th>
                                                                <th class="py-3">Reporter&nbsp;Name</th>
                                                                <th class="py-3">Broadcast&nbsp;area</th>
                                                                <th class="py-3">Address</th>
                                                                <th class="py-3">Website</th>
                                                                <th class="py-3">Phone</th>
                                                                <th class="py-3">Email</th>
                                                                <th class="py-3">Location</th>
                                                                <th class="py-3">Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Aaj Tak</td>
                                                                <td>Deepak</td>
                                                                <td>India and international</td>
                                                                <td>Noida, Uttar Pradesh, India</td>
                                                                <td><a href="">www.aajtak.in</a></td>
                                                                <td>+91 000 0000 000</td>
                                                                <td>deepak@gmail.com</td>
                                                                <td>Location</td>
                                                                <td>
                                                                    <a href="#!" class="btn btn-icon btn-trigger btn-tooltip" title="Edit"><em class="icon ni ni-edit"></em></a>
                                                                    <a href="#!" class="btn btn-icon btn-trigger btn-tooltip" title="Delete"><em class="icon ni ni-trash"></em></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>2</td>
                                                                <td>ABP News</td>
                                                                <td>Deepak</td>
                                                                <td>India and international</td>
                                                                <td>Sector 16 A, Noida</td>
                                                                <td><a href=""> www.abplive.com</a></td>
                                                                <td>+91 000 0000 000</td>
                                                                <td>deepak@gmail.com</td>
                                                                <td>Location</td>
                                                                <td>
                                                                    <a href="#!" class="btn btn-icon btn-trigger btn-tooltip" title="Edit"><em class="icon ni ni-edit"></em></a>
                                                                    <a href="#!" class="btn btn-icon btn-trigger btn-tooltip" title="Delete"><em class="icon ni ni-trash"></em></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>3</td>
                                                                <td>India TV</td>
                                                                <td>Deepak</td>
                                                                <td>India</td>
                                                                <td>B-30, Sector 85, Noida, Uttar Pradesh, India</td>
                                                                <td><a href="">www.indiatv.in</a></td>
                                                                <td>+91 000 0000 000</td>
                                                                <td>deepak@gmail.com</td>
                                                                <td>Location</td>
                                                                <td>
                                                                    <a href="#!" class="btn btn-icon btn-trigger btn-tooltip" title="Edit"><em class="icon ni ni-edit"></em></a>
                                                                    <a href="#!" class="btn btn-icon btn-trigger btn-tooltip" title="Delete"><em class="icon ni ni-trash"></em></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
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
    <script src="assets/js/bundle.js?ver=2.2.0"></script>
    <script src="assets/js/scripts.js?ver=2.2.0"></script>
    <script src="assets/js/charts/chart-ecommerce.js?ver=2.2.0"></script>
</body>

</html>