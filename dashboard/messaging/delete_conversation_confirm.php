<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/adminHead.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/functions.php';

if (!isset($_GET['id'])) {
    die("No conversation ID provided.");
}

$conversationId = $_GET['id'];

// تأكد من أن المستخدم هو المسؤول (Administrator)
$userRoles = getUserRoles($conn, $_SESSION['user_id']);
if (!in_array(1, $userRoles)) {
    die("You do not have the permission to delete this conversation.");
}

// جلب عدد الرسائل والمرفقات
$query_message_count = "SELECT COUNT(id) as messageCount FROM messages WHERE conversation_id = ?";
$stmt_message_count = $conn->prepare($query_message_count);
$stmt_message_count->bind_param("i", $conversationId);
$stmt_message_count->execute();
$messageCount = $stmt_message_count->get_result()->fetch_assoc()['messageCount'];

$query_attachment_count = "SELECT COUNT(attachments.id) as attachmentCount FROM attachments JOIN messages ON messages.id = attachments.message_id WHERE messages.conversation_id = ?";
$stmt_attachment_count = $conn->prepare($query_attachment_count);
$stmt_attachment_count->bind_param("i", $conversationId);
$stmt_attachment_count->execute();
$attachmentCount = $stmt_attachment_count->get_result()->fetch_assoc()['attachmentCount'];

$confirmationMessage = "A conversation, " . $messageCount . " replies, and " . $attachmentCount . " files will be permanently deleted. This action cannot be undone.";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?php echo $base_url; ?>dashboard/assets/img/favicon.png" rel="icon">
    <link href="<?php echo $base_url; ?>dashboard/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="<?php echo $base_url; ?>dashboard/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>dashboard/assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>dashboard/assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>dashboard/assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>dashboard/assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>dashboard/assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="<?php echo $base_url; ?>dashboard/assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?php echo $base_url; ?>dashboard/assets/css/style.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: NiceAdmin
    * Updated: Sep 18 2023 with Bootstrap v5.3.2
    * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body>

<!-- ======= Header ======= -->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/dashboard_header.php';
?>
<!-- End Header -->

<!-- ======= Sidebar ======= -->
<?php
include $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/template_sidebar.php';
?>
<!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Blank Page</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="pages-index.html">Home</a></li>
                <li class="breadcrumb-item">Pages</li>
                <li class="breadcrumb-item active">Confirm deleting conversation</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <h4 class="alert-heading">Danger step</h4>
        <h5>Read carefully</h5>
        <p><?php echo $confirmationMessage ?></p>
        <hr>
        <h5 class="m-3">Are you sure?</h5>
        <a href="delete_conversation.php?id=<?php echo $conversationId; ?>" onclick="return confirm('<?php echo $confirmationMessage; ?>')" class="btn btn-danger">Delete conversation</a>

    </div>

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

<a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

<!-- Vendor JS Files -->
<script src="<?php echo $base_url; ?>dashboard/assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="<?php echo $base_url; ?>dashboard/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo $base_url; ?>dashboard/assets/vendor/chart.js/chart.umd.js"></script>
<script src="<?php echo $base_url; ?>dashboard/assets/vendor/echarts/echarts.min.js"></script>
<script src="<?php echo $base_url; ?>dashboard/assets/vendor/quill/quill.min.js"></script>
<script src="<?php echo $base_url; ?>dashboard/assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="<?php echo $base_url; ?>dashboard/assets/vendor/tinymce/tinymce.min.js"></script>
<script src="<?php echo $base_url; ?>dashboard/assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="<?php echo $base_url; ?>dashboard/assets/js/main.js"></script>

</body>

</html>