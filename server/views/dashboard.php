<?php include('header.php'); ?>
<!-- TODO: test if ok in the dashboard -->
            <h1 class="page-header">Bienvenue dans votre Dashboard</h1>
            <!-- <p>Connecté en tant que <?php echo $user['name']; ?></p> -->
            <p>Pièces de votre maison :
                <ul>
                    <?php
                    $stmt = $db->prepare("SELECT * FROM rooms WHERE client_id=:client_id");
                    $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
                    $stmt->execute();
                    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($rooms as $room) {
                        echo '<li><a href="/?page=room&room_id='.$room['id'].'">'.$room['name'].'</li>';
                    }
                    ?>
                </ul>
            </p>
    <?php include('footer.php'); ?>