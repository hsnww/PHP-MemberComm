<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/adminHead.php'; ?>
<?php

$limit = 30;

// معرفة الصفحة الحالية
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? intval($_GET['page']) : 1;

// حساب الانطلاق للاستعلام
$offset = ($page - 1) * $limit;


$query = "SELECT 
    users.id as user_id,
    users.email,
    users.password,
    users.email_verified,
    users.verification_code,
    users.created_at,
    profiles.first_name,
    profiles.last_name,
    profiles.avatar,
    profiles.bio,
    profiles.phone,
    profiles.address,
    GROUP_CONCAT(roles.role_name) as roles
FROM 
    users
LEFT JOIN 
    profiles ON users.id = profiles.user_id
LEFT JOIN 
    role_user ON users.id = role_user.user_id
LEFT JOIN 
    roles ON role_user.role_id = roles.id";

$whereClauses = [];

// فحص قيمة search_value و search_field
if(isset($_GET['search_value']) && isset($_GET['search_field'])) {
    $searchValue = $conn->real_escape_string($_GET['search_value']); // تأكيد الحصول على نص آمن
    $searchField = $conn->real_escape_string($_GET['search_field']); // تأكيد الحصول على نص آمن
    $whereClauses[] = "$searchField LIKE '%$searchValue%'";
}

// إضافة الشروط إلى الاستعلام
if(count($whereClauses) > 0) {
    $query .= " WHERE " . implode(' AND ', $whereClauses);
}


$query .= " GROUP BY users.id";
$query .= " LIMIT $limit OFFSET $offset";

$result = $conn->query($query);


// إظهار النتائج هنا



// الاستعلام لمعرفة إجمالي عدد السجلات
$total_query = "SELECT COUNT(*) as total FROM users";


$total_result = $conn->query($total_query);
$total_row = $total_result->fetch_assoc();
$total_pages = ceil($total_row['total'] / $limit);
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
include $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/dashboard_sidebar.php';
?>
<!-- End Sidebar-->

<main id="main" class="main">

    <div class="pagetitle">
        <h1>General Tables</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?php echo $base_url ?>dashboard">Home</a></li>
                <li class="breadcrumb-item">Tables</li>
                <li class="breadcrumb-item active">General</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section">
        <div class="row">

            <div class="col">

                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Table with hoverable rows</h5>

                        <?php if(isset($_SESSION['message'])) { ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-1"></i>
                                <?php echo $_SESSION['message'] ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            <?php unset($_SESSION['message']) ?>
                        <?php } ?>

                        <form action="index.php" method="GET">
                            <div class="row mt-2">
                                <div class="col-md-5">
                                    <label>
                                        <input type="text" name="search_value" placeholder="أدخل نص البحث هنا"
                                               class="form-control" required="required">
                                    </label>
                                </div>
                                <div class="col-md-5">
                                    <select name="search_field" class="custom-select form-control " required="required">
                                        <option value="">البحث في ؟</option>
                                        <option value="first_name">الاسم الأول</option>
                                        <option value="last_name">الاسم الأخير</option>
                                        <option value="email">البريد الإلكتروني</option>
                                        <option value="phone">رقم الجوال</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="submit" value="بحث" class="btn btn-primary">
                                </div>
                            </div>
                        </form>

                        <!-- Table with hoverable rows -->
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">Check</th>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Phone</th>
                                <th scope="col">Roles</th>
                                <th scope="col">Join Date</th>
                                <th scope="col" colspan="3">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <form method="post" action="<?php echo $base_url; ?>messaging/chat.php">
                                <?php while ($row = $result->fetch_assoc()): ?>
                                <tr>
                                    <td><input type="checkbox" name="recipient_id[]" id="recipient_id" value="<?php echo $row['user_id']; ?>"></td>
                                    <th scope="row"><?php echo $row['user_id']; ?></th>
                                    <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                    <td><?php echo $row['email']; ?></td>
                                    <td><?php echo $row['phone']; ?></td>
                                    <?php
                                    $roles_string = $row['roles'];
                                    // تقسيم السلسلة باستخدام الفاصلة للحصول على مصفوفة من الأدوار
                                    if ($roles_string) {  // تحقق من وجود قيمة
                                    $roles_array = explode(',', $roles_string);
                                    ?>
                                    <td><ul><?php  foreach ($roles_array as $role) { ?><?php echo '<li>'.$role.'</li>' ?><?php  } ?></ul></td>
                                    <?php } else { ?>
                                        <td>Nor roles for this user</td>
                                    <?php } ?>
                                    <td><?php echo $row['created_at']; ?></td>

                                    <td><a href='show.php?id=<?php echo $row['user_id']; ?>'><i class=" ri-eye-line"></i></a></td>
                                    <td><a href='edit.php?id=<?php echo $row['user_id']; ?>'><i class="ri-file-edit-line"></i></a></td>
                                    <td><a href="delete_user.php?id=<?php echo $row['user_id']; ?>" onclick="return confirm('هل أنت متأكد من حذف المستخدم المحدد')"><i class="ri-chat-delete-line"></i></a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                                <input type="submit" id="submitButton" value="Send Message" class="btn btn-primary">
                            </form>
                            </tbody>
                        </table>
                        <!-- End Table with hoverable rows -->
                        <?php
                        echo '<nav aria-label="Page navigation example">';
                        echo '<ul class="pagination">';

                        // عرض وصلة الصفحة السابقة إذا كنا لسنا في الصفحة الأولى
                        if ($page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">السابق</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><span class="page-link">السابق</span></li>';
                        }

                        // عدد الصفحات الذي نريد عرضه حول الصفحة الحالية
                        $range = 3;

                        if ($page < $range) {
                            for ($i = 1; $i < $page + $range && $i <= $total_pages; $i++) {
                                echo '<li class="page-item' . ($i == $page ? ' active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                            if ($total_pages > $page + $range) {
                                echo '<li class="page-item"><span class="page-link">...</span></li>';
                                echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                            }
                        } elseif ($page >= ($total_pages - $range)) {
                            if ($page - $range > 1) {
                                echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                                echo '<li class="page-item"><span class="page-link">...</span></li>';
                            }
                            for ($i = $page - $range + 1; $i <= $total_pages; $i++) {
                                echo '<li class="page-item' . ($i == $page ? ' active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                        } else {
                            echo '<li class="page-item"><a class="page-link" href="?page=1">1</a></li>';
                            echo '<li class="page-item"><span class="page-link">...</span></li>';
                            for ($i = ($page - $range + 1); $i < ($page + $range); $i++) {
                                echo '<li class="page-item' . ($i == $page ? ' active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                            }
                            echo '<li class="page-item"><span class="page-link">...</span></li>';
                            echo '<li class="page-item"><a class="page-link" href="?page=' . $total_pages . '">' . $total_pages . '</a></li>';
                        }

                        // عرض وصلة الصفحة التالية إذا كنا لسنا في الصفحة الأخيرة
                        if ($page < $total_pages) {
                            echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) .'">التالي</a></li>';
                        } else {
                            echo '<li class="page-item disabled"><span class="page-link">التالي</span></li>';
                        }

                        echo '</ul>';
                        echo '</nav>';
                        ?>
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
<script>
document.getElementById("submitButton").addEventListener("click", function(event) {
let checkboxes = document.querySelectorAll('input[type="checkbox"]');
let checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
if (!checkedOne) {
alert('يجب اختيار عنصر واحد على الأقل!');
event.preventDefault(); // لمنع إرسال النموذج
}
});
</script>
</body>

</html>