<?php $dashboard=true; include('header.php'); ?>
<!-- TODO: test if ok in the dashboard -->
            <h2 class="page-header">Bienvenue dans votre Dashboard</h1>
            <!-- <p>Connecté en tant que <?php echo $user['name']; ?></p> -->

            <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Liste des pièces</div>
                <div class="panel-body">
                    <p>Récapitulatif de l'ensemble des pièces de votre maison.</p>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Pièce</th>
                            <th>Température actuelle</th>
                            <th>Consigne</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php
                            $stmt = $db->prepare("SELECT * FROM rooms WHERE client_id=:client_id");
                            $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
                            $stmt->execute();
                            $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            foreach($rooms as $room) {
                                // echo '<a href="/?page=room&room_id='.$room['id'].'">'.$room['name'].'</a>';
                                echo '<tr><td>'.$room['name'].'</td><td><i class="fa fa-cog fa-spin"></i> °C</td><td>'.get_current_order($room['id']).'</td><td><a class="btn btn-default" href="/?page=room&room_id='.$room['id'].'">Programmer</a></tr>';
                            }
                            ?>
                    </tbody>
                </table>
            </div>


            <!-- <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">BOUMMM</h3>
                </div>
                <div class="panel-body row">
                    <table>
                        <tr>
                            <th class="col-md-3">Pièce</th>
                            <th class="col-md-3">Température actuelle</th>
                            <th class="col-md-3">Consigne</th>
                        </tr>

                        <tr>
                            <th class="col-md-3">Pièce</th>
                            <th class="col-md-3">Température actuelle</th>
                            <th class="col-md-3">Consigne</th>
                        </tr>
                    </table>
                </div>
            </div> -->

    <?php include('footer.php'); ?>