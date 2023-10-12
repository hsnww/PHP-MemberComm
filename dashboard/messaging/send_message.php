<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/eshopStores/common/userHead.php'; ?>
<?php
$user_id = $_SESSION['user_id'];
$recipients_array = $_POST['recipient_id_string'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // تحقق من وجود محادثة
    if (isset($_POST['conversation_id']) && $_POST['conversation_id'] != '') {
        $conversation_id = $_POST['conversation_id'];
    } else {
        // تحديد نوع المحادثة
        $is_group = count($recipients_array) > 1;
        $subject = $_POST['subject']; // يجب فحص وتنظيف البيانات
        $stmt = $conn->prepare("INSERT INTO conversations (subject, is_group) VALUES (?,?)");
        $stmt->bind_param("si", $subject, $is_group);
        $stmt->execute();

        $conversation_id = $conn->insert_id;
        // إضافة الأعضاء المشاركين
        $users_stmt = $conn->prepare("INSERT INTO conversation_members (conversation_id, user_id) VALUES (?, ?)");

        foreach ($recipients_array as $recipient_id) {
            $users_stmt->bind_param("ii", $conversation_id, $recipient_id);
            $users_stmt->execute();
        }
        // إضافة المرسل
        $sender_stmt = $conn->prepare("INSERT INTO conversation_members (conversation_id, user_id) VALUES (?, ?)");
        $sender_stmt->bind_param("ii", $conversation_id, $user_id);
        $sender_stmt->execute();
        // بعد الشيفرة التي تقوم بإنشاء أو استخدام المحادثة الموجودة...
        // خزن الرسالة في جدول messages
        $message_content = $_POST['message']; // يجب فحص وتنظيف البيانات
        $msg_stmt = $conn->prepare("INSERT INTO messages (sender_id,  conversation_id, content) VALUES (?, ?, ?)");
        $msg_stmt->bind_param("iis", $user_id, $conversation_id, $message_content);

        if ($msg_stmt->execute()) {
            $last_id = $msg_stmt->insert_id; // هذا سيعطيك المعرف الأخير الذي تم إضافته
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
                    $stmt_attachment = $conn->prepare("INSERT INTO attachments (message_id, file_path, file_type, file_size, uploaded_at) VALUES (?, ?, ?, ?, ?)");
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
            header('Location: message.php?id=' . $last_id);
            exit;
        } else {
            echo "Error: " . $stmt->error;
        }
        // يمكنك هنا إعادة التوجيه أو عرض رسالة نجاح للمستخدم.
        $_SESSION['message'] = "The message has been sent successfully!";
        header('Location: message.php?id=' . $last_id);
        exit;
    }
}
?>