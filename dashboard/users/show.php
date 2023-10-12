<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/adminHead.php';
// الاستعلام عن الأدوار
$sql = "SELECT id, role_name FROM roles";
$result = $conn->query($sql);
$roles = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $roles[] = $row;
    }
}

$otification_sql = "SELECT id, notification_name, is_optional FROM notifications";
$otification_result = $conn->query($otification_sql);


$selected_notifications_sql = "SELECT notification_id FROM user_notifications WHERE user_id = $user_id";
$selected_result = $conn->query($selected_notifications_sql);

$selected_notifications = [];
while ($row = $selected_result->fetch_assoc()) {
    $selected_notifications[] = $row['notification_id'];
}

/////
$user_id = $_GET['id'];  // على سبيل المثال، نفترض أن المعرف المستخدم مخزن في متغير الجلسة

$query = "SELECT profiles.first_name
     , profiles.last_name
     , profiles.avatar
     , profiles.phone  
     , profiles.job  
     , profiles.address  
     , profiles.company  
     , profiles.country  
     , profiles.website  
     , profiles.twitter  
     , profiles.facebook  
     , profiles.instagram  
     , profiles.linkedin  
     , profiles.bio  
     , users.email
FROM profiles  
    JOIN users 
        ON users.id = profiles.user_id
 WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_info = $result->fetch_assoc();

//استخدام دالة معالجة فقدان ملق المستخدم في جدول profiles
ensureUserProfileExists($conn, $user_id);


// استعلام الأدوار المرتبطة بالمستخدم
$sql_roles = "SELECT roles.id, roles.role_name 
              FROM roles 
              JOIN role_user ON roles.id = role_user.role_id 
              WHERE role_user.user_id = ?";

$stmt_roles = $conn->prepare($sql_roles);
$stmt_roles->bind_param("i", $user_id);
$stmt_roles->execute();

$user_roles = [];
$result_roles = $stmt_roles->get_result();
while($row = $result_roles->fetch_assoc()) {
    $user_roles[] = $row['id'];
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Users / Profile - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
</head>

<body>

  <!-- ======= Header ======= -->
  <?php
  include $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/dashboard_header.php';
  ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php
  include $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/dashboard_sidebar.php';
  ?>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Profile</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?php echo $base_url ?>">Home</a></li>
          <li class="breadcrumb-item">Users</li>
          <li class="breadcrumb-item active">Profile</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->
      <?php if(isset($_SESSION['message'])) { ?>
          <div class="alert alert-<?php echo $_SESSION['bg']; ?> alert-dismissible fade show" role="alert">
              <i class="bi bi-check-circle me-1"></i>
              <?php echo $_SESSION['message'] ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['message']) ?>
      <?php } ?>
    <section class="section profile">
      <div class="row">
        <div class="col-xl-4">

          <div class="card">
            <div class="card-body profile-card pt-4 d-flex flex-column align-items-center">

              <img src="<?php echo $base_url ?>src/avatars/<?php echo $user_info['avatar'] ? $user_info['avatar'] : 'default-photo-male.jpg'; ?>" alt="Profile" class="rounded-circle">
              <h2><?php echo $user_info['first_name'].' '. $user_info['last_name']; ?></h2>
              <h3><?php echo $user_info['job']; ?></h3>
              <div class="social-links mt-2">
                <a href="<?php echo $user_info['twitter']; ?>" class="twitter"><i class="bi bi-twitter"></i></a>
                <a href="<?php echo $user_info['facebook']; ?>" class="facebook"><i class="bi bi-facebook"></i></a>
                <a href="<?php echo $user_info['instagram']; ?>" class="instagram"><i class="bi bi-instagram"></i></a>
                <a href="<?php echo $user_info['linkedin']; ?>" class="linkedin"><i class="bi bi-linkedin"></i></a>
              </div>
            </div>
          </div>

        </div>

        <div class="col-xl-8">

          <div class="card">
            <div class="card-body pt-3">
              <!-- Bordered Tabs -->
              <ul class="nav nav-tabs nav-tabs-bordered">

                <li class="nav-item">
                  <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#profile-overview">Overview</button>
                </li>

              </ul>
              <div class="tab-content pt-2">
                <div class="tab-pane fade show active profile-overview" id="profile-overview">
                    <h1>Over View</h1>
                    <h5 class="card-title">About</h5>
                  <p class="small fst-italic"><?php echo $user_info['bio']; ?></p>

                  <h5 class="card-title">Profile Details</h5>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label ">Full Name</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user_info['first_name'].' '.$user_info['last_name']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Company</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user_info['company']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Job</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user_info['job']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Country</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user_info['country']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Address</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user_info['address']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Phone</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user_info['phone']; ?></div>
                  </div>

                  <div class="row">
                    <div class="col-lg-3 col-md-4 label">Email</div>
                    <div class="col-lg-9 col-md-8"><?php echo $user_info['email']; ?></div>
                  </div>
                    <hr>
                     <h1>Settings</h1>
                    <form method="post" disabled="">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                        <div class="row mb-3">
                            <label for="fullName" class="col-md-4 col-lg-3 col-form-label">Email Notifications</label>
                            <div class="col-md-8 col-lg-9">
                                <?php
                                if ($otification_result->num_rows > 0) {
                                    while ($row = $otification_result->fetch_assoc()) {
                                        $isChecked = ($row["is_optional"] == 0) ? 'checked' : (in_array($row["id"], $selected_notifications) ? 'checked' : '');
                                        $isDisabled = ($row["is_optional"] == 0) ? 'disabled' : '';

                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox"
                                                   name="notifications[]"
                                                   id="notif_<?php echo $row["id"] ?>"
                                                <?php  echo $isChecked ?>
                                                <?php  echo $isDisabled ?>
                                                   value="<?php echo $row["id"] ?>"
                                                   disabled >
                                            <label class="form-check-label" for="notif_<?php echo $row["id"] ?>">
                                                <?php echo $row["notification_name"] ?>
                                            </label>
                                        </div>
                                        <?php
                                    }
                                } else {
                                    echo "لم يتم العثور على خيارات الإشعارات.";
                                }
                                ?>
                            </div>
                        </div>


                    </form><!-- End settings Form -->
                    <hr>
                    <h1>Roles</h1>
                    <div class="pt-3">

                        <!-- Roles Form -->
                        <form name="user_form_roles" method="post" action="" disabled="disabled">

                            <div class="row mb-3">
                                <label for="fullName" class="col-md-4 col-lg-3 col-form-label">User Roles</label>
                                <input type="hidden" name="user" value="<?php echo $user_id ?>">
                                <div class="col-md-8 col-lg-9">
                                    <?php
                                    foreach ($roles as $role) {
                                        $isChecked = in_array($role['id'], $user_roles) ? 'checked' : '';
                                        ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="roles[]"
                                                <?php echo $isChecked ?> value="<?php echo $role['id']; ?>" disabled>
                                            <label class="form-check-label" for="changesMade">
                                                <?php echo $role['role_name']; ?>
                                            </label>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>


                        </form><!-- End settings Form -->

                    </div>



                </div>





              </div><!-- End Bordered Tabs -->

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

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

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
  <script>
      function triggerFileSelect() {
          document.getElementById('image').click();
      }
  </script>
  <script>
      document.getElementById('deleteImageButton').addEventListener('click', function(e) {
          e.preventDefault(); // منع الإجراء الافتراضي للرابط

          let userConfirm = confirm("Are you sure you want to remove your profile image?");

          if(userConfirm) {
              window.location.href = 'remove_avatar.php'; // التوجيه إلى ملف PHP لحذف الصورة
          }
      });
  </script>

</body>

</html>