<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/userHead.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/functions.php'; ?>
<?php $result_roles = $conn->query("SELECT * FROM roles"); ?>
<?php
$query = "SELECT id, role_name FROM roles";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Tables / General - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?php echo $base_url ?>dashboard/assets/img/favicon.png" rel="icon">
    <link href="<?php echo $base_url ?>dashboard/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <!-- Vendor CSS Files -->
    <link href="<?php echo $base_url ?>dashboard/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>dashboard/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>dashboard/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>dashboard/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>dashboard/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>dashboard/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo $base_url ?>dashboard/assets/vendor/simple-datatables/style.css" rel="stylesheet">
    <!-- Template Main CSS File -->
    <link href="<?php echo $base_url ?>dashboard/assets/css/style.css" rel="stylesheet">
    <!-- =======================================================
    * Template Name: NiceAdmin
    * Updated: Sep 18 2023 with Bootstrap v5.3.2
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
    <!--    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->

</head>

<body>

<!-- ======= Header ======= -->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/dashboard_header.php';
?>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/dashboard_sidebar.php';
?>
<!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle">
        <h1>New Conversation</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $base_url ?>dashboard">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">New conversation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">General Form Elements</h5>

                        <!-- General Form Elements -->
                        <form method="post" action="send_message.php" enctype="multipart/form-data">
                            <div class="row mb-3">
                                <label for="inputText" class="col-sm-2 col-form-label">Subject</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="subject" required>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputPassword" class="col-sm-2 col-form-label">Message</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" style="height: 100px"  name="message" required></textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-2 col-form-label">Attachment</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="file" id="formFile"  name="attachment">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="inputNumber" class="col-sm-2 col-form-label">To</label>
                                <div class="col-3 m-1">
                                    <div class="row mb-3">
<!--                                        <label class="col-sm-2 col-form-label">Roles</label>-->
                                            <select class="form-select" multiple  id="roleSelector" name="role_id" required>
                                                <option selected="">Select one</option>
                                                <option value="all">All</option>

                                                <?php  while ($role = $result->fetch_assoc()) { ?>
                                                <option value="<?php echo $role['id'] ?>"><?php echo $role['role_name'] ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                </div>
                                <div class="col-6 m-1 ">
                                    <div class="row mb-3">
<!--                                        <labelabel class="col-sm-2 col-form-label">Users</labelabel>-->
                                            <select multiple class="form-select" id="recipient_id_string" name="recipient_id_string[]" required>
                                                <option>Select role to see users</option>
                                            </select>
                                    </div></div>
                                </div>

                            <fieldset class="row mb-3">
                                <legend class="col-form-label col-sm-2 pt-0">Conversation status</legend>
                                <div class="col-sm-10">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios1" value="option1" checked="">
                                        <label class="form-check-label" for="gridRadios1">
                                            Open conversation
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="gridRadios" id="gridRadios2" value="option2">
                                        <label class="form-check-label" for="gridRadios2">
                                            Closed conversation
                                        </label>
                                    </div>
                                </div>
                            </fieldset>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label">Submit Button</label>
                                <div class="col-sm-10">
                                    <button type="submit" class="btn btn-primary" >Submit Form</button>
                                </div>
                            </div>

                        </form><!-- End General Form Elements -->

                    </div>
                </div>

            </div>

        </div>
    </section>
</main><!-- End #main -->

<!-- ======= Footer ======= -->
<footer id="footer" class="footer">
    <div class="copyright">
        &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
        <!-- All the links in the footer should remain intact. -->
        <!-- You can delete the links only if you purchased the pro version. -->
        <!-- Licensing information: https://bootstrapmade.com/license/ -->
        <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
        Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
    </div>
</footer><!-- End Footer -->

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?php echo $base_url ?>dashboard/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo $base_url ?>dashboard/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $base_url ?>dashboard/assets/vendor/chart.js/chart.umd.js"></script>
<script src="<?php echo $base_url ?>dashboard/assets/vendor/echarts/echarts.min.js"></script>
<script src="<?php echo $base_url ?>dashboard/assets/vendor/quill/quill.min.js"></script>
<script src="<?php echo $base_url ?>dashboard/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="<?php echo $base_url ?>dashboard/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="<?php echo $base_url ?>dashboard/assets/vendor/php-email-form/validate.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- Template Main JS File -->
<script src="<?php echo $base_url ?>dashboard/assets/js/main.js"></script>

<script>
    // $(document).ready(function() {
    //     $('#roleSelector').change(function() {
    //         let selectedRoles = $(this).val();
    //         $.ajax({
    //             url: 'get_users.php',
    //             type: 'GET',
    //             data: {role_id: selectedRoles},
    //             success: function(data) {
    //                 $('#users').html(data);
    //             }
    //         });
    //     });
    // });
    $(document).ready(function() {
        $('#roleSelector').change(function() {
            let selectedValue = $(this).val();

            let dataToSend = selectedValue === "all" ? {} : {role_id: selectedValue};

            $.ajax({
                url: 'get_users.php',
                type: 'GET',
                data: dataToSend,
                success: function(data) {
                    $('#recipient_id_string').html(data);
                }
            });
        });
    });

</script>

</body>

</html>