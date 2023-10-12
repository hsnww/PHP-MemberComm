<?php session_start();
//التحقق من تسجيل الدخول
include $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/config.php';

if(!isset($_SESSION['user_id'])) {
    header("Location: ".$base_url."auth/login.php");
    exit();
}

if($_SESSION['email_verified'] !=1) {
    header("Location: ../auth/verify_email.php");
    exit();
}

// استبدل 'Admin' بالصلاحية التي تريد التحقق منها
$requiredRole = '1';
if (in_array($requiredRole, $_SESSION['user_roles'])) {
?>

<?php
$userId = $_SESSION['user_id'];

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
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$userData = $result->fetch_assoc();
}else{
// إذا لم يكن للمستخدم الصلاحية الكافية، أعد توجيهه إلى صفحة أخرى
    header("Location: " . $base_url ."dashboard");
    exit();
}
?>
