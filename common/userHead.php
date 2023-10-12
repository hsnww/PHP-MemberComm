<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/config.php';

//التحقق من تسجيل الدخول
if(!isset($_SESSION['user_id'])) {
    header("Location: ".$base_url."auth/login.php");
    exit();
}

//التحقق من تفعيل البريد
if($_SESSION['email_verified'] != 1) {
// إذا لم يكن البريد المستخدم مفعل، أعد توجيهه إلى صفحة أخرى
    header("Location: ".$base_url."auth/verify_email.php");
    exit();
}

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
?>
