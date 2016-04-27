<?php include('header.php'); ?>
<!-- TODO: test if ok in the dashboard -->
            <h1 class="page-header">Bienvenue dans votre Dashboard</h1>
            <p>Connecté en tant que <?php echo $user['name']; ?></p>
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
            <!-- <div class="row placeholders">
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else1</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
                <div class="col-xs-6 col-sm-3 placeholder">
                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAHd3dwAAACH5BAAAAAAALAAAAAABAAEAAAICRAEAOw==" width="200" height="200" class="img-responsive" alt="Generic placeholder thumbnail">
                    <h4>Label</h4>
                    <span class="text-muted">Something else</span>
                </div>
            </div> -->

        <!-- <h2 class="sub-header">Section title</h2> -->
            <!-- <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Header1</th>
                            <th>Header2</th>
                            <th>Header3</th>
                            <th>Header4</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1,001</td>
                            <td>Lorem</td>
                            <td>ipsum</td>
                            <td>dolor</td>
                            <td>sit</td>
                        </tr>
                        <tr>
                            <td>1,002</td>
                            <td>amet</td>
                            <td>consectetur</td>
                            <td>adipiscing</td>
                            <td>elit</td>
                        </tr>
                        <tr>
                            <td>1,003</td>
                            <td>Integer</td>
                            <td>nec</td>
                            <td>odio</td>
                            <td>Praesent</td>
                        </tr>
                    </tbody>
                </table>
            </div> -->
    <?php include('footer.php'); ?>