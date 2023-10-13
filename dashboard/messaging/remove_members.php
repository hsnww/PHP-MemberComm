<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/userHead.php'; ?>
<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/functions.php'; ?>

<?php
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $_SESSION['message'] ="User not logged in.";
    $_SESSION['bg'] = "danger";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

// تأكيد أن المستخدم قام بتحديد أعضاء للحذف
if (!isset($_POST['users']) || count($_POST['users']) == 0) {
    $_SESSION['message'] ="No users selected.";
    $_SESSION['bg'] = "danger";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

}

if (!isset($_POST['conversationId']) || empty($_POST['conversationId'])) {

    $_SESSION['message'] ="No conversation ID provided.";
    $_SESSION['bg'] = "danger";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

}
$conversationId = $_POST['conversationId'];
$usersToDelete = $_POST['users'];

// جلب معرف مرسل أول رسالة في المحادثة
$query_starter = "SELECT sender_id FROM messages WHERE conversation_id = ? ORDER BY sent_at ASC LIMIT 1";
$stmt_starter = $conn->prepare($query_starter);
$stmt_starter->bind_param("i", $conversationId);
$stmt_starter->execute();
$result_starter = $stmt_starter->get_result();
$first_message = $result_starter->fetch_assoc();
$conversation_starter = $first_message['sender_id'];

// التحقق من أن المستخدم ليس هو مرسل أول رسالة
if (in_array($conversation_starter, $usersToDelete)) {
    $_SESSION['message'] ="Cannot delete the conversation starter.";
    $_SESSION['bg'] = "danger";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();

}



// التحقق من أن المستخدم يمكنه إدارة المحادثة
if (!userCanManageConversation($conn, $user_id, $conversationId)) {
    $_SESSION['message'] ="You do not have permission to manage this conversation.";
    $_SESSION['bg'] = "danger";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

// التحقق من أن لا يتم حذف جميع الأعضاء
$query_membersCount = "SELECT COUNT(*) as totalMembers FROM conversation_members WHERE conversation_id = ?";
$stmt_membersCount = $conn->prepare($query_membersCount);
$stmt_membersCount->bind_param("i", $conversationId);
$stmt_membersCount->execute();
$result_membersCount = $stmt_membersCount->get_result();
$totalMembers = $result_membersCount->fetch_assoc()['totalMembers'];

if (count($usersToDelete) >= $totalMembers) {
    $_SESSION['message'] = "Cannot delete all members. At least one member (excluding the conversation starter) should remain.";
    $_SESSION['bg'] = "danger";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

// حذف الأعضاء المحددين
$placeholders = implode(',', array_fill(0, count($usersToDelete), '?'));
$query_delete = "DELETE FROM conversation_members WHERE conversation_id = ? AND user_id IN ($placeholders)";
$stmt_delete = $conn->prepare($query_delete);
$types = str_repeat("i", count($usersToDelete) + 1);
$values = array_merge([$conversationId], $usersToDelete);
$stmt_delete->bind_param($types, ...$values);

if ($stmt_delete->execute()) {
    $_SESSION['message'] = "Members deleted successfully.";
    $_SESSION['bg'] = "success";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
} else {
    $_SESSION['message'] = "Error deleting members";
    $_SESSION['bg'] = "danger";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}

?>
