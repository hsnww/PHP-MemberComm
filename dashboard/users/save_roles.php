<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/adminHead.php'; ?>
<?php

$selected_user_id = $_POST['user'];  // تحديد المعرّف المستخدم، يمكنك الحصول عليه من الجلسة أو من المدخلات المخفية في النموذج

// حذف الأدوار الحالية للمستخدم
$sql_delete = "DELETE FROM role_user WHERE user_id = ?";
$stmt_delete = $conn->prepare($sql_delete);
$stmt_delete->bind_param("i", $selected_user_id);
$stmt_delete->execute();

// إضافة الأدوار المحددة للمستخدم
if (isset($_POST['roles'])) {
    $sql_insert = "INSERT INTO role_user (user_id, role_id) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    foreach ($_POST['roles'] as $role_id) {
        $stmt_insert->bind_param("ii", $selected_user_id, $role_id);
        $stmt_insert->execute();
    }
}
$_SESSION['message'] = "تم تعديل صلاحيات المستخدم بنجاح.";

header('Location: edit.php?id='.$selected_user_id);
$_SESSION['bg'] = "success";
exit();
