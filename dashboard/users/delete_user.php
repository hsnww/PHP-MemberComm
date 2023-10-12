<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/adminHead.php'; ?>
<?php

$user_id = $_GET['id'];

        // البداية بحذف السجل من جدول profiles
        $stmt = $conn->prepare("DELETE FROM profiles WHERE user_id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        // بعد الانتهاء من حذف السجل في جدول profiles، يمكنك الآن حذف السجل من جدول users
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $_SESSION['message'] = "تم حذف المستخدم بنجاح!";
            $stmt->close();
            header('Location: inbox.php');
            exit();
        }

?>
