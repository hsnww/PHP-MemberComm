<?php
// الربط مع قاعدة البيانات وملفات التكوين الأساسية
require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/userHead.php';

if(!isset($_POST['conversationId']) || !isset($_POST['selectedUsers'])) {
    die("Data not provided.");
}

$conversationId = $_POST['conversationId'];
$selectedUsers = $_POST['selectedUsers'];  // هذه ستكون قائمة من معرفات الأعضاء المحددين

foreach($selectedUsers as $userId) {
    // هنا، يمكنك إضافة العضو إلى المحادثة. على سبيل المثال:
    $query = "INSERT INTO conversation_members (conversation_id, user_id) VALUES (?, ?)";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $conversationId, $userId);

    if(!$stmt->execute()) {
        die("Error adding user: " . $stmt->error);
    }
}

// تحويل المستخدم بعد الإضافة بنجاح
$_SESSION['message'] = "The members has been added successfully!";
header('Location: ' . $_SERVER['HTTP_REFERER']);
?>
