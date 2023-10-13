<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/adminHead.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/functions.php';

if (!isset($_GET['id'])) {
    die("No conversation ID provided.");
}

$conversationId = $_GET['id'];

// تأكد من أن المستخدم هو المسؤول (Administrator)
$userRoles = getUserRoles($conn, $_SESSION['user_id']);
if (!in_array(1, $userRoles)) {
    die("You do not have the permission to delete this conversation.");
}

// جلب قائمة المرفقات المرتبطة برسائل المحادثة
$query_attachments = "SELECT file_path FROM attachments JOIN messages ON messages.id = attachments.message_id WHERE messages.conversation_id = ?";
$stmt_attachments = $conn->prepare($query_attachments);
$stmt_attachments->bind_param("i", $conversationId);
$stmt_attachments->execute();
$attachments = $stmt_attachments->get_result()->fetch_all(MYSQLI_ASSOC);

// حذف الملفات المرفقة الفعلية من مجلد المرفقات
foreach ($attachments as $attachment) {
    $file_path = $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/src/attachments/' . $attachment['file_path'];
    if (file_exists($file_path)) {
        unlink($file_path);
    }
}

// حذف المرفقات من جدول attachments
$query_delete_attachments = "DELETE attachments FROM attachments JOIN messages ON messages.id = attachments.message_id WHERE messages.conversation_id = ?";
$stmt_delete_attachments = $conn->prepare($query_delete_attachments);
$stmt_delete_attachments->bind_param("i", $conversationId);
$stmt_delete_attachments->execute();

// حذف الرسائل من جدول messages
$query_delete_messages = "DELETE FROM messages WHERE conversation_id = ?";
$stmt_delete_messages = $conn->prepare($query_delete_messages);
$stmt_delete_messages->bind_param("i", $conversationId);
$stmt_delete_messages->execute();

// حذف العلاقات من جدول conversation_members
$query_delete_members = "DELETE FROM conversation_members WHERE conversation_id = ?";
$stmt_delete_members = $conn->prepare($query_delete_members);
$stmt_delete_members->bind_param("i", $conversationId);
$stmt_delete_members->execute();

// حذف المحادثة من جدول conversations
$query_delete_conversation = "DELETE FROM conversations WHERE id = ?";
$stmt_delete_conversation = $conn->prepare($query_delete_conversation);
$stmt_delete_conversation->bind_param("i", $conversationId);
$stmt_delete_conversation->execute();


$_SESSION['message'] = "Conversation and related data deleted successfully.";
$_SESSION['bg'] = "success";
header('Location: index.php');

//echo "Conversation and related data deleted successfully.";
?>