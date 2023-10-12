<?php
session_start();

if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: dashboard"); // إعادة توجيه المستخدم إلى الصفحة التي تريده
    exit();
}
include $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/config.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // جلب بيانات المستخدم باستخدام البريد الإلكتروني
    $stmt = $conn->prepare("SELECT users.id, users.email, users.password,   users.email_verified, profiles.first_name, profiles.last_name   
 FROM users 
                             JOIN profiles ON users.id = profiles.user_id 
                             WHERE users.email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // التحقق من صحة كلمة المرور
    if ($user && password_verify($password, $user['password'])) {
        // تخزين بيانات المستخدم في المتغيرات الخاصة بالجلسة
        $_SESSION['loggedin'] = true;
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['email_verified'] = $user['email_verified'];
        $_SESSION['userName'] = $user['first_name'] . ' ' . $user['last_name'];

        $user_id = $user['id'];
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
        $_SESSION['user_roles'] = $user_roles;
        // توجيه المستخدم إلى الصفحة الرئيسية
        header("Location: " . $base_url . "dashboard");

        exit;
    } else {
        $_SESSION['message']  = "خطأ في البريد الإلكتروني أو كلمة المرور!";
        $_SESSION['bg']  = "danger";
    }


    $stmt->close();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Login - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="<?php echo $base_url ?>dashboard/assets/img/favicon.png" rel="icon">
  <link href="../../dashboard/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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
</head>
<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="../../dashboard/pages-index.html" class="logo d-flex align-items-center w-auto">
                  <img src="../../dashboard/assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Login to Your Account</h5>
                    <p class="text-center small">Enter your username & password to login</p>
                  </div>
                    <?php if(isset($_SESSION['message'])) { ?>
                        <div class="alert alert-<?php echo $_SESSION['bg']; ?> alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            <?php echo $_SESSION['message'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['message']) ?>
                        <?php unset($_SESSION['bg']) ?>
                    <?php } ?>

                    <?php if(isset($_SESSION['alertMessage'])) { ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-1"></i>
                            <?php echo $_SESSION['alertMessage'] ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php unset($_SESSION['alertMessage']) ?>
                    <?php } ?>
                    <?php
                    if (isset($_SESSION['alertMessage'])) {
                        echo "<div class='alert alert-success'>" . $_SESSION['alertMessage'] . "</div>";
                        unset($_SESSION['alertMessage']);
                    }
                    unset($_SESSION['alertMessage']);
                    ?>
                  <form class="row g-3 needs-validation" novalidate method="post">

                    <div class="col-12">
                      <label for="yourUsername" class="form-label">Email</label>
                      <div class="input-group has-validation">
                        <span class="input-group-text" id="inputGroupPrepend">@</span>
                        <input type="email" name="email" class="form-control" id="yourUsername" required>
                        <div class="invalid-feedback">Please enter your username.</div>
                      </div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="remember" value="true" id="rememberMe">
                        <label class="form-check-label" for="rememberMe">Remember me</label>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Login</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Don't have account? <a href="register.php">Create an account</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="<?php echo $base_url ?>dashboard/assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="<?php echo $base_url ?>dashboard/assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="<?php echo $base_url ?>dashboard/assets/vendor/chart.js/chart.umd.js"></script>
  <script src="<?php echo $base_url ?>dashboard/assets/vendor/echarts/echarts.min.js"></script>
  <script src="<?php echo $base_url ?>dashboard/assets/vendor/quill/quill.min.js"></script>
  <script src="<?php echo $base_url ?>dashboard/assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="<?php echo $base_url ?>dashboard/assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="<?php echo $base_url ?>dashboard/assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="<?php echo $base_url ?>dashboard/assets/js/main.js"></script>

</body>

</html>