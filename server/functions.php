<?php
// Initialize MySQL connection
$db = new PDO('mysql:host=localhost;dbname=domo-cloud;charset=utf8mb4', 'domocloud', '');

// Check user status
$user = false;
if(IsSet($_COOKIE['client_id']) && IsSet($_COOKIE['password_hash'])) {
    $stmt = $db->prepare("SELECT * FROM clients WHERE id=:id");
    $stmt->bindValue(':id', $_COOKIE['client_id'], PDO::PARAM_INT);
    $stmt->execute();
    if($stmt->rowCount() == 1) {
        $client = $stmt->fetch(PDO::FETCH_ASSOC);
        if(sha1($client['password']) == $_COOKIE['password_hash']) {
            $user = $client;
        }
    }
}

function get_current_order($room_id, $client_id=false) {
    global $user;
    if(!$client_id) $client_id = $user['id'];
    
    return 42;
}
?>