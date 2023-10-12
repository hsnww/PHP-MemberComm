<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "eshopdirectory";
$conn = new mysqli($host, $user, $pass, $db);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// دالة لمعالجة فقدان ملق المستخدم في جدول profiles
function ensureUserProfileExists($conn, $user_id) {
    $stmt = $conn->prepare("SELECT COUNT(*) as count FROM profiles WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    if ($data['count'] == 0) {
        // إنشاء سجل جديد في جدول profiles
        $stmt_insert = $conn->prepare("INSERT INTO profiles (user_id) VALUES (?)");
        $stmt_insert->bind_param("i", $user_id);
        $stmt_insert->execute();
        $stmt_insert->close();
    }

    $stmt->close();
}

// دالة لمعرفة صلاحية المستخدم
function getUserRoles($conn, $user_id) {
    $sql_roles = "SELECT roles.role_name 
                  FROM roles 
                  JOIN role_user ON roles.id = role_user.role_id 
                  WHERE role_user.user_id = ?";

    $stmt_roles = $conn->prepare($sql_roles);
    $stmt_roles->bind_param("i", $user_id);
    $stmt_roles->execute();

    $user_roles = [];
    $result_roles = $stmt_roles->get_result();
    while($row = $result_roles->fetch_assoc()) {
        $user_roles[] = $row['role_name'];
    }
    return $user_roles;
}

function userCanManageConversation($conn, $userId, $conversationId) {
    // الاستعلام للتحقق من هوية مبتدئ المحادثة
    $query1 = "
        SELECT m.sender_id 
        FROM messages m 
        WHERE m.conversation_id = ? 
        ORDER BY m.sent_at ASC 
        LIMIT 1
    ";

    $stmt1 = $conn->prepare($query1);
    $stmt1->bind_param("i", $conversationId);
    $stmt1->execute();
    $result1 = $stmt1->get_result();
    $firstMessage = $result1->fetch_assoc();

    if ($firstMessage['sender_id'] == $userId) {
        return true;
    }

    // الاستعلام للتحقق من الصلاحيات
    $query2 = "
        SELECT r.role_id 
        FROM role_user r 
        WHERE r.user_id = ? AND (r.role_id = 1 OR r.role_id = 2)
    ";

    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $userId);
    $stmt2->execute();
    $result2 = $stmt2->get_result();

    // إذا كان له أحد هذه الصلاحيات، فسيتم إرجاع true
    if ($result2->num_rows > 0) {
        return true;
    }

    // إذا لم يتحقق أي من الشروط، سيتم إرجاع false
    return false;
}


//التحقق من أن المحادثة مفتوحة لعرض نموذج إضافة رسالة:
function isConversationOpen($conn, $conversation_id) {
    $stmt = $conn->prepare("SELECT is_closed FROM conversations WHERE id = ?");
    $stmt->bind_param("i", $conversation_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $conversation = $result->fetch_assoc();

    $stmt->close();

    return ($conversation['is_closed'] == 0);
}

//دالة تتحقق مما إذا كان المستخدم هو من بدأ المحادثة
function didUserStartConversation($conn, $userId, $conversationId) {
    // استعلام للحصول على أول رسالة في المحادثة
    $sql = "SELECT sender_id 
            FROM messages 
            WHERE conversation_id = ? 
            ORDER BY sent_at ASC 
            LIMIT 1";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $conversationId);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $firstMessage = $result->fetch_assoc();
        return $firstMessage['sender_id'] == $userId;
    }

    return false;
}

//إظهار أيقونة (مغلق أو مفتوح حسب حالة المحادثة):
function displayConversationStatusIcon($conn, $conversation_id) {
    if (isConversationOpen($conn, $conversation_id)) {
        echo "<h4 class='text-primary'><i class='ri-lock-unlock-fill'></i></h4>"; // يمكن استبدال 'icon-open' بأيقونتك المُفضلة للحالة المفتوحة
    } else {
        echo "<h4 class='text-danger'><i class='ri-lock-fill'></i></h4>"; // يمكن استبدال 'icon-closed' بأيقونتك المُفضلة للحالة المغلقة
    }
}

//دالة لعدد عضاء المشاركين في المحادثة
function getConversationMembers($conn, $conversationId, $details = false) {
    $query = "
        SELECT 
            conversation_members.user_id AS userId,
            profiles.first_name,
            profiles.last_name,
            profiles.avatar
        FROM conversation_members 
        JOIN profiles ON conversation_members.user_id = profiles.user_id 
        WHERE conversation_members.conversation_id = ?
    ";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $conversationId);

    if ($stmt->execute()) {
        $result = $stmt->get_result();
        if ($details) {
            $members = [];
            while ($row = $result->fetch_assoc()) {
                $members[] = $row;
            }
            return $members;
        } else {
            return $result->num_rows;
        }
    } else {
        return $details ? [] : 0; // يعود فارغًا إذا كان الطلب هو التفاصيل، و0 إذا كان الطلب هو العدد فقط
    }
}
?>