<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/userHead.php'; ?>
<?php include $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/functions.php'; ?>
<?php
// Print form output
//if($_SERVER["REQUEST_METHOD"] == "POST") {
//    echo "<pre>";
//    print_r($_POST);
//    echo "</pre>";
//    exit();
//}
$conversation_id = $_POST['conversation_id'];

$message = $_POST['message'];
$user_id = $_SESSION['user_id'];

// استخدام prepared statement لإضافة الرسالة إلى جدول messages
$stmt = $conn->prepare("INSERT INTO messages (sender_id , conversation_id , content) VALUES (?,?,?)");
$stmt->bind_param("iis", $user_id, $conversation_id, $message);

// تحقق من وجود قيمة close_it في البيانات المُرسلة
if (isset($_POST['close_it']) && $_POST['close_it'] == "true") {
    // التحقق من صلاحيات المستخدم
    $user_roles = getUserRoles($conn, $user_id);
    $allowed_roles = [1, 2];

    // جلب المستخدم الذي بدأ المحادثة
    $query = "SELECT sender_id FROM messages WHERE conversation_id = ? ORDER BY sent_at ASC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $conversation_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $first_message = $result->fetch_assoc();
    $conversation_starter = $first_message['sender_id'];

    // إذا كان لدى المستخدم الحالي الصلاحية، قم بتحديث حالة المحادثة
    if ($user_id == $conversation_starter || getUserRoles($conn, $user_id)) {
        $query = "UPDATE conversations SET is_closed = 1 WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $conversation_id);
        $stmt->execute();
        // هنا يمكنك إضافة رسالة تأكيد أو إعادة التوجيه إلى صفحة أخرى
    }
}

if ($stmt->execute()) {
    $last_id = $stmt->insert_id; // هذا سيعطيك المعرف الأخير الذي تم إضافته

    // إذا تم تحميل مرفق
    if (isset($_FILES['attachment']) && $_FILES['attachment']['size'] > 0) {
        $file_name = $_FILES['attachment']['name'];
        $file_size = $_FILES['attachment']['size'];

        $file_extension = pathinfo($file_name, PATHINFO_EXTENSION);

        $allowed_extensions = array("doc", "docx", "pdf", "xlsx", "xls", "txt", "zip", "rar");
        $max_file_size = 2 * 1024 * 1024; // 2 ميقابايت

        if (in_array($file_extension, $allowed_extensions) && $file_size <= $max_file_size) {


            // إنشاء اسم فريد للملف
            $unique_filename = uniqid() . "." . $file_extension;


            $location = $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/src/attachments/' . $unique_filename;
            $file_type = $_FILES['attachment']['type'];
            $uploaded_at = date("Y-m-d H:i:s");

            // نقل الملف إلى المجلد المرغوب
            move_uploaded_file($_FILES['attachment']['tmp_name'], $location);

            // استخدام prepared statement لإضافة المعلومات إلى جدول attachments
            $stmt_attachment = $conn->prepare("INSERT INTO attachments (message_id, file_path, file_type,file_size, uploaded_at) VALUES (?, ?, ?, ?, ?)");
            $stmt_attachment->bind_param("issss", $last_id, $unique_filename, $file_type, $file_size, $uploaded_at);
            $stmt_attachment->execute();
            $stmt_attachment->close();

        } else {
        if (!in_array($file_extension, $allowed_extensions)) {
            $_SESSION['error_file_message'] = "الصيغة غير مسموح بها. يرجى تحميل ملف بصيغة doc, docx, pdf, xlsx, xls, أو txt.";
        }
        if ($file_size > $max_file_size) {
            $_SESSION['error_file_message'] = "حجم الملف كبير جدًا. يرجى تحميل ملف بحجم أقل من 2 ميقابايت.";
        }
    }
    }

    $_SESSION['message'] = "The message has been sent successfully!";
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
