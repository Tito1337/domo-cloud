<?php
header('Content-Type: application/json');
include('functions.php');

$stmt = $db->prepare("SELECT * FROM clients WHERE id=:id");
$stmt->bindValue(':id', $_GET['client_id'], PDO::PARAM_INT);
$stmt->execute();
if($stmt->rowCount() == 1) {
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
}

echo "{\n";
$stmt = $db->prepare("SELECT * FROM rooms WHERE client_id=:client_id");
$stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
$stmt->execute();
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach($rooms as $room) {
    echo '"'.$room['id'].'": '.get_current_order($room['id']).",\n";
}
echo "}\n";
?>