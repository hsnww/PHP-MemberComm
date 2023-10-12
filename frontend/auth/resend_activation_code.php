<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/eshopStores/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['email'])) {
    $email = $_POST['email'];

    // البحث عن المستخدم بناءً على البريد الإلكتروني
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ? AND email_verified = 0");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        // إعادة إرسال كود التفعيل
        $activation_code = $user['verification_code'];

        require $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/mailer.php';
        $to = 'hsnwww@gmail.com';
        $subject = 'Your verification code';
        $body = '<h3>Hi</h3>Use this code to verify your email address: <p><b>'.$activation_code.'</b></p><p>Best regards</p>';
        $altBody = 'Use '.$activation_code.' to verify your email address';

        $success = sendEmail($to, $subject, $body, $altBody);

        if ($success) {
            $_SESSION['message'] =  "Email sent successfully!";
            $_SESSION['bg'] =  "success";

        } else {
            $_SESSION['message'] =  "There was an error sending the email.";
            $_SESSION['bg'] =  "danger";

        }
        header("Location: verify_email.php");



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
  <link href="<?php echo $base_url ?>dashboard/assets/img/apple-touch-icon.png" rel="apple-touch-icon">

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
            <div class="col-lg-8 col-md-8 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="<?php echo $base_url ?>dashboard/pages-index.html" class="logo d-flex align-items-center w-auto">
                  <img src="<?php echo $base_url ?>dashboard/assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Verification Email address</h5>
                    <p class="text-center small">Enter your verification code to activate your account</p>
                  </div>

                  <form class="row g-3 needs-validation" action="resend_activation_code.php" method="post">

                    <div class="col-12">
                        <p class="bg-warning text-center"></p>
                      <label for="yourUsername" class="form-label">Enter verification code</label>
                      <div class="input-group has-validation">
<!--                        <span class="input-group-text" id="inputGroupPrepend">@</span>-->
                        <input type="email" name="email" class="form-control" id="email" value="<?php echo $_SESSION['email']; ?>" required>
                        <div class="invalid-feedback">Please enter your verification code.</div>
                      </div>
                    </div>


                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Activate</button>
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