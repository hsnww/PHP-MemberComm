<?php
require_once $_SERVER['DOCUMENT_ROOT'] .'/eshopStores/common/userHead.php';

if(!isset($_POST['searchUser'])) {
    die("Data not provided.");
}

if(!isset($_POST['conversationId'])) {
    die("Conversation ID not provided.");
}

$inputSearch = $_POST['searchUser'];
$conversationId = $_POST['conversationId'];

$query = "SELECT users.id, profiles.first_name, profiles.last_name 
          FROM users 
          JOIN profiles ON users.id = profiles.user_id 
          WHERE (profiles.first_name LIKE ? OR profiles.last_name LIKE ?)
          AND users.id NOT IN (SELECT user_id FROM conversation_members WHERE conversation_id = ?)";

$searchTerm = "%" . $inputSearch . "%";

$stmt = $conn->prepare($query);
$stmt->bind_param("ssi", $searchTerm, $searchTerm, $conversationId);
$stmt->execute();

$result = $stmt->get_result();
$users = $result->fetch_all(MYSQLI_ASSOC);

echo json_encode($users);
?>
