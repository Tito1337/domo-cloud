<?php include('header.php');
if(IsSet($_GET['room_id'])) {
    $stmt = $db->prepare("SELECT * FROM rooms WHERE id=:id");
    $stmt->bindValue(':id', $_GET['room_id'], PDO::PARAM_INT);
    $stmt->execute();
    if($stmt->rowCount() == 1) {
        $room = $stmt->fetch(PDO::FETCH_ASSOC);
        echo '<h2>'.$room['name'].'</h2>';
    } else {
        echo 'ERREUR : La pièce avec l\'ID '.$_GET['room_id'].' n\'existe pas!';
    }
} else {
    echo 'ERREUR : Pas d\'ID transmis dans l\'URL';
}
?>
<?php include('footer.php'); ?>