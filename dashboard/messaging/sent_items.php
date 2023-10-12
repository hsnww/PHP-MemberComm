<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/userHead.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/functions.php'; ?>

<?php
$user_id = $_SESSION['user_id'];
$user_roles = getUserRoles($conn, $user_id);
$allowed_roles = [1, 2];


$query_sent = "
SELECT 
    conversations.id AS conversation_id,
    conversations.subject,
    conversations.is_closed,
    first_sender.first_name AS starter_first_name,
    first_sender.last_name AS starter_last_name,
    COUNT(DISTINCT messages.id) AS message_count,
    COUNT(DISTINCT attachments.id) AS attachment_count,
    members_count.member_count AS total_members,
    MAX(messages.sent_at) AS last_message_sent_at
FROM 
    conversations
-- الانضمام للرسائل لجمع الرسائل والتحقق من المرسل
JOIN 
    messages ON conversations.id = messages.conversation_id
-- الانضمام للمرفقات لجمع الملفات المرفقة
LEFT JOIN 
    attachments ON messages.id = attachments.message_id
-- استعلام فرعي لتحديد من بدأ المحادثة
LEFT JOIN 
    (
        SELECT 
            sender_id,
            conversation_id,
            MIN(sent_at) AS first_sent_at,
            profiles.first_name,
            profiles.last_name
        FROM 
            messages
        JOIN profiles ON messages.sender_id = profiles.user_id
        GROUP BY 
            conversation_id, sender_id
    ) AS first_sender ON conversations.id = first_sender.conversation_id
-- استعلام فرعي لحساب عدد المشاركين في كل محادثة
        LEFT JOIN 
            (
                SELECT 
                    conversation_id,
                    COUNT(user_id) AS member_count
                FROM 
                    conversation_members
                GROUP BY 
                    conversation_id
            ) AS members_count ON conversations.id = members_count.conversation_id
WHERE 
    messages.sender_id = ?
GROUP BY 
    conversations.id,
    conversations.subject,
    --first_sender.first_name,
    --first_sender.last_name,
    members_count.member_count
ORDER BY 
    last_message_sent_at DESC;
";

$stmt_sent = $conn->prepare($query_sent);
$stmt_sent->bind_param("i", $user_id);
$stmt_sent->execute();
$result_sent = $stmt_sent->get_result();
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
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
    <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">

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
        <h1>Messaging system</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="../pages-index.html">Home</a></li>
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
                        <h5 class="card-title">Sent Items</h5>

                        <!-- Default Table -->
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">To</th>
                                <th scope="col">Subject</th>
                                <th scope="col"><i class="ri-chat-3-fill" style="font-size: 1.6em;"></i></th>
                                <th scope="col"><i class="ri-account-pin-circle-fill" style="font-size: 1.6em;"></i></th>
                                <th scope="col"><i class="ri-attachment-2" style="font-size: 1.6em;"></i></th>

                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                            while($row = $result_sent->fetch_assoc()) {
                            ?>
                            <tr>
                                <th scope="row"><?php echo $row['conversation_id']?></th>
                                <td><?php echo $row['starter_first_name'] . " " . $row['starter_last_name'] ?></td>
                                <td><a href="message.php?id=<?php echo $row['conversation_id']?>"><?php echo $row['subject']?></a><br>
                                <small><?php echo $row['last_message_sent_at'] ?></small>
                                </td>
                                <td><?php echo $row['message_count']?></td>
                                <td><?php $memberCount = getConversationMembers($conn, $row['conversation_id']);
                                    echo $memberCount;  // ستظهر لك القيمة مباشرة
                                    ?></td>
                                <td><?php echo $row['attachment_count']?></td>
                                <td>
                                    <?php
                                    $stmt = $conn->prepare("SELECT is_closed FROM conversations WHERE id = ?");
                                    $stmt->bind_param("i", $row['conversation_id']);
                                    $stmt->execute();

                                    $result = $stmt->get_result();
                                    $conversation = $result->fetch_assoc();

                                    ?>
                                    <?php
                                    if(userCanManageConversation($conn, $user_id, $row['conversation_id'])) { ?>
                                        <a href="toggle_conversation_status.php?conversation_id=<?php echo $row['conversation_id'] ?> "><?php displayConversationStatusIcon($conn, $row['conversation_id']); ?> </a>
                                    <?php } else { ?>
                                        <?php displayConversationStatusIcon($conn, $row['conversation_id']); ?>
                                    <?php } ?>

                                </td>

                                <td colspan="3">
                                    <a href=""><i class="bx bx-reply"></i></a>
                                    <a href=""><i class="bx bxs-comment-detail"></i></a>
                                    <a href=""><i class="bx bx-block"></i></a>
                                </td>
                            </tr>
                     <?php

                            }
                            } else { ?>
                            <tr>
                                <td colspan="5"><?php  echo "No messages found for this user."; ?></td>

                            </tr>
                                <?php

                            }
                            ?>
                            </tbody>
                        </table>
                        <!-- End Default Table Example -->
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
<script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
<script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="../assets/vendor/chart.js/chart.umd.js"></script>
<script src="../assets/vendor/echarts/echarts.min.js"></script>
<script src="../assets/vendor/quill/quill.min.js"></script>
<script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
<script src="../assets/vendor/tinymce/tinymce.min.js"></script>
<script src="../assets/vendor/php-email-form/validate.js"></script>

<!-- Template Main JS File -->
<script src="../assets/js/main.js"></script>

</body>

</html>