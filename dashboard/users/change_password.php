<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/userHead.php';
if(isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {

$newPassword = $_POST['new-password'];
$confirmPassword = $_POST['confirm-new-password'];

// التحقق من تطابق كلمة المرور الجديدة وتأكيدها
//if($newPassword !== $confirmPassword) {
//    $_SESSION['message'] ="عفواً لم نتمكن من تغيير كلمة المرور لك .. كلمة المرور الجديدة وتأكيدها غير متطابقتين." ;
//    $_SESSION['bg'] = "danger";
//    header('Location: inbox.php');
//    exit();
//}

$userId = $_POST['user']; // قم بتحديث هذا بناءً على كيفية حفظ معرف المستخدم

// استعلام للحصول على كلمة المرور الحالية من قاعدة البيانات
$stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// التحقق من تطابق كلمة المرور الحالية
    if($newPassword == $confirmPassword) {
// تحديث كلمة المرور
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->bind_param('si', $hashedPassword, $userId);
    if ($stmt->execute()) {
        $_SESSION['message'] = "تم تحديث كلمة المرور بنجاح.";
        $_SESSION['bg'] = "success";
    } else {
        $_SESSION['message'] = "عفواً لم نتمكن من تغيير كلمة المرور لك ..حدث خطأ أثناء تحديث كلمة المرور.";
        $_SESSION['bg'] = "danger";
    }
} else {
    $_SESSION['message'] = "عفواً لم نتمكن من تغيير كلمة المرور لك ..كلمة المرور الحالية غير صحيحة.";
    $_SESSION['bg'] = "warning";
}

        header('Location: inbox.php');
        exit();

} else {
    die("رمز CSRF غير صالح.");
}

?>