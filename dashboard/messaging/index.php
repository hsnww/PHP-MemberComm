<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/adminHead.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/functions.php'; ?>

<?php
$user_id = $_SESSION['user_id'];
$user_roles = getUserRoles($conn, $_SESSION['user_id']);

//تعريف عدد السجلات لكل صفحة
$records_per_page = 10;

//حساب العدد الإجمالي للسجلات:

$result_count = $conn->query("SELECT COUNT(*) as total FROM conversations");
$row_count = $result_count->fetch_assoc();
$total_records = $row_count['total'];
$total_pages = ceil($total_records / $records_per_page);

//تحديد الصفحة الحالية:
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;
if($current_page > $total_pages) {
    $current_page = $total_pages;
}
if($current_page < 1) {
    $current_page = 1;
}
$offset = ($current_page - 1) * $records_per_page;


if(isset($_SESSION['user_id']) && (array_search(1, $user_roles) !== false )) {
    $query = "
SELECT
conversations.id AS conversation_id,
conversations.subject,
conversations.is_group,
conversations.is_closed,
conversations.created_at,
first_message.sender_id AS starter_id,
first_message.content AS first_message_content,
profiles.first_name AS starter_first_name,
profiles.last_name AS starter_last_name,
COUNT(DISTINCT messages.id) AS total_messages,
COUNT(DISTINCT attachments.id) AS total_attachments
FROM 
conversations
JOIN 
messages AS first_message ON conversations.id = first_message.conversation_id
AND first_message.id = 
(SELECT MIN(id) FROM messages WHERE conversation_id = conversations.id)
JOIN 
messages ON conversations.id = messages.conversation_id
LEFT JOIN 
attachments ON messages.id = attachments.message_id
JOIN 
conversation_members ON conversations.id = conversation_members.conversation_id
LEFT JOIN 
profiles ON first_message.sender_id = profiles.user_id

GROUP BY 
conversations.id
ORDER BY 
conversations.created_at DESC
";

//    تعديل الاستعلام SQL لتضمين LIMIT:
    $query .= " LIMIT " . $offset . ", " . $records_per_page;

    $stmt = $conn->prepare($query);
    $stmt->execute();

    $result = $stmt->get_result();
    $allConversations = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Messaging</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?php echo $base_url; ?>dashboard/assets/img/favicon.png" rel="icon">
    <link href="<?php echo $base_url; ?>dashboard/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">

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
include $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/template_sidebar.php';
?>
<!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle">
        <h1>Messaging system</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>dashboard/pages-index.html">Home</a></li>
                <li class="breadcrumb-item">Messaging system</li>
                <li class="breadcrumb-item active">List of messages</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">
            <div class="col">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">All messages ( <?php echo $total_records ?> )</h5>

                        <?php
                        if (isset($_SESSION['message'])) {
                            echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
                            unset($_SESSION['message']);
                        }
                        unset($_SESSION['message']);
                        ?>

                        <!-- Default Table -->
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">From</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Status</th>
                                <th scope="col"><i class="ri-chat-3-fill" style="font-size: 1.6em;"></i></th>
                                <th scope="col"><i class="ri-account-pin-circle-fill" style="font-size: 1.6em;"></i>
                                </th>
                                <th scope="col"><i class="ri-attachment-2" style="font-size: 1.6em;"></i></th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach ($allConversations as $conversation) {
                                ?>

                                <tr>
                                    <th scope="row"><?php echo $conversation['conversation_id'] ?></th>
                                    <td><?php echo $conversation['starter_first_name'] . " " . $conversation['starter_last_name'] ?></td>
                                    <td><a href="message.php?id=<?php echo $conversation['conversation_id'] ?>">
                                            <?php echo $conversation['subject'] ?></a>
                                        <p><small><?php echo $conversation['created_at'] ?></small></p>
                                    </td>
                                    <td>
                                        <?php
                                        if (userCanManageConversation($conn, $user_id, $conversation['conversation_id'])) { ?>
                                            <a href="toggle_conversation_status.php?conversation_id=<?php echo $conversation['conversation_id'] ?> "><?php displayConversationStatusIcon($conn, $conversation['conversation_id']); ?> </a>
                                        <?php } else { ?>
                                            <?php displayConversationStatusIcon($conn, $conversation['conversation_id']); ?>
                                        <?php } ?>

                                    </td>

                                    <td><?php echo $conversation['total_messages'] ?></td>
                                    <td><?php $membersCount = getConversationMembers($conn, $conversation['conversation_id']);
                                        echo $membersCount; ?></td>
                                    <td><?php echo $conversation['total_attachments'] ?></td>
                                    <td colspan="3">
                                        <a href="delete_conversation_confirm.php?id=<?php echo $conversation['conversation_id'] ?>">delete</a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                            </tbody>
                        </table>
                        <!-- End Default Table Example -->

                        <nav aria-label="...">
                            <ul class="pagination">
                                <?php for($page = 1; $page <= $total_pages; $page++): ?>
                                <li class="page-item <?php if($page == $current_page) echo 'active'; ?>" aria-current="page">
                                    <span class="page-link">
                                     <a href="?page=<?php echo $page; ?>">
                                    <?php echo $page; ?>
                                </a>
                                    </span>
                                </li>
                                <?php endfor; ?>
                            </ul>
                        </nav>

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