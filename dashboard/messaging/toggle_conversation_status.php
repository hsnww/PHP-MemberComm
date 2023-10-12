<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/userHead.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/functions.php'; ?>
<?php
// تحقق من وجود معرف المحادثة في متغيرات POST أو GET
if (isset($_POST['conversation_id']) || isset($_GET['conversation_id'])) {
    $conversation_id = isset($_POST['conversation_id']) ? $_POST['conversation_id'] : $_GET['conversation_id'];

    // تحقق من صلاحيات المستخدم باستخدام دالة `userCanManageConversation`
    if (userCanManageConversation($conn, $_SESSION['user_id'], $conversation_id)) {
        $sql = "SELECT is_closed FROM conversations WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $conversation_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $conversation = $result->fetch_assoc();
            $new_status = $conversation['is_closed'] ? 0 : 1;

            $stmt = $conn->prepare("UPDATE conversations SET is_closed=? WHERE id=?");
            $stmt->bind_param("ii", $new_status, $conversation_id);
            if ($stmt->execute()) {
                // تم التحديث بنجاح
                // يمكنك هنا إعادة التوجيه إلى الصفحة الرئيسية أو إظهار رسالة نجاح
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                $_SESSION['message'] = 'تم تغيير حالة المحادثة بنجاح';
                $_SESSION['bg'] = 'success';
            } else {
                $_SESSION['message'] = "حدث خطأ أثناء التحديث.";
                $_SESSION['bg'] = 'danger';

            }
        } else {
            $_SESSION['message'] =  "لم يتم العثور على المحادثة.";
            $_SESSION['bg'] = 'danger';

        }
    } else {
        $_SESSION['message'] =  "ليس لديك الصلاحية لتنفيذ هذا الإجراء.";
        $_SESSION['bg'] = 'danger';

    }
} else {
    $_SESSION['message'] =  "لم يتم توفير معرف المحادثة.";
    $_SESSION['bg'] = 'danger';

}
?>
