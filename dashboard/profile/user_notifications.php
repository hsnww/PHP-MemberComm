<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/userHead.php'; ?>
<?php
if(isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    // الكود الذي يتبع هنا...
} else {
    die("User ID is missing!");
}

    // التحقق من رمز CSRF
if(isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {


    // حذف الإشعارات الحالية للمستخدم
    $deleteQuery = "DELETE FROM user_notifications WHERE user_id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // إذا قام المستخدم بتحديد أي إشعارات...
    if (isset($_POST['notifications']) && is_array($_POST['notifications'])) {
        $insertQuery = "INSERT INTO user_notifications (user_id, notification_id) VALUES (?, ?)";
        $stmt = $conn->prepare($insertQuery);
        $stmt->bind_param("ii", $user_id, $notification_id);

        foreach ($_POST['notifications'] as $notification_id) {
            $stmt->execute();
        }
        $_SESSION['message'] = "تم تحديث الخيارات بنجاح.";
        $_SESSION['bg'] = "success";
    }

    // إعادة توجيه المستخدم أو عرض رسالة تأكيدية
    header('Location: inbox.php');
    exit();
}
?>