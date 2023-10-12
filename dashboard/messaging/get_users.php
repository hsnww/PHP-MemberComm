<?php require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/userHead.php'; ?>
<?php //require_once $_SERVER['DOCUMENT_ROOT'].'/eshopStores/common/functions.php'; ?>
<?php
var_dump($_GET);
//if(isset($_GET['role_id']) && is_array($_GET['role_id'])) {
if(isset($_GET['role_id']) && in_array('all', $_GET['role_id'])) {
    // جلب جميع الأعضاء
    $query = "SELECT users.id, profiles.first_name, profiles.last_name FROM users JOIN profiles ON users.id = profiles.user_id";
    $result = $conn->query($query);
    while($user = $result->fetch_assoc()) {
        echo "<option value='" . $user["id"] . "'>" . $user["first_name"] . " " . $user["last_name"] . "</option>";
    }
} else {
    $role_ids = $_GET['role_id'];
    $placeholders = implode(',', array_fill(0, count($role_ids), '?'));


    $stmt = $conn->prepare("
        SELECT users.id, profiles.first_name, profiles.last_name 
        FROM users 
        JOIN role_user ON users.id = role_user.user_id 
        JOIN profiles ON users.id = profiles.user_id 
        WHERE role_user.role_id IN ($placeholders)
    ");

    $stmt->bind_param(str_repeat("i", count($role_ids)), ...$role_ids);
    $stmt->execute();
    $result = $stmt->get_result();
    if (!$result) {
        die("Error in query: " . mysqli_error($conn));
    }
    while($user = $result->fetch_assoc()) {
        echo "<option value='" . $user["id"] . "'>" . $user["first_name"] . " " . $user["last_name"] . "</option>";
    }

    $stmt->close();
}
?>



