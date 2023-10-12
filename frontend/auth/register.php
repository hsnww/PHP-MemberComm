<?php
session_start();
if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    header("Location: dashboard"); // إعادة توجيه المستخدم إلى الصفحة التي تريده
    exit();
}
include $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/config.php';
require $_SERVER['DOCUMENT_ROOT'].'/eshopStores/vendor/autoload.php';

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];

    // Check if email is unique
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message = "Email already exists!";
        $stmt->close();
    } else {
        $firstname = $_POST['first_name'];
        $lastname = $_POST['last_name'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $password = $_POST['password'];
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // توليد كود التحقق
        $verification_code = bin2hex(openssl_random_pseudo_bytes(20));

        // إدخال البيانات في جدول الأعضاء
        $stmt = $conn->prepare("INSERT INTO users (email, password, verification_code) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $hashed_password, $verification_code);

        if ($stmt->execute()) {
            // الحصول على الID التي تم إنشاؤها تلقائياً
            $user_id = $stmt->insert_id;

            // إضافة البيانات إلى جدول profile
            $stmt_profile = $conn->prepare("INSERT INTO profiles (user_id, first_name, last_name, phone) VALUES (?, ?, ?, ?)");
            $stmt_profile->bind_param("isss", $user_id, $firstname, $lastname, $phone);
            $stmt_profile->execute();

// إرسال الرمز إلى البريد الإلكتروني (ستحتاج إلى مكتبة أو وظيفة لإرسال البريد)
            require $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/mailer.php';
            $subject = 'Your verification code';
            $body = '<h3>Hi</h3>
                    <p>welcome to '.$base_url.'</p>
                    <p>you are one of our happy members now</p>
                    <p>Email : '.$email.' </p> 
                    <p>Password : '.$password.' </p>
                    <p>Use this code to verify your email address: </p>  
                    <p><b>'.$verification_code.'</b></p>
                    <p>Best regards</p>';
            $altBody = 'Use '.$verification_code.' to verify your email address';

            $success = sendEmail($email, $subject, $body, $altBody);

            if ($success) {
                $_SESSION['message'] =  "Registered successfully, we send you Email with verification code, please use it to confirm!";
                $_SESSION['bg'] =  "success";

            } else {
                $_SESSION['message'] =  "There was an error sending the email.";
                $_SESSION['bg'] =  "danger";

            }
            header("Location: login.php");

            exit();
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Register - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../../dashboard/assets/img/favicon.png" rel="icon">
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
    <script>
        function validateForm() {
            var name = document.getElementById("name").value;
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm-password").value;
            var terms = document.getElementById("terms").checked;

            if (!name || !email || !password || !confirmPassword) {
                alert("All fields are required.");
                return false;
            }

            if (password.length < 8) {
                alert("Password should be at least 8 characters.");
                return false;
            }

            if (password !== confirmPassword) {
                alert("Passwords do not match.");
                return false;
            }

            if (!terms) {
                alert("Please agree to the terms.");
                return false;
            }

            return true;
        }

    </script>

</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="../../dashboard/pages-index.html" class="logo d-flex align-items-center w-auto">
                  <img src="../../dashboard/assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">NiceAdmin</span>
                </a>
              </div>
                <!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter your personal details to create account</p>
                  </div>
                    <p class="text-danger"><?php echo $message; ?></p>
                  <form class="row g-3 needs-validation" novalidate method="post" >
                      <div class="row">
                          <div class="col-lg-6 col-md-12">
                              <label for="yourName" class="form-label">First Name</label>
                              <input type="text" name="first_name"  id="first_name" class="form-control" placeholder="Enter your First Name" required>
                              <div class="invalid-feedback">Please, enter your First Name!</div>
                          </div>
                          <div class="col-lg-6 col-md-12">
                              <label for="yourName" class="form-label">Last Name</label>
                              <input type="text" name="last_name"  id="last_name" class="form-control" placeholder="Enter your Last Name" required>
                              <div class="invalid-feedback">Please, enter your Last Name!</div>
                          </div>
                      </div>


                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="email" class="form-control" id="email" placeholder="Enter email address" required>
                      <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                    </div>
                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Mobile number</label>
                      <input type="text" name="phone" class="form-control" id="phone" placeholder="966511111111" required>
                      <div class="invalid-feedback">Please enter your mobile number!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>
                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Confirm Password</label>
                      <input type="password" name="confirm-password" class="form-control" id="confirm-password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="login.php">Log in</a></p>
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




