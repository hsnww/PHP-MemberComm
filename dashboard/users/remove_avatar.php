<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/userHead.php'; ?>

<?php
$user = $_GET['id'];

// استعلام لاحضار مسار الصورة
$query = "SELECT avatar FROM profiles WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $user);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();


if ($row && $row['avatar']) {
    $imagePath =  $_SERVER['DOCUMENT_ROOT'].'/eshopStores/src/avatars/'.$row['avatar'];
    if (file_exists($imagePath)) {
        unlink($imagePath); // حذف الصورة من المجلد
    }

    // حذف مسار الصورة من قاعدة البيانات
    $updateQuery = "UPDATE profiles SET avatar = NULL WHERE user_id = ?";
    $updateStmt = $conn->prepare($updateQuery);
    $updateStmt->bind_param('i', $user);
    $updateStmt->execute();
}

header('Location: edit.php?id='.$user); // إعادة التوجيه إلى الصفحة الرئيسية بعد الحذف
?>
