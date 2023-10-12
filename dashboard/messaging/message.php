<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/userHead.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/functions.php'; ?>
<?php
$conversationId = $_GET['id'];
$user_id = $_SESSION['user_id'];
$user_roles = getUserRoles($conn, $user_id);
$allowed_roles = [1, 2];
// الاستعلام للتحقق من مشاركة المستخدم في المحادثة
$memberCheckQuery = "SELECT id FROM conversation_members WHERE conversation_id = ? AND user_id = ?";
$memberCheckStmt = $conn->prepare($memberCheckQuery);
$memberCheckStmt->bind_param("ii", $conversationId, $user_id);
$memberCheckStmt->execute();
$memberCheckResult = $memberCheckStmt->get_result();
// إذا لم يتم العثور على السجل، يعني أن المستخدم الحالي ليس جزءًا من المحادثة

if ($memberCheckResult->num_rows === 0 || array_search('Administrator', $user_roles) === false) {
    $_SESSION['errorMessage'] = "ليس لديك الصلاحية للوصول إلى هذه المحادثة.";
    header("Location: inbox.php");
//    die("ليس لديك الصلاحية للوصول إلى هذه المحادثة.");
}

// الاستعلام لجلب تفاصيل المحادثة نفسها
$convoQuery = "SELECT * FROM conversations WHERE id = ?";
$convoStmt = $conn->prepare($convoQuery);
$convoStmt->bind_param("i", $conversationId);
$convoStmt->execute();
$convoResult = $convoStmt->get_result();
$conversation = $convoResult->fetch_assoc();
// الاستعلام لجلب تفاصيل المحادثة والرسائل المرتبطة بها
$query = "
SELECT 
messages.content, 
messages.sent_at, 
profiles.first_name, 
profiles.last_name, 
profiles.avatar, 
attachments.file_path, 
attachments.file_type, 
attachments.file_size, 
attachments.uploaded_at
FROM messages 
JOIN profiles ON messages.sender_id = profiles.user_id 
LEFT JOIN attachments ON messages.id = attachments.message_id 
WHERE messages.conversation_id = ? 
ORDER BY messages.sent_at ASC;
";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $conversationId);
$stmt->execute();
$result = $stmt->get_result();
$messages = $result->fetch_all(MYSQLI_ASSOC);
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
    <link href="<?php echo $base_url; ?>dashboard/assets/img/favicon.png" rel="icon">
    <link href="<?php echo $base_url; ?>dashboard/assets/img/apple-touch-icon.png" rel="apple-touch-icon">
    <!-- Google Fonts -->
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i"
          rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
    <style>
        .search-result .form-check {
            background-color: #f3f3f3; /* اختر اللون الذي تريده هنا */
            padding: 10px;
            margin: 5px 0;
            border-radius: 5px; /* إذا كنت ترغب في تقريب الزوايا قليلًا */
        }
    </style>
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
        <h1>General Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $base_url; ?>dashboard/pages-index.html">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active"><?php echo $conversation['subject']; ?></li>
            </ol>
        </nav>
    </div><!-- End Page Title -->
    <section class="section">
        <div class="row align-items-top">
            <div class="col-lg-10">
                <form method="post" action="add_members.php" id="addMembersForm">
                    <input type="text" name="searchUser" id="searchUser" placeholder="Search by name"
                           class="form-control m-2">
                    <!-- إضافة عنصر الإدخال المخفي -->
                    <input type="hidden" name="conversationId" value="<?php echo $conversationId; ?>">
                    <div id="searchResults">
                        <!-- النتائج ستظهر هنا -->
                    </div>
                    <div id="resultsDiv"></div>
                    <input type="submit" value="Add selected users" class="btn btn-secondary m-2">
                </form>
                <?php
                if (isset($_SESSION['message'])) {
                    echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
                    unset($_SESSION['message']);
                }
                unset($_SESSION['message']);
                ?>
                <?php
                if (isset($_SESSION['error_file_message'])) {
                    echo "<div class='alert alert-danger'>" . $_SESSION['error_file_message'] . "</div>";
                    unset($_SESSION['error_file_message']);
                }
                unset($_SESSION['error_file_message']);
                ?>
                <!-- Card with header and footer -->
                <div class="card">
                    <div class="card-header">
                        <h3><?php echo $conversation['subject']; ?></h3>
                        <br>
                    </div>
                    <div class="card-body">
                        <?php foreach ($messages as $message): ?>
                            <div class="row">

                                <div class="col-2">
                                    <img class="img img-thumbnail"
                                         src="<?php echo $base_url ?>src/avatars/<?php echo $message['avatar'] ? $message['avatar'] : 'default-photo-male.jpg'; ?>"
                                         alt="<?php echo $message['first_name']; ?>" style="width: 80px">
                                    <h5 class="mt-0 mb-1"><?php echo $message['first_name']; ?></h5>
                                    <small><?php
                                        list($date, $time) = explode(" ", $message['sent_at']);
                                        echo $date . "<br>" . $time;; ?>
                                    </small>
                                </div>
                                <div class="col-10"> <?php echo nl2br($message['content']); ?>

                                    <?php
                                    if (!empty($message['file_path'])) { ?>
                                        <div>Attachment : <a
                                                    href="<?php echo $base_url ?>src/attachments/<?php echo $message['file_path'] ?>"
                                                    target="_blank">
                                                <?php $file_extension = pathinfo($message['file_path'], PATHINFO_EXTENSION);
                                                echo getFileIcon($file_extension) . " " . $message['file_path'];
                                                ?>
                                            </a>
                                            <p><?php echo formatBytes($message['file_size']); ?></p>
                                        </div>
                                        <?php
                                    }
                                    ?>
                                </div>
                            </div>


                            <hr>

                        <?php endforeach; ?>

                    </div>
                    <div class="card-footer">
                        <p>
                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#exampleModalLong">
                                Members in this
                                conversation: <?php $numberOfMembers = getConversationMembers($conn, $conversationId);
                                echo $numberOfMembers;
                                ?>
                            </button>
                        </p>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModalLong" tabindex="-1" role="dialog"
                             aria-labelledby="exampleModalLongTitle" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Members in this
                                            conversation</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="remove_members.php" method="post" >
                                            <input type="hidden" name="conversationId" value="<?php echo $conversationId ?>">
                                        <ul class="list-group">
                                            <?php $membersDetails = getConversationMembers($conn, $conversationId, true);
                                            foreach ($membersDetails as $member) {
                                                ?>
                                                <li class="list-group-item">
                                                    <img src="<?php echo $base_url ?>src/avatars/<?php echo $member['avatar'] ? $member['avatar'] : 'default-photo-male.jpg'; ?>" alt="Profile" class="rounded-circle" style="width: 30px;">
                                                    <?php echo $member['first_name'] . ' ' . $member['last_name']; ?>
                                                    <i class="float-end">
                                                            <input type="checkbox" name="users[]" id="usersIds" value="<?php echo $member['userId'] ?>">
                                                    </i>
                                                </li>
                                            <?php }; ?>
                                        </ul>
                                            <input type="submit" value="Remove selected" class="btn btn-danger mt-2">
                                        </form>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- End Card with header and footer -->
            </div>
        </div>
        <div class="row">
            <div class="col-lg-8">
                <?php if ($conversation['is_closed'] == 0) { ?>
                    <div class="card ml-auto">
                        <div class="card-body">
                            <h5 class="card-title">Add message to this conversation</h5>
                            <!-- General Form Elements -->
                            <form action="add_reply.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="conversation_id" value="<?php echo $conversationId; ?>">
                                <div class="row mb-3">
                                    <label for="inputPassword" class="col-sm-2 col-form-label">Textarea</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" name="message" style="height: 100px"></textarea>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="inputNumber" class="col-sm-2 col-form-label">File Upload</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="file" name="attachment" id="attachment">
                                    </div>
                                </div>
                                <?php if (userCanManageConversation($conn, $user_id, $conversationId)) { ?>
                                    <div class="row mb-3">
                                        <legend class="col-form-label col-sm-2 pt-0"></legend>
                                        <div class="col-sm-10">

                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="close_it"
                                                       id="close_it" value="true">
                                                <label class="form-check-label" for="gridCheck1">
                                                    Close conversation
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <div class="row mb-3">
                                    <label class="col-sm-2 col-form-label"></label>
                                    <div class="col-sm-10">
                                        <button type="submit" class="btn btn-primary">Submit Form</button>
                                    </div>
                                </div>
                            </form><!-- End General Form Elements -->

                        </div>
                    </div>
                <?php } else { ?>
                    <div class="card ml-auto">
                        <div class="card-body">
                            <h5 class="card-title"><i class="ri-lock-2-fill"></i> Conversation is closed</h5>
                        </div>
                    </div>
                <?php } ?>
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
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Template Main JS File -->
<script src="<?php echo $base_url; ?>dashboard/assets/js/main.js"></script>
<script>
    let searchUserInput = document.getElementById('searchUser');

    searchUserInput.addEventListener('input', function () {
        let searchTerm = searchUserInput.value;
        let conversationId = document.querySelector("[name='conversationId']").value;

        if (searchTerm.length < 3) return;  // إذا كانت كلمة البحث أقل من 3 أحرف، لا تقم بأي شيء

        fetch('search_api.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'searchUser=' + searchTerm + '&conversationId=' + conversationId
        })
            .then(response => response.json())
            .then(data => {
// هنا سنتعامل مع البيانات المستعادة
                let resultsDiv = document.getElementById('searchResults');
                resultsDiv.innerHTML = ''; // تفريغ المحتوى الحالي

                data.forEach(user => {
                    let checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.name = 'selectedUsers[]';
                    checkbox.value = user.id;
                    checkbox.classList.add('form-check-input'); // تزيين المربع باستخدام Bootstrap

                    let label = document.createElement('label');
                    label.innerText = user.first_name + ' ' + user.last_name;
                    label.classList.add('form-check-label');  // تزيين النص باستخدام Bootstrap

                    let div = document.createElement('div');
                    div.classList.add('form-check', 'search-result'); // تزيين العنصر باستخدام Bootstrap
                    div.appendChild(checkbox);
                    div.appendChild(label);

                    resultsDiv.appendChild(div);
                });
            })
            .catch(error => {
                console.error('Error fetching data:', error);
            });
    });
</script>
<script>
    document.getElementById('addMembersForm').addEventListener('submit', function (event) {
        let checkboxes = this.querySelectorAll('input[name="selectedUsers[]"]:checked');
        if (checkboxes.length === 0) {
            alert('Please select at least one user.');
            event.preventDefault();  // هذا سيمنع النموذج من الإرسال
        }
    });
</script>
</body>
</html>