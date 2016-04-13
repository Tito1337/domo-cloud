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
    global $user, $db;
    if(!$client_id) $client_id = $user['id'];

    // Derogative orders
    $stmt = $db->prepare("SELECT * FROM derogative_orders WHERE client_id=:client_id AND room_id=:room_id AND start<=NOW() AND stop>NOW()");
    $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':room_id', $_GET['room_id'], PDO::PARAM_INT);
    $stmt->execute();
    if($stmt->rowCount() == 1) {
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        return $order['temperature'];
    } else if($stmt->rowCount() > 1) {
        die("FATAL ERROR : More than one derogative_orders at this time");
    }

    // Weekly orders
    $stmt = $db->prepare("SELECT * FROM weekly_orders WHERE client_id=:client_id AND room_id=:room_id AND day=WEEKDAY(NOW())+1 AND start<=NOW() AND stop>NOW()");
    $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':room_id', $_GET['room_id'], PDO::PARAM_INT);
    $stmt->execute();
    if($stmt->rowCount() == 1) {
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        return $order['temperature'];
    } else if($stmt->rowCount() > 1) {
        die("FATAL ERROR : More than one weekly_order at this time");
    }

    // Default order
    return get_default_order($room_id, $client_id);
}

function get_default_order($room_id, $client_id=false) {
    global $user, $db;
    if(!$client_id) $client_id = $user['id'];

    // Default orders
    $stmt = $db->prepare("SELECT * FROM default_orders WHERE client_id=:client_id AND room_id=:room_id");
    $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
    $stmt->bindValue(':room_id', $_GET['room_id'], PDO::PARAM_INT);
    $stmt->execute();
    if($stmt->rowCount() == 1) {
        $order = $stmt->fetch(PDO::FETCH_ASSOC);
        return $order['temperature'];
    } else if($stmt->rowCount() > 1) {
        die("FATAL ERROR : More than one default_order at this time");
    }

    // Default default
    return 18;
}
?>