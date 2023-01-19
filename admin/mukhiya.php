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
                                            <h4 class="nk-block-title">Mukhiya</h4>
                                        </div>
                                    </div>
                                    <div class="card card-preview w-100" style="width: max-content;">
                                        <div class="card-inner">
                                            <form method="POST" class="gy-3">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Vidhan Sabha</label>
                                                            <select name="selected_Mandal" class="form-control">
                                                                <option value="" selected disabled hidden>Choose here
                                                                </option>
                                                                <option value="">test</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Panchayat</label>
                                                            <input type="text" class="form-control" placeholder="Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="form-label">Name</label>
                                                            <input type="text" class="form-control" placeholder="Name">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                    <div class="form-group">
                                                            <label class="form-label">Designations</label>
                                                            <input type="text" class="form-control" placeholder="Designation">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-2">
                                                    <div class="form-group">
                                                            <label class="form-label">Contact Details</label>
                                                            <input type="text" class="form-control" placeholder="Contact Details">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 mt-2">
                                                    <div class="form-group">
                                                            <label class="form-label">DOB</label>
                                                            <input type="text" class="form-control" placeholder="DOB">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 align-self-end">
                                                        <button name="import" type="submit"
                                                            class="btn btn-lg btn-primary">Submit</button>
                                                    </div>
                                                </div>
                                            </form>
                                            <div class="row">
                                                <div class="col-md-12 mt-5">
                                                    <table class="table table-striped table-bordered table-hover" id="panchayatList">
                                                        <thead>
                                                            <tr>
                                                                <th class="py-3">S.No.</th>
                                                                <th class="py-3">Name</th>
                                                                <th class="py-3">Phone</th>
                                                                <th class="py-3">Email</th>
                                                                <th class="py-3">Action</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Deepak</td>
                                                                <td>+91 000 0000 000</td>
                                                                <td>deepak@gmail.com</td>
                                                                <td>
                                                                    <a href="#!"
                                                                        class="btn btn-icon btn-trigger btn-tooltip"
                                                                        title="Edit"><em
                                                                            class="icon ni ni-edit"></em></a>
                                                                    <a href="#!"
                                                                        class="btn btn-icon btn-trigger btn-tooltip"
                                                                        title="Delete"><em
                                                                            class="icon ni ni-trash"></em></a>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>1</td>
                                                                <td>Deepak</td>
                                                                <td>+91 000 0000 000</td>
                                                                <td>deepak@gmail.com</td>
                                                                <td>
                                                                    <a href="#!"
                                                                        class="btn btn-icon btn-trigger btn-tooltip"
                                                                        title="Edit"><em
                                                                            class="icon ni ni-edit"></em></a>
                                                                    <a href="#!"
                                                                        class="btn btn-icon btn-trigger btn-tooltip"
                                                                        title="Delete"><em
                                                                            class="icon ni ni-trash"></em></a>
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